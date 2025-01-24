<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Hobby;
use App\Models\User;
use inertia\inertia;

class SearchController extends Controller
{
    public function indexbyregion()
    {
        $regions = Region::all();
        return Inertia::render('SearchByRegion', ['regions' => $regions]);
    }

    public function indexbyhobby()
    {
        $hobbies = Hobby::all();
        return Inertia::render('SearchByHobby', ['hobbies' => $hobbies]);
    }
}
