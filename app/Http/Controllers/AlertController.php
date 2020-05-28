<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Alert;
use App\Models\AlertUpdate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Alert::latest()->get();
        return view('alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['cities'] = City::select('id', 'name')->get();
        $data['users'] = User::select('id', 'first_name', 'last_name')->get();
        return view('alerts.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'video' => 'required',
            'title' => 'required|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'description' => 'required',
            'city' => 'required',
            'user' => 'required',
        ]);
        $alert = new Alert();
        $alert->user_id = $request->user;
        $alert->city_id = $request->city;
        $alert->title = $request->title;
        $alert->slug = Str::slug($request->title);
        $alert->lat = $request->lat;
        $alert->long = $request->long;
        if ($request->filled('published')) {
            $alert->published = true;
        } else {
            $alert->published = false;
        }

        if ($request->short_description) {
            $alert->short_description = $request->short_description;
        } else {
            $alert->short_description = substr($request->description, 0, 180);
        }
        $alert->save();
        //Store video
        if ($request->hasFile('video')) {
            $alert->addMediaFromRequest('video')->toMediaCollection('videos');
        }

        AlertUpdate::create(['alert_id' => $alert->id, 'description' => $request->description]);

        notify()->success('Alert Successfully Saved.', 'Success');
        return Redirect::route('app.alerts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $this->validate($request, [
            'video' => 'required',
            'description' => 'nullable|string',
        ]);
        $alert = Alert::findOrFail($id);
        //Store video
        if ($request->hasFile('video')) {
            $alert->addMediaFromRequest('video')->toMediaCollection('videos');
        }

        AlertUpdate::create(['alert_id' => $alert->id, 'description' => $request->description]);

        notify()->success('Alert Video Successfully Uploaded.', 'Success');
        return Redirect::back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        $mediaItems = $alert->getMedia('videos');

        return view('alerts.show', compact('alert', 'mediaItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        $data['alert'] = $alert;
        $data['cities'] = City::select('id', 'name')->get();
        $data['users'] = User::select('id', 'first_name', 'last_name')->get();
        return view('alerts.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'lat' => 'required',
            'long' => 'required',
            'city' => 'required',
            'user' => 'required',
        ]);

        $alert->user_id = $request->user;
        $alert->city_id = $request->city;
        $alert->title = $request->title;
        $alert->slug = Str::slug($request->title);
        $alert->lat = $request->lat;
        $alert->long = $request->long;
        if ($request->filled('published')) {
            $alert->published = true;
        } else {
            $alert->published = false;
        }
        $alert->save();

        notify()->success('Alert Successfully Updated.', 'Success');
        return Redirect::route('app.alerts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();
        notify()->success('User Successfully Deleted.', 'Success');
        return Redirect::back();
    }
}
