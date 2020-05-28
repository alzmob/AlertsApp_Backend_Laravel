<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{  

	/**
     * Display a listing of the resource.
     *
     * @return AlertCollection
     */
    public function index(Request $request)
    {
        // $own_id = $request('own_id');
 		$own_id = $request->own_id;
        $data = array(
        	'followed_users' => array(),
        	'all_users' => array(),
        	'follow_count' => array()
        );

        $data['followed_users'] = DB::table('follow')
            ->join('users', 'users.id', '=', 'follow.followed_id')
            ->select("follow.id as follow_id", "follow.own_id as own_id", "users.id as uid", "users.first_name", "users.last_name", "users.phone_number", "users.email", "users.password", "users.status", "users.profile_picture")
            ->where('follow.own_id', '=', $own_id)
            ->get();

		// SELECT a.*, COUNT(b.followed_id) as followers FROM `users` as a LEFT JOIN follow as b on a.id = b.own_id GROUP BY a.id
		//	DB::raw('COUNT(issue_subscriptions.issue_id)')
        $data['follow_count'] = DB::table('users')
        	->leftJoin('follow', 'users.id', '=', 'follow.own_id')
        	->select( DB::raw('COUNT(follow.followed_id) as followers'), 'users.id')
        	->where('users.id', '!=', $own_id)
        	->groupBy('users.id')
        	->get();

        $data['all_users'] = DB::table('users')
	        ->where('users.id', '!=', $own_id)
	    	->get();
        	


        return response()->json(['status' => 1, 'message' => "Success : Add follow id", "data" => $data ], 200);
        
    }
    //
    public function store(Request $request)
    {
        // Validate code side

        // $this->validate($request, [
        //     'video' => 'required',
        //     'title' => 'required|string',
        //     'lat' => 'required|numeric',
        //     'long' => 'required|numeric',
        //     'description' => 'required',
        //     'city' => 'required',
        // ]);
        $follow = new Follow;

        $follow->own_id = $request->own_id;
        $follow->followed_id = $request->followed_id;

        if($follow->save()) {
        	return response()->json(['status' => 1, 'message' => "Success : Add follow id"], 200);
        }else{
        	return response()->json(['status' => error, 'message' => "Failed : Add follow id"], 500);
        }
    }

    //
    public function destroy(Request $request)
    {
    	$follow_id = $request->follow_id;
        $follow = Follow::findOrFail($follow_id);

		if($follow->delete()) {
        	return response()->json(['status' => 1, 'message' => "Success : delete follow"], 200);
        }else{
        	return response()->json(['status' => error, 'message' => "Failed : delete follow "], 500);
        }
    }
}
