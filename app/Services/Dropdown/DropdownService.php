<?php

namespace App\Services\Dropdown;

use App\Enums\General\GenderEnum;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class DropdownService
{
    public function __construct(protected RoleRepositoryInterface $roleRepository) {}

    /**
     * Get dropdown options for roles.
     */
    public function getDropdownRoles(): array
    {
        return $this->roleRepository->getAllForDropdown()
            ->map(function ($role) {
                return [
                    'label' => $role->name,
                    'value' => $role->id,
                    'slug' => $role->slug,
                ];
            })
            ->toArray();
    }

    /**
     * Get dropdown options for genders.
     */
    public function getDropdownGenders(): array
    {
        return GenderEnum::labelValueArray();
    }
}
