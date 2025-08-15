#!/bin/bash

# Laravel PHP 8.0 Helper Script
# Usage: ./laravel-php80.sh [artisan command]

export PHP_BINARY="/usr/local/bin/ea-php80"
export PHP_MEMORY_LIMIT=4096M

if [ $# -eq 0 ]; then
    echo "Laravel PHP 8.0 Helper"
    echo "Usage: $0 [artisan command]"
    echo "Examples:"
    echo "  $0 --version"
    echo "  $0 migrate"
    echo "  $0 serve"
    echo "  $0 config:cache"
    echo ""
    echo "Current PHP version:"
    $PHP_BINARY --version
    exit 1
fi

cd /home/vkmdgfcx/arshopticals.in
$PHP_BINARY -d memory_limit=$PHP_MEMORY_LIMIT artisan "$@"
