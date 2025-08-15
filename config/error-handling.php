<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Error Handling Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for error handling and
    | the Under Development page functionality.
    |
    */

    // Enable/disable the Under Development page in production
    'enable_under_development' => env('ENABLE_UNDER_DEVELOPMENT', true),

    // Error page title
    'page_title' => env('ERROR_PAGE_TITLE', 'Under Development - Arsh Optical'),

    // Error page message
    'page_message' => env('ERROR_PAGE_MESSAGE', 'We\'re currently working on improving this page. Please check back later or contact our support team if you need immediate assistance.'),

    // Error page icon (emoji)
    'page_icon' => env('ERROR_PAGE_ICON', '🚧'),

    // Log error details
    'log_errors' => env('LOG_ERRORS', true),

    // Generate unique error IDs
    'generate_error_ids' => env('GENERATE_ERROR_IDS', true),

    // Error ID prefix
    'error_id_prefix' => env('ERROR_ID_PREFIX', 'ERR'),

    // Show error details in development
    'show_details_in_dev' => env('SHOW_ERROR_DETAILS_IN_DEV', true),

    // Custom error conditions that trigger Under Development page
    'custom_error_conditions' => [
        'database_connection_failed',
        'cache_service_unavailable',
        'critical_system_error',
        'maintenance_mode',
        'rate_limit_exceeded',
    ],

    // HTTP status codes for different error types
    'status_codes' => [
        'general_error' => 500,
        'service_unavailable' => 503,
        'maintenance_mode' => 503,
        'rate_limited' => 429,
    ],

    // Contact information for support
    'support' => [
        'email' => env('SUPPORT_EMAIL', 'support@arshoptical.com'),
        'phone' => env('SUPPORT_PHONE', '+1-800-SUPPORT'),
        'website' => env('SUPPORT_WEBSITE', 'https://arshoptical.com/support'),
    ],

    // Auto-refresh settings
    'auto_refresh' => [
        'enabled' => env('AUTO_REFRESH_ENABLED', false),
        'interval' => env('AUTO_REFRESH_INTERVAL', 300), // 5 minutes
    ],

    // Notification settings
    'notifications' => [
        'email_admin_on_error' => env('EMAIL_ADMIN_ON_ERROR', false),
        'admin_email' => env('ADMIN_EMAIL', 'admin@arshoptical.com'),
        'slack_webhook' => env('SLACK_WEBHOOK_URL', null),
    ],
];
