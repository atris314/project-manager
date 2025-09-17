<?php

use Illuminate\Support\Facades\Storage;


if (!function_exists('file_store')) {
    function file_store($u_file, $u_path, $u_prefix)
    {
        $array = array('gif', 'jpg', 'png', 'jpeg', 'pdf', 'mp4', 'webp');
        $extension = $u_file->getClientOriginalExtension();
        if (in_array($extension, $array)) {
            $file = $u_file;
            $originalName = $u_file->getClientOriginalName();
            $destinationPath = $u_path;
            $extension = $file->getClientOriginalExtension();
            $fileName = $u_prefix . md5(time() . uniqid() . '-' . $originalName) . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $f_path = $destinationPath . "" . $fileName;

            if (isImage($f_path)) {
                $f_path = str_replace('assets/', '', $f_path);
            }

            return $f_path;
        }
        return null;
    }
}

if (!function_exists('isImage')) {
    function isImage($path)
    {

        $a = getimagesize($path);
        if (!$a) {
            return false;
        }
        $image_type = $a[2];

        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP, IMAGETYPE_WEBP))) {
            return true;
        }
        return false;
    }
}




