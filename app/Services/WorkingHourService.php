<?php

namespace App\Services;

use App\Models\WorkingHour;
use App\Repositories\Interfaces\WorkingHourRepositoryInterface;

class WorkingHourService
{
    public function __construct(
        protected WorkingHourRepositoryInterface $workingHourRepository
    ) {}

    /**
     * Toggle working hour active status
     *
     * @param  int  $id
     * @return bool
     */
    public function toggleWorkingHourStatus($id, WorkingHour $workingHour)
    {
        return $this->workingHourRepository->update($id, [
            'is_active' => ! $workingHour->is_active,
        ]);
    }

    /**
     * Get working hours grouped by day
     *
     * @return array
     */
    public function getWorkingHoursGroupedByDay()
    {
        $workingHours = $this->workingHourRepository->getAllActive();
        $grouped = [];

        foreach ($workingHours as $workingHour) {
            $dayName = $workingHour->day_name;
            if (! isset($grouped[$dayName])) {
                $grouped[$dayName] = [];
            }
            $grouped[$dayName][] = $workingHour;
        }

        return $grouped;
    }
}
