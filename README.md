## Live URL
https://https://task-manager-production-e7ba.up.railway.app

## API Endpoints
GET https://https://task-manager-production-e7ba.up.railway.app/api/tasks  -  Lists tasks
POST https://task-manager-production-e7ba.up.railway.app/api/tasks  -  Creates tasks. JSON Example, 
    {
     "title": "Fix login bug",
     "due_date": "2026-04-05",
     "priority": "high"
    }
PATCH https://task-manager-production-e7ba.up.railway.app/api/tasks/1/status  -  Update status. Example,
    {
     "status": "in_progress"
    }
DELETE https://task-manager-production-e7ba.up.railway.app/api/tasks/1  -  Delete tasks. (Only Done tasks).
GET  https://task-manager-production-e7ba.up.railway.app/api/tasks/report?date=2026-04-01  -  Daily Report
