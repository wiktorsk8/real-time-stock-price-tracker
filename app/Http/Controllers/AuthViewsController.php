<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class AuthViewsController extends Controller
{
    public function register(): Response
    {
        return Inertia::render('RegistrationForm');
    }

    public function login(): Response
    {
        return Inertia::render('LoginForm');
    }
}