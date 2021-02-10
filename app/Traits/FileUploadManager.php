<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Str;

trait FileUploadManager
{

  /**
   * @param UploadedFile $file
   * @param null $folder
   * @param string $disk
   * @return false|string
   */
  public function UploadSingle(UploadedFile $file, $folder = null, $disk = 'public')
  {
    $name = Str::random(25);

    return $file->storeAs(
        $folder,
        $name . "." . $file->getClientOriginalExtension(),
        $disk
    );
  }

    /**
     * @param null $path
     * @param string $disk
     */
    public function deleteSingle($path = null, $disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }
}