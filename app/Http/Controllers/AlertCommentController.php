<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\AlertComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AlertCommentController extends Controller
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
    public function store(Request $request, $alertId)
    {
        $this->validate($request, [
            'comment_body' => 'required'
        ]);
        AlertComment::create(['user_id' => Auth::id(), 'alert_id' => $alertId, 'body' => $request->comment_body]);
        notify()->success('Comment Successfully Published.', 'Success');
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AlertComment  $alertComment
     * @return \Illuminate\Http\Response
     */
    public function show(AlertComment $alertComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AlertComment  $alertComment
     * @return \Illuminate\Http\Response
     */
    public function edit(AlertComment $alertComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AlertComment  $alertComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlertComment $alertComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AlertComment  $alertComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($alertId, $commentId)
    {
        Alert::findOrFail($alertId)->comments->find($commentId)->delete();
        notify()->success('Comment Successfully Deleted.', 'Success');
        return Redirect::back();
    }
}
