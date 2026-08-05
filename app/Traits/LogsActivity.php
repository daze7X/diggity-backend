<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot trait to automatically register Eloquent model event listeners.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            
            // Ignore standard timestamps
            unset($changes['updated_at']);
            
            if (empty($changes)) {
                return;
            }

            $old = [];
            $new = [];
            foreach ($changes as $key => $newValue) {
                if (in_array($key, $model->getIgnoredLogFields())) {
                    continue;
                }
                $old[$key] = $model->getOriginal($key);
                $new[$key] = $newValue;
            }

            if (!empty($new)) {
                $model->logActivity('updated', $old, $new);
            }
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->getAttributes(), null);
        });
    }

    /**
     * Record the activity in the database.
     */
    protected function logActivity(string $action, ?array $old, ?array $new)
    {
        $properties = [];
        if (!is_null($old)) {
            $properties['old'] = $this->cleanActivityData($old);
        }
        if (!is_null($new)) {
            $properties['new'] = $this->cleanActivityData($new);
        }

        // Prevent empty updates from writing logs
        if ($action === 'updated' && empty($properties['new'])) {
            return;
        }

        // Record log entries
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => get_class($this),
            'subject_id' => $this->getKey(),
            'properties' => !empty($properties) ? $properties : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Cleanse logging data of sensitive or irrelevant properties.
     */
    protected function cleanActivityData(array $data): array
    {
        $ignored = $this->getIgnoredLogFields();
        return array_diff_key($data, array_flip($ignored));
    }

    /**
     * Fields excluded from logs.
     */
    protected function getIgnoredLogFields(): array
    {
        return [
            'id', 'created_at', 'updated_at', 'password', 'remember_token', 'tempTranslations'
        ];
    }
}
