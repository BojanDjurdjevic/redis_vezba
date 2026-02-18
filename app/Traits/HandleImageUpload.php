<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait  HandleImageUpload
{
    public function uploadImage($request)
    {
        $avatar = Auth::user()->avatar;
        if($avatar !== null) {
            File::delete("storage/images/avatars/$avatar"); // ovde ide puna putanja
        }

        // kompresija:

        $name = uniqid(). ".webp"; // generišemo ime slike u webp formatu
        $file = $request; // uzimamo naš fajl

        $gd = new Driver(); // kupimo novi GD driver
        $manager = new ImageManager($gd); // uzimamo iz bibl intervention/image Manager

        $image = $manager->read($file)->toWebp(85); // prepakujemo u Webp

        Storage::disk('public')->put("images/avatars/$name", (string) $image); 

        Auth::user()->update(['avatar' => $name]);   
    }
}