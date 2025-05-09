<?php

namespace NamTrail\ActivityLog\Traits;

use NamTrail\ActivityLog\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait ActivityLogs
{
    protected $causer_id;
    protected  $causer_type;

    public static function bootActivityLogs()
    {
        foreach (static::getActivityEventsToBeLogged() as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected static function getActivityEventsToBeLogged(): array
    {
        $instance = new static;
        $events =  ['created', 'updated', 'deleted'];
        if (property_exists($instance, 'logEvents') && is_array($instance->logEvents)) {
            $events = $instance->logEvents;
        }
        return $events;
    }
    protected function logActivity(string $eventName)
    {
        if ($eventName === 'updated' && !$this->isDirty()) {
            return; 
        }
        ActivityLog::create([
            'log_name'     => $this->getLogName(),
            'event'        => $eventName,
            'subject_type' => get_class($this),
            'subject_id'   => $this->id,
            'causer_type'  => $this->getCauserType(),
            'causer_id'    => $this->getCauserId(),
            'properties'   => $this->getActivityProperties($eventName),
        ]);
    }

    protected function getCauserType()
    {
        if (isset($this->causer_type)) {
            return $this->causer_type;
        }
        
        if (isset($this->causer_id)) {
            return config('activity-log.default_causer_type', '\App\Models\User');
        }
        
        return Auth::check() ? get_class(Auth::user()) : null;
    }

    protected function getCauserId()
    {
        if (isset($this->causer_id)) {
            return $this->causer_id;
        }
        
        return Auth::id();
        
    }
    
    protected function getActivityProperties(string $event = null): array
    {
        if ($event === 'updated') {
            $dirty = $this->getDirty();

            if (property_exists($this, 'logAttributes')) {
                if (empty($this->logAttributes)) {
                    $dirty = $this->toArray();
                } else {
                    $logAttributes = array_intersect_key(
                        $dirty,
                        array_flip($this->logAttributes)
                    );
                }
            }
            $oldValues = array_intersect_key($this->getOriginal(), $dirty);

            return [
                'old' => $oldValues,
                'attributes' => $dirty,
            ];
        }

        return [
            'attributes' => $this->toArray(),
        ];
    }

    protected function getLogName(): ?string
    {
        return property_exists($this, 'logName') ? $this->logName : 'default';
    }
    
}