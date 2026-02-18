<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAvatarRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function changeAvatar(NewAvatarRequest $request)
    {
        
        $avatar = Auth::user()->avatar;

        if($avatar !== null) {
            File::delete("storage/images/avatars/$avatar"); // ovde ide puna putanja
        }
        
        /*
        $filePath = $request->file('profile_image')
            ->store('images/avatars', 'public');
        
        $name = basename($filePath); // Ova funk služi za dobijanje imena samo slike, ne cele putanje
        */

        // kompresija:

        $name = uniqid(). ".webp"; // generišemo ime slike u webp formatu
        $file = $request->file('profile_image'); // uzimamo naš fajl

        $gd = new Driver(); // kupimo novi GD driver
        $manager = new ImageManager($gd); // uzimamo iz bibl intervention/image Manager

        $image = $manager->read($file)->toWebp(85); // prepakujemo u Webp

        Storage::disk('public')->put("images/avatars/$name", (string) $image); 

        Auth::user()->update(['avatar' => $name]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
