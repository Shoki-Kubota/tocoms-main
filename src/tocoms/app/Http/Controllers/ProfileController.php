<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Hobby;
use App\Models\Region;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $hobbies = Hobby::all();
        $regions = Region::all();
        $user = Auth::user();
        $userHobbies = $user->hobbies;
        $userRegionId = $user->region_id;
        $userRegion = Region::find($userRegionId);
        $initialSelectedRegion = $userRegion->name;

        $initialSelectedHobbies = $userHobbies->pluck('id')->toArray();

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'regions' => $regions,
            'hobbies' => $hobbies,
            'initialSelectedHobbies' => $initialSelectedHobbies,
            'initialSelectedRegion' => $initialSelectedRegion,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    

    public function regionupdate(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->region_id = $request->regionId;
        $user->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
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
