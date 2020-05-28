<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AlertCollection;
use App\Models\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyAlertController extends Controller
{
    public function index()
    {
        $published = request('published');
        if (isset($published))
        {
            $alerts = Auth::user()->alerts()->with('city')
                ->withCount('likes','updates','comments')
                ->where('published',$published === 'true' ? true : false)
                ->latest()
                ->get();
        } else {
            $alerts = Auth::user()->alerts()->with('city')
                ->withCount('likes','updates','comments')
                ->latest()
                ->get();
        }
        return new AlertCollection($alerts);
    }
}
