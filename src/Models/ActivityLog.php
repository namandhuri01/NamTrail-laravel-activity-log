<?php

namespace NamTrail\ActivityLog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_name',
        'event',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    protected $casts = [
        'properties' => AsCollection::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // set table name from config file or by default set activity_logs
        $this->setTable(config('activity-log.table_name', 'activity_logs'));
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }
}