<?php

namespace App\Http\Controllers\Settings;

use App\Enums\File\FileOperationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Services\FileService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            $user->fill($request->only(['first_name', 'last_name', 'email', 'contact_no']));

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Handle profile photo upload if present
            if (! empty($request->file('profile_photo')) && $request->file('profile_photo')->isValid()) {
                // Get Profile Image and replace it with new profile image
                $originalPath = str_replace('<user_id>', $user->id, config('constant.USER_PROFILE_IMAGE_PATH'));
                $logoImagePath = $user->profile_picture !== null ? $user->profile_picture : null;
                $removeLogoImageName = $logoImagePath ? str_replace($originalPath, '', $logoImagePath) : null;

                $userProfileParams = [
                    'aws_s3_folder' => $user->company_id,
                    'originalPath' => $originalPath,
                    'remove' => $removeLogoImageName,
                    'generate_thumbnail' => true,
                ];

                $uploadedProfileImg = (new FileService)->save($request->profile_photo, $userProfileParams);

                if ($uploadedProfileImg && ! empty($uploadedProfileImg['status']) && $uploadedProfileImg['status'] == FileOperationStatusEnum::SUCCESS) {
                    $user->profile_picture = $uploadedProfileImg['filePath'];
                    $user->profile_thumbnail = $uploadedProfileImg['thumbnailPath'];
                } else {
                    return back()->with('error', __('message.profile_upload_failed'));
                }
            }

            $user->save();

            return to_route('profile.edit')->with('success', __('message.profile_updated_success'));
        } catch (\Throwable $th) {
            report($th);

            return back()->with('error', __('error.PROFILE_UPDATE_FAILED'));
        }
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
