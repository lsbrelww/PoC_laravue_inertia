<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{

    public function home()
    {
        // executado como server side
        $users = User::all();

        return Inertia::render("Home/HomeView", [
            "users" => $users
        ]);
    }
}
