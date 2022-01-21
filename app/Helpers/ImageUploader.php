<?php

namespace App\Helpers;

use App\Constants\AppSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageUploader
{
    public static function handle(UploadedFile $file, $folder = null)
    {
        $img = self::compressAndResizeImage($file);
        $fileName = pathinfo($file->getClientOriginalName())['filename'];
        $originalExtension = pathinfo($file->getClientOriginalName())['extension'];
        $name = $fileName . time() . '.' . $originalExtension;
        $imgPath = 'public/' . ($folder ? $folder : '') . '/' . $name;
        $filePath = public_path().'/'.$imgPath;
        try {
            $img->save($filePath);
            return $imgPath;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function deleteExistingImage($imagePath)
    {
        $fullPath = storage_path('app') . '/' . $imagePath;
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    public static function compressAndResizeImage($file)
    {
        $img = Image::make($file);
        $img->resize(AppSettings::MAX_IMAGE_SIZE_PX, AppSettings::MAX_IMAGE_SIZE_PX, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        return $img;
    }

}
