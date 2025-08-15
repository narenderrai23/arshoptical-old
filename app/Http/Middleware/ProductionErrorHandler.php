<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ProductionErrorHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Check if we're in production mode
            if (app()->environment('production')) {
                // Check for specific error conditions
                if ($this->shouldShowUnderDevelopment($request)) {
                    return $this->showUnderDevelopmentPage($request);
                }
            }
            
            return $next($request);
        } catch (\Exception $e) {
            // If middleware itself fails, show under development page
            if (app()->environment('production')) {
                return $this->showUnderDevelopmentPage($request, $e);
            }
            throw $e;
        }
    }
    
    /**
     * Check if we should show the under development page
     */
    private function shouldShowUnderDevelopment($request)
    {
        // Add your custom logic here to determine when to show under development page
        // For example: maintenance mode, specific error conditions, etc.
        
        // Check if maintenance mode is enabled
        if (app()->isDownForMaintenance()) {
            return true;
        }
        
        // Check for specific error conditions
        $errorConditions = [
            'database_connection_failed',
            'cache_service_unavailable',
            'critical_system_error'
        ];
        
        foreach ($errorConditions as $condition) {
            if (session()->has($condition)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Show the under development page
     */
    private function showUnderDevelopmentPage($request, $exception = null)
    {
        $errorId = 'MIDDLEWARE-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        if ($exception) {
            Log::error("Middleware Error [{$errorId}]: " . $exception->getMessage(), [
                'error_id' => $errorId,
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);
        }
        
        return response()->view('errors.under-development', [
            'errorId' => $errorId
        ], 503);
    }
}
