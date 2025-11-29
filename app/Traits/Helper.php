<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Helper
{
    /**
     * [getUrlUsingPath to get fileUrl using path.]
     *
     * @param  string  $filePath
     * @param  string  $fileSystemDriver
     * @return array
     */
    public function getUrlUsingPath($filePath, $fileSystemDriver = null)
    {
        $fileSystemDriver = $fileSystemDriver === null ? config('constant.FILESYSTEM_DISK') : $fileSystemDriver;

        return $filePath && ! empty($filePath) && Storage::disk($fileSystemDriver)->exists($filePath) ? Storage::disk($fileSystemDriver)->url($filePath) : null;
    }
}
