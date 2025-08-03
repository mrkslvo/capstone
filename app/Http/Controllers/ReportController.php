<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports');
    }

    public function bhwReport()
    {
        return view('bhw.reports');
    }


    public function bnsReport()
    {
        return view('bns.reports');
    }

    public function rhuReport()
    {
        return view('rhu.reports');
    }




}
