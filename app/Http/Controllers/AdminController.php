<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function locations()
    {
        return view('admin.locations');
    }

    public function services()
    {
        return view('admin.services');
    }

    public function categories()
    {
        return view('admin.categories');
    }
}
