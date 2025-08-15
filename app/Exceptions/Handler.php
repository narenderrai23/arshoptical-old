<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // Check if Under Development page is enabled
        $enableUnderDevelopment = config('error-handling.enable_under_development', true);
        
        // In production, redirect all errors to Under Development page
        if (app()->environment('production') && $enableUnderDevelopment) {
            // Generate a unique error ID for tracking
            $errorId = config('error-handling.error_id_prefix', 'ERR') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Log the error with the error ID if logging is enabled
            if (config('error-handling.log_errors', true)) {
                Log::error("Production Error [{$errorId}]: " . $e->getMessage(), [
                    'error_id' => $errorId,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip(),
                ]);
            }
            
            // Return the Under Development page
            return response()->view('errors.under-development', [
                'errorId' => $errorId,
                'config' => config('error-handling')
            ], config('error-handling.status_codes.general_error', 500));
        }
        
        // In development, show the normal error pages
        return parent::render($request, $e);
    }
}
