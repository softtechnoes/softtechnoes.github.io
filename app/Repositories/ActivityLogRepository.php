<?php
namespace App\Repositories;

use Illuminate\Validation\ValidationException;

class ActivityLogRepository
{
    /**
     * This function is used when API is creating logs
     *
     * @param array $ids
     * @return bool|null
     */
    public function store_activity_log($causer, $performed_on, $custom_properties, $log_name, $description)
    {
        $activity = activity($log_name)
        ->causedBy($causer)
        ->performedOn($performed_on)
        ->withProperties($custom_properties)
        ->log($description);

        return $activity;
    }
}
