# Laravel Activity Log

A Laravel package that provides easy activity logging for your Eloquent models.

## Installation

You can install the package via composer:

```bash
composer require NamTrail/laravel-activity-log
```

After installing, publish the config file and migrations:

```bash
php artisan vendor:publish --provider="NamTrail\ActivityLog\Providers\ActivityLogServiceProvider"
```

Then run the migrations:

```bash
php artisan migrate
```

## Configuration

You can configure the package by editing the `config/activity-log.php` file:

```php
return [
    // default table name is activity_logs. But you can also set the table name via env variable. Define ACTIVITY_LOG_TABLE_NAME variable in env file
    'table_name' => env('ACTIVITY_LOG_TABLE_NAME', 'activity_logs'),
    
    'default_log_name' => 'default',

    'default_causer_type' => '\App\Models\User',
];
```

## Usage

### Basic Usage

Add the `ActivityLog` trait to your model:

```php
use NamTrail\ActivityLog\Traits\ActivityLog;

class YourModel extends Model
{
    use ActivityLog;
    
    
}
```

### Customizing Logged Events

To customize which events you logged, add a `$logEvents` property to your model:

```php
    protected $logEvents = ['created', 'updated']; // Only log creation and updates

```

### Customizing Logged Attributes

By default, all model attributes are logged. But you will specify which attributes to log by adding a `$logAttributes` property:

```php   
    protected $logAttributes = ['name', 'email']; // Only log changes to these attributes

```

### Custom Log Name

You can specify a custom log name by defineing `$logName` property in your model:

```php
    
    protected $logName = 'users';
    

```

### Accessing the Logs

You can query the activity logs using the `ActivityLog` model:

```php
use NamTrail\ActivityLog\Models\ActivityLog;

// Get all logs
$logs = ActivityLog::all();

```