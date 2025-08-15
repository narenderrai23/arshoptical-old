#!/bin/bash

# Switch to PHP 8.0 script
echo "Switching to PHP 8.0..."

# Update the default PHP symlink to point to PHP 8.0
if [ -L /usr/local/bin/php ]; then
    echo "Updating PHP symlink to PHP 8.0..."
    sudo rm /usr/local/bin/php
    sudo ln -s /opt/cpanel/ea-php80/root/usr/bin/php /usr/local/bin/php
fi

# Update composer to use PHP 8.0
echo "Updating composer to use PHP 8.0..."
/usr/local/bin/ea-php80 /usr/local/bin/composer install --no-dev --optimize-autoloader

# Update Artisan to use PHP 8.0
echo "Updating Artisan commands to use PHP 8.0..."
/usr/local/bin/ea-php80 artisan --version

echo "PHP 8.0 setup complete!"
echo "Current PHP version:"
/usr/local/bin/ea-php80 --version
