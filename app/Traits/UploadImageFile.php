<?php

namespace App\Traits;

trait UploadImageFile
{
    public function newUploadFile($request, $name, $type = 'image')
    {
        if (!$request->hasFile($name)) {
            return;
        }

        $file = $request->file($name);

        if ($type == 'image') {
            $path = $file->store('uploads/images', [
                'disk' => 'public'
            ]);
            return $path;
        }
        $path = $file->store('uploads/files', [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function updateUploadFile($request, $name, $old_photo, $type = 'image')
    {
        if (!$request->hasFile($name)) {
            return $old_photo;
        }

        $file = $request->file($name);

        if ($type == 'image') {
            $path = $file->store('uploads/images', [
                'disk' => 'public'
            ]);
            return $path;
        }
        $path = $file->store('uploads/files', [
            'disk' => 'public'
        ]);
        return $path;
    }
}
