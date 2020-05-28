<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\AlertUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AlertUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$alertId)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        AlertUpdate::create(['alert_id' => $alertId, 'description' => $request->description]);
        notify()->success('Alert Update Successfully Published.', 'Success');
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AlertUpdate  $alertUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(AlertUpdate $alertUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AlertUpdate  $alertUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(AlertUpdate $alertUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AlertUpdate  $alertUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlertUpdate $alertUpdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AlertUpdate  $alertUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy($alertId, $updateId)
    {
        Alert::findOrFail($alertId)->updates->find($updateId)->delete();
        notify()->success('Alert Update Successfully Deleted.', 'Success');
        return Redirect::back();
    }
}
