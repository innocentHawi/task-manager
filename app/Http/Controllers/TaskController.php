<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    //GET /api/tasks
    public function index(Request $request)
    {
        $query = Task::orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                     ->orderBy('due_date', 'asc');

        // Optional filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No tasks found',
                'data'    => []
            ], 200);
        }

        return response()->json([
            'message' => 'Tasks retrieved successfully',
            'data'    => $tasks
        ], 200);
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => [
                'required',
                'string',
                // No duplicate title + due_date combo
                Rule::unique('tasks')->where(
                    fn($query) => $query->where('due_date', $request->due_date)
                ),
            ],
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = Task::create($validated);

        return response()->json([
            'message' => 'Task created successfully',
            'data'    => $task
        ], 201);
    }


    // PATCH /api/tasks/{id}/status
    public function updateStatus(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,done',
        ]);

        $newStatus     = $request->status;
        $currentStatus = $task->status;

        // Check status only moves forward by exactly one step
        $currentOrder = Task::$statusOrder[$currentStatus];
        $newOrder     = Task::$statusOrder[$newStatus];

        if ($newOrder !== $currentOrder + 1) {
            return response()->json([
                'message' => 'Invalid status transition. ' .
                             "Current status is '{$currentStatus}'. " .
                             "You can only move to '" . $this->nextStatus($currentStatus) . "'."
            ], 422);
        }

        $task->status = $newStatus;
        $task->save();

        return response()->json([
            'message' => 'Task status updated successfully',
            'data'    => $task
        ], 200);
    }

    // DELETE /api/tasks/{id}
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        if ($task->status !== 'done') {
            return response()->json([
                'message' => 'Forbidden. Only completed tasks can be deleted.'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }


    //GET /api/tasks/report?date=YYYY-MM-DD
    public function report(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date      = $request->date;
        $priorities = ['high', 'medium', 'low'];
        $statuses   = ['pending', 'in_progress', 'done'];
        $summary    = [];

        foreach ($priorities as $priority) {
            foreach ($statuses as $status) {
                $summary[$priority][$status] = Task::where('priority', $priority)
                    ->where('status', $status)
                    ->whereDate('due_date', $date)
                    ->count();
            }
        }

        return response()->json([
            'date'    => $date,
            'summary' => $summary
        ], 200);
    }

    // Helper: get next valid status
    private function nextStatus(string $current): string
    {
        $next = [
            'pending'     => 'in_progress',
            'in_progress' => 'done',
            'done'        => 'already at final status',
        ];

        return $next[$current];
    }
}