<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class HomeController extends Controller
{

    public function login()
    {
        $users = User::where("email", "lucas@gmail.com")->first();

        return redirect('/home');
    }

    public function home()
    {
        // executado como server side

        $users = User::all();

        return Inertia::render("Home/HomeView", [
            "users" => $users,
        ]);
    }

    public function show()
    {
        $users = User::all();

        return Inertia::render("Admin/DashboardView", [
            "timer" => now(),
            "users" => $users
        ]);
    }
}
