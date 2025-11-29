<?php

namespace App\Http\Controllers\Api\V1\Dropdown;

use App\Enums\General\DropdownOptionEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Dropdown\DropdownRequest;
use App\Services\Dropdown\DropdownService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DropdownController extends ApiController
{
    /**
     * Description : Dropdown controller constructor
     */
    public function __construct(
        protected DropdownService $dropdownService
    ) {
        $this->dropdownService = $dropdownService;
    }

    /**
     * getDropdown - Api to get dropdown data.
     *
     * @group Dropdown
     *
     * @authenticated
     *
     * @queryParam type string
     */
    public function getDropdown(DropdownRequest $request): JsonResponse
    {
        $type = $request->type ?? null;
        $isDecrypted = $request->is_decrypted ?? false;
        switch ($type) {
            case DropdownOptionEnum::ROLES:
                $dropdownData = $this->dropdownService->getDropdownRoles();
                break;
            case DropdownOptionEnum::GENDERS:
                $dropdownData = $this->dropdownService->getDropdownGenders();
                break;
            default:
                return $this->sendResponse(false, null, __('response.invalid_dropdown_type'), Response::HTTP_BAD_REQUEST);
        }

        $dropdownData = $isDecrypted ? $dropdownData : $this->encodeIds($dropdownData, $type);

        return $this->sendResponse(status: true, data: $dropdownData, message: __('response.dropdown_data_retrieved_successfully'));
    }

    /**
     * Encode IDs in the dropdown options.
     */
    private function encodeIds(array $dropdownOptions, string $type): array
    {
        // // List of dropdown types where id is already encrypted.
        // $alreadyEncrypted = [
        //     // config('constant.DROPDOWNS.FRANCHISORS'),
        //     // config('constant.DROPDOWNS.USER_TYPES'),
        // ];

        // // Return if id is already encrypted
        // if (in_array($type, $alreadyEncrypted)) {
        //     return $dropdownOptions;
        // }

        // Encrypt id before returning the dropdown options
        return array_map(function ($option) {
            if (isset($option['value']) && is_numeric($option['value'])) {
                $option['value'] = encryption($option['value']);
            }

            return $option;
        }, $dropdownOptions);
    }
}
