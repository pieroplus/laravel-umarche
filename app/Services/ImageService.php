<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{

  public static function upload(UploadedFile|array $imageFile, string $folderName): string
  {
    // dd($imageFile);
    // Storage::putFile('public/shops', $imageFile); リサイズなしの場合
    if (is_array($imageFile)) {
      $file = $imageFile['image'];
    } else {
      $file = $imageFile;
    }
    $fileName = uniqid(rand().'_');
    $extension = $file->extension();
    $fileNameToStore = $fileName. '.' . $extension;
    $resizedImage = InterventionImage::make($file)
        ->resize(1920, 1080)->encode(); 
    $imageFileFullPath = 'public/' . $folderName . '/' . $fileNameToStore;
    Storage::put($imageFileFullPath, $resizedImage);
    return $fileNameToStore;
  }

}
