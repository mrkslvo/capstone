<?php

namespace App\Http\Controllers;

use App\Models\Maternal_records;
use App\Models\MaternalProfiles;
use Illuminate\Http\Request;

class MaternalRecords extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $maternalProfiles = MaternalProfiles::all();
        return view("admin.maternalRecords", ["maternalProfiles" => $maternalProfiles]);
    }
}
