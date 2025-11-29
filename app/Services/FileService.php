<?php

namespace App\Services;

use App\Enums\General\FileOperationStatusEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Gd\Encoders\PngEncoder;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

/**
 * Methods for file upload and delete
 */
class FileService
{
    /**
     * @var string
     */
    private $fileName = null;

    /**
     * @var string
     */
    private $filePath = null;

    /**
     * @var object
     */
    private $file = null;

    /**
     * @var object
     */
    private $storage = null;

    /**
     * StorageService Constructor
     */
    public function __construct()
    {
        $this->storage = Storage::disk(config('constant.FILESYSTEM_DISK'));
    }

    /**
     * Save file data
     *
     * @param  object  $file
     * @param  array  $params  contain ['originalPath']
     */
    public function save($file, $params, $fileSystemDriver = null): array
    {
        // Storage driver
        $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);

        // Uploading file visibility
        $fileVisibility = isset($params['visibility']) && (! empty($params['visibility'])) ? $params['visibility'] : 'public';

        // Set AWS bucket name for file upload
        $bucketFolderName = isset($params['aws_s3_folder']) && ! empty($params['aws_s3_folder']) ? $params['aws_s3_folder'] : (tenant() ? tenant()->id : config('constant.DEFAULT_AWS_S3_BUCKET_FOLDER_NAME'));

        // file that is going to be deleted
        $fileToRemove = isset($params['remove']) && (! empty($params['remove'])) ? $params['remove'] : null;

        $thumbnailFilePath = null;

        // Set file
        $response = $this->setFile($file);

        // Return if get error in the setting file object
        if (is_array($response)) {
            return [
                'status' => $response['status'],
                'message' => $response['message'],
            ];
        }

        $ext = $this->file->getClientOriginalExtension();

        // Generate temporary file name
        $tempFileName = isset($params['uploaded_file_name']) && (! empty($params['uploaded_file_name'])) ? $params['uploaded_file_name'] : $this->generateFileName($ext);

        // Error while generating file name
        if (is_array($tempFileName)) {
            return [
                'status' => $response['status'],
                'message' => $response['message'],
            ];
        }

        // Set file name
        $this->setFileName($tempFileName);

        try {
            $originalDirectoryPath = $bucketFolderName.'/'.$params['originalPath'];
            $this->makeDirectory($originalDirectoryPath, $fileSystemDriver);

            $originalFilePath = $originalDirectoryPath.$tempFileName;

            $storage->put($originalFilePath, file_get_contents($this->file), $fileVisibility);

            $response = $this->setFilePath($originalFilePath);

            if (is_array($response)) {
                return [
                    'status' => $response['status'],
                    'message' => $response['message'],
                ];
            }

            // generate thumbnail
            if (! empty($params['generate_thumbnail'])) {
                $thumbnailFilePath = $this->generateThumbnail($ext, $originalDirectoryPath, $tempFileName, $fileSystemDriver, $fileVisibility);
            }

            // Delete existing file if required
            if ($fileToRemove !== null) {
                $filePathArray = array_filter([$originalDirectoryPath]);
                $this->remove($params['remove'], $filePathArray, $fileSystemDriver);
            }
            Log::channel('file-service')->info(__METHOD__.'| The File saved successfully: '.$this->filePath);
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while saving a file: '.$e->getMessage());

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => $e->getMessage(),
            ];
        }

        // All good so return the response
        return [
            'status' => FileOperationStatusEnum::SUCCESS,
            'message' => 'The file uploaded successfully.',
            'fileName' => $this->fileName,
            'filePath' => $this->filePath,
            'fileFullPath' => config('constant.FILESYSTEM_DISK').'/'.$this->filePath,
            'thumbnailPath' => $thumbnailFilePath,
            // 'getInfo' => $this->getInfo(),
        ];
    }

    /**
     * Generate random name
     *
     * @param  string  $ext
     */
    public function generateFileName($ext): string|array
    {
        try {
            if (is_string($ext)) {
                return Str::random(10).'.'.$ext;
            } else {
                Log::channel('file-service')->error(__METHOD__.' | Invalid file extension found!');

                return [
                    'status' => FileOperationStatusEnum::FAIL,
                    'message' => 'Invalid file extension found!',
                ];
            }
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while generating file name: '.$e->getMessage());

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete if file exist
     *
     * @param string
     */
    public function delete($filePath, $fileSystemDriver = null): void
    {
        $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);
        // If file exist then delete
        if ($storage->exists($filePath)) {
            $storage->delete($filePath);
        }
    }

    /**
     * Make directory if not exist
     *
     * @param string
     */
    public function makeDirectory($directoryPath, $fileSystemDriver = null): void
    {
        $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);

        // Make directory
        if (! $storage->exists($directoryPath)) {
            $storage->makeDirectory($directoryPath);
        }
    }

    /**
     * Set File name
     *
     * @param  string  $fileName
     * @return \App\Services\FileUploadService
     */
    private function setFileName($fileName): array|object
    {
        try {
            if (is_string($fileName)) {
                $this->fileName = $fileName;

                return $this;
            } else {
                Log::channel('file-service')->error(__METHOD__.'| Error while setting file name!');

                return [
                    'status' => FileOperationStatusEnum::FAIL,
                    'message' => 'Error while setting file name!',
                ];
            }
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while setting file name: '.$e->getMessage());

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Set File object
     *
     * @param  string  $file
     * @return \App\Services\FileUploadService
     */
    private function setFile($file): array|object
    {
        try {
            if (is_object($file)) {
                $this->file = $file;

                return $this;
            } else {
                Log::channel('file-service')->error(__METHOD__.'| File is not found!');

                return [
                    'status' => FileOperationStatusEnum::FAIL,
                    'message' => 'File is not found!',
                ];
            }
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while set file: '.$e->getMessage());

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Set File path
     *
     * @param  string  $filePath
     * @return \App\Services\FileUploadService
     */
    private function setFilePath($filePath): array|object
    {
        try {
            if (is_string($filePath)) {
                $this->filePath = $filePath;

                return $this;
            } else {
                Log::channel('file-service')->error(__METHOD__.'| Error while setting file path!');

                return [
                    'status' => FileOperationStatusEnum::FAIL,
                    'message' => 'Error while setting file path!',
                ];
            }
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while setting file path: '.$e->getMessage());

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get file info
     */
    public function getInfo(): array
    {
        try {
            $info = [
                'filename' => $this->fileName,
                'originalFilename' => pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME),
                'filePath' => $this->filePath,
                'fileFullPath' => config('constant.FILESYSTEM_DISK').'/'.$this->filePath,
                'fileExtension' => pathinfo($this->filePath, PATHINFO_EXTENSION),
                'fileMimeType' => $this->file->getMimeType(),
                'fileSize' => $this->storage->size($this->filePath),
            ];

            return $info;
        } catch (\Exception $e) {
            Log::channel('file-service')->error("App\Services\FileUploadService::getInfo | Error: {$e->getMessage()}");

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => "Error while getting file info... ({$e->getMessage()})",
            ];
        }
    }

    /**
     * Remove file
     *
     * @param  string  $fileName
     * @param  array|string  $params
     * @param  string|null  $fileSystemDriver
     */
    public function remove($fileName, $params, $fileSystemDriver = null): array|bool
    {
        try {
            if (! empty($fileName)) {

                // Check that fileName contain filename only or is with filepath
                $position = strrpos($fileName, '/');
                $fileName = $position === false ? $fileName : substr($fileName, $position + 1);

                // Delete file and its thumbnail
                if (is_array($params)) {
                    $count = count($params);
                    for ($i = 0; $i < $count; $i++) {
                        $path = $params[$i].$fileName;
                        $this->removeFile($path, $fileSystemDriver);

                        // Also remove thumbnail version
                        $thumbPath = $params[$i].'thumb_'.$fileName;
                        $this->removeFile($thumbPath, $fileSystemDriver);
                    }
                } else {
                    $path = $params.$fileName;
                    $this->removeFile($path, $fileSystemDriver);

                    // Also remove thumbnail version
                    $thumbPath = $params.'thumb_'.$fileName;
                    $this->removeFile($thumbPath, $fileSystemDriver);
                }

                return true;
            }

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => 'File not found!',
            ];
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while removing file: '.$e->getMessage());

            return [
                'status' => FileOperationStatusEnum::FAIL,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Remove file if exist
     *
     * @param  string  $path
     * @param  string|null  $fileSystemDriver
     */
    public function removeFile($path, $fileSystemDriver = null): void
    {
        $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);
        // Remove from directory
        if ($storage->exists($path)) {
            $storage->delete($path);
        }
        Log::channel('file-service')->info(__METHOD__.'| The File deleted successfully: '.$path);
    }

    /**
     * [getFileUrl Get file url]
     *
     * @param  string  $fileSystemDriver
     * @param  string  $path
     * @param  string  $name
     * @param  string  $default
     */
    public function getFileUrl($fileSystemDriver, $path, $name, $default = null): ?string
    {
        $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);
        if ($name === null || empty($name)) {
            $path = $default;
        } else {
            if ($storage->exists($path.$name)) {
                $path = $storage->url($path.$name);
            } else {
                $path = $default;
            }
        }

        return $path;
    }

    /**
     * [getFileFullUrl Get file url]
     *
     * @param  string  $fileSystemDriver
     * @param  string  $path
     * @param  string  $default
     */
    public function getFileFullUrl($fileSystemDriver, $path, $default = null): ?string
    {
        $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);
        if ($storage->exists($path)) {
            $path = $storage->url($path);
        } else {
            $path = $default;
        }

        return $path;
    }

    /**
     * List files in a specified directory
     *
     * @param  string  $directoryPath
     * @param  string|null  $fileSystemDriver
     * @param  array|null  $params
     */
    public function listDirectoryFiles($directoryPath, $fileSystemDriver = null, $params = []): array
    {
        try {
            $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);

            // Set AWS bucket name for file upload
            $bucketFolderName = isset($params['aws_s3_folder']) && ! empty($params['aws_s3_folder']) ? $params['aws_s3_folder'] : (tenant() ? tenant()->id : config('constant.DEFAULT_AWS_S3_BUCKET_FOLDER_NAME'));
            $directoryPath = $bucketFolderName.'/'.$directoryPath; // Append bucket name to directory path

            // Ensure the directory exists
            if (! $storage->exists($directoryPath)) {
                Log::channel('file-service')->error(__METHOD__.'| Directory does not exist: '.$directoryPath);

                return [];
            }

            // Get all files in the directory
            $files = $storage->files($directoryPath);

            // Create an associative array of filename => filepath
            $fileList = [];
            foreach ($files as $filePath) {
                $fileName = basename($filePath);
                $fileList[$fileName] = $filePath;
            }

            return $fileList;
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error while listing files: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Generate and store a thumbnail image for supported file types.
     *
     *
     * @param  string  $ext  File extension (e.g., jpg, png)
     * @param  string  $originalDirectoryPath  Full directory path including tenant/bucket/folder structure
     * @param  string  $tempFileName  The temporary file name of the original uploaded image
     * @param  string|null  $fileSystemDriver  The storage disk driver to use (e.g., s3, public, local)
     * @param  string  $visibility  Visibility setting for the file (e.g., public, private)
     * @return string|null Path to the saved thumbnail image or null if generation failed
     */
    public function generateThumbnail($ext, $originalDirectoryPath, $tempFileName, $fileSystemDriver, $visibility): ?string
    {
        $supportedForThumbnail = ['jpg', 'jpeg', 'png', 'webp'];

        if (! in_array(strtolower($ext), $supportedForThumbnail)) {
            Log::channel('file-service')->info(__METHOD__.'| Thumbnail not generated: unsupported file extension ('.$ext.')');

            return null;
        }

        try {
            $storage = $fileSystemDriver === null ? $this->storage : Storage::disk($fileSystemDriver);

            $thumbnailFileName = 'thumb_'.basename($tempFileName);
            $thumbnailFilePath = $originalDirectoryPath.$thumbnailFileName;

            $encoder = match (strtolower($ext)) {
                'jpg', 'jpeg' => new JpegEncoder,
                'png' => new PngEncoder,
                'webp' => new WebpEncoder,
                default => new JpegEncoder,
            };

            // Create ImageManager with GD driver explicitly
            $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver);

            $thumbnailImage = $manager->read($this->file)
                ->resize(40, 40, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode($encoder);

            $storage->put($thumbnailFilePath, $thumbnailImage, $visibility);
            Log::channel('file-service')->info(__METHOD__.'| Thumbnail saved successfully at: '.$thumbnailFilePath);

            return $thumbnailFilePath;
        } catch (\Exception $e) {
            Log::channel('file-service')->error(__METHOD__.'| Error generating thumbnail: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Unzip file
     *
     * @param  string  $fromPath
     * @param  string  $toPath
     * @param  array  $params
     * @return array
     */
    public function unzip($file, $params = [])
    {
        $fileToRemove = isset($params['remove']) && (! empty($params['remove'])) ? $params['remove'] : null;
        $bucketFolderName = isset($params['aws_s3_folder']) && ! empty($params['aws_s3_folder']) ? $params['aws_s3_folder'] : Controller::getConfig(config('constant.AWS_S3_BUCKET_FOLDER_NAME_SLUG'), config('constant.DEFAULT_AWS_S3_BUCKET_FOLDER_NAME'));
        $originalDirectoryPath = $bucketFolderName.'/'.$params['originalPath'];

        // Set file
        $response = $this->setFile($file);
        if (is_array($response)) {
            return [
                'status' => $response['status'],
                'message' => $response['message'],
            ];
        }
        // Set temp names
        $tempFileName = $fileToRemove === null ? Str::random(20) : $fileToRemove;

        // Set file name
        $this->setFileName($tempFileName);

        $originalFilePath = $fileToRemove === null ? $originalDirectoryPath.$this->fileName : $this->fileName;
        // Make directory
        $this->makeDirectory($originalFilePath, config('constant.PUBLIC_FILESYSTEM_DISK'));

        try {
            $zip = new \ZipArchive;
            $response = $zip->open($this->file);

            if ($response === true) {
                // extract it to the path we determined above
                $zip->extractTo(storage_path('app/public/'.$originalFilePath));
                $zip->close();

                $response = $this->setFilePath($originalFilePath);
                if (is_array($response)) {
                    return [
                        'status' => $response['status'],
                        'message' => $response['message'],
                    ];
                }
            } else {
                Log::error('App\Services\FileUploadService::unzip | Error while opening zip file.');

                return [
                    'status' => 0,
                    'message' => "File couldn't open. Please try again.",
                ];
            }
        } catch (\Exception $e) {
            Log::error('App\Services\FileUploadService::unzip | Error while unzip file: '.$e->getMessage());

            return [
                'status' => 0,
                'message' => $e->getMessage(),
            ];
        }

        // All good so return the response
        return [
            'status' => 1,
            'message' => 'File unzipped.',
            'fileName' => $this->fileName,
            'filePath' => $this->filePath,
        ];
    }
}
