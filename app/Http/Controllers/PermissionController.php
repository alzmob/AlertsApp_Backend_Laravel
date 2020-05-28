<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::latest()->get();
        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $app = app();
        $routes = $app->routes->getRoutes();
        $permissions = Permission::all();
        return view('permissions.form',compact('routes','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'permissions' => 'required|unique:permissions,name'
        ]);
        foreach ($request->permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
        notify()->success('Permission Successfully Generated','Success');
        return redirect()->route('app.permissions.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {   $permission->delete();
        notify()->success('Permission Successfully Deleted','Success');
        return redirect()->back();
    }
}
