<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{

    public function parent()
    {
        return Inertia::render('Parent/Dashboard');
    }

    public function bhw()
    {
        return Inertia::render('Bhw/Dashboard');
    }

    public function rhu()
    {
        return Inertia::render('Rhu/Dashboard');
    }

    public function bns()
    {
        return Inertia::render('Bns/Dashboard');
    }
}
