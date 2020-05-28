<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $data['totalUsers'] = User::count();
        $data['totalCities'] = City::count();
        $data['totalAlerts'] = Alert::count();
        $data['totalPendingAlerts'] = Alert::where('published',false)->count();
        $data['alerts'] = Alert::where('published',false)->latest()->take(10)->get();
        return view('dashboard',$data);
    }
}
