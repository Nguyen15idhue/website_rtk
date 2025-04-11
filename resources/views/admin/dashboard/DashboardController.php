<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View; // Import View

class DashboardController extends Controller
{
     public function index(): View // Return type hint
     {
         // Pass data to the view later
         return view('admin.dashboard.index');
     }
}
