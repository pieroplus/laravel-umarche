<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{

  public static function upload(UploadedFile $imageFile, string $folderName): string
  {
     // Storage::putFile('public/shops', $imageFile); リサイズなしの場合
    $fileName = uniqid(rand().'_');
    $extension = $imageFile->extension();
    $fileNameToStore = $fileName. '.' . $extension;
    $resizedImage = InterventionImage::make($imageFile)
        ->resize(1920, 1080)->encode(); 
    $imageFileFullPath = 'public/' . $folderName . '/' . $fileNameToStore;
    Storage::put($imageFileFullPath, $resizedImage);
    return $fileNameToStore;
  }

}
