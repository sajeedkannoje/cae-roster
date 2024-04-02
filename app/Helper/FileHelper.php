<?php

namespace App\Helper;

use Exception;
use App\Enums\UploadPath;
use Illuminate\Support\Str;
use App\Models\Account\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 *
 */
class FileHelper
{
    /**
     * @param string $filePath
     *
     * @return void
     */
    public static function deleteIfExists(string $filePath): void
    {
        if (Storage::get($filePath)) {
            Storage::delete($filePath);
        }
    }


    /**
     * @param UploadedFile $uploadedFile
     * @param string       $folder
     * @param bool         $publicURL
     *
     * @return string
     */
    public static function uploadFile(UploadedFile $uploadedFile, string $folder = 'import', bool $publicURL = false): string
    {
        $fileExtension = $uploadedFile->extension();
        $newName = Str::random() . '_' . time() . '.' . $fileExtension;
        $uploadedFile->move(public_path($folder), $newName);
        return ( !$publicURL ) ? "{$folder}/{$newName}" : url("{$folder}/{$newName}");
    }
}
