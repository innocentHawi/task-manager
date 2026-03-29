<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Always return JSON for API routes
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {

                // Validation errors
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors'  => $e->errors(),
                    ], 422);
                }

                // Not found
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return response()->json([
                        'message' => 'Route or resource not found',
                    ], 404);
                }

                // Method not allowed
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                    return response()->json([
                        'message' => 'Method not allowed',
                    ], 405);
                }

                // Everything else
                return response()->json([
                    'message' => 'Server error',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        });
    }
}
