<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    public function index() {
        return inertia('Publication/Index');
    }
}
