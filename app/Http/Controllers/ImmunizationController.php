<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    public function index()
    {

        return view("admin.immunizationRecord");
    }
}
