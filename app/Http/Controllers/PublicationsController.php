<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicationsController extends Controller
{
    public function index() {
        return inertia('Publication/Index');
    }

    public function show() {
        return Inertia::render('Publication/Show');
    }
}
