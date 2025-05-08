<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class for handling upload, update and delete file from eloquent
 *
 * @package humma-esport
 * @since 1.0.0
 * @author cakadi190 <cakadi190@gmail.com>
 */
class FileService
{
    public function __construct()
    {}

    /**
     * Removes a file from the storage.
     *
     * @param string $file The path to the file to be removed.
     * @return void
     */
    public static function remove(string $file): void
    {
        if (Storage::disk('public')->exists("{$file}")) {
            Storage::disk('public')->delete($file);
        }
    }

    /**
     * Uploads a file to the specified upload path.
     *
     * @param Request $request The HTTP request object.
     * @param string $uploadPath The path where the file will be uploaded.
     * @return string The path where the file was uploaded.
     */
    public static function upload(Request $request, string $uploadPath): string
    {
        if($request->file('image')) {
            $path = $request->file('image')->store($uploadPath, "public");
        } elseif($request->file('document')) {
            $path = $request->file('document')->store($uploadPath, "public");
        }

        return $path;
    }

    /**
     * Replaces the file at the given file path with a new file uploaded from the request.
     *
     * @param string $filePath The path to the file to be replaced.
     * @param Request $request The HTTP request object containing the new file.
     * @param string $uploadPath The path where the new file will be uploaded.
     * @return string The path where the new file was uploaded.
     */
    public static function replace($filePath, Request $request, string $uploadPath): string
    {
        self::remove($filePath);
        return self::upload($request, $uploadPath);
    }
}
