<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AlertMediaResource;
use App\Http\Resources\MediaResource;
use App\Models\City;
use App\Models\Alert;
use App\Models\AlertUpdate;
use App\Models\DeviceToken;
use App\Models\Like;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlertCollection;
use App\Http\Resources\Alert as AlertResource;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AlertCollection
     */
    public function index()
    {
        $city_id = request('city_id');
        if (isset($city_id)) {
            $alerts = Alert::with('city')
                ->withCount('likes', 'likesPrayer', 'likesSad', 'likesLove', 'likesSmile', 'updates', 'comments')
                ->where('published', true)
                ->where('city_id', $city_id)
                ->latest()
                ->get();
        } else {
            $alerts = Alert::with('city')
                ->withCount('likes', 'likesPrayer', 'likesSad', 'likesLove', 'likesSmile', 'updates', 'comments')
                ->where('published', true)
                ->latest()
                ->get();
        }
        return new AlertCollection($alerts);
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
        ]);

        $follows_user=[];
        $fcm_token=[];
        // find the city
        $city = City::where('slug', Str::slug($request->city))->first();


        // get follows from database
        $followed = Follow::where('own_id', auth('api')->user()->id)->get();
        foreach($followed as $follow)
        {
            array_push($follows_user,$follow['followed_id']); 
        }
        // get tokens from database against followers
        $tokens = User::select('id','email','fcm_token')->whereIn('id',$follows_user)->get();
        foreach($tokens as $token)
        {
            Log::info('Follower Details- email:'.$token['email'].' token: '.$token['fcm_token'].PHP_EOL);
            array_push($fcm_token, $token["fcm_token"]); 
        }
        
        $alert = new Alert();
        $alert->user_id = auth('api')->user()->id;
        if (isset($city)) {
            $alert->city_id = $city->id;
        }
        $alert->title = $request->title;
        $alert->slug = Str::slug($request->title . '-' . uniqid());
        $alert->lat = $request->lat;
        $alert->long = $request->long;
        $alert->total_view_count = 0;
        if ($request->short_description) {
            $alert->short_description = $request->short_description;
        } else {
            $alert->short_description = substr($request->description, 0, 180);
        }

        $alert->published = false;
        $alert->save();
        $tokens = User::whereIn('id',$follows_user)->select('fcm_token');
        //Store video
        if ($request->hasFile('video')) {
            $alert->addMediaFromRequest('video')->toMediaCollection('videos');
        }
        AlertUpdate::create(['alert_id' => $alert->id, 'description' => $request->description]);
        
        // send notification send alert object and all tokens of followers
        sendNotification($alert, $fcm_token);
        return new AlertResource($alert);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AlertResource
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
        return new AlertResource($alert);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function like($id, $type = "prayer")
    {
        if ($type != "prayer" && $type != "love" && $type != "sad" && $type != "smile") {
            $type = "prayer";
        }

        $alert = Alert::findOrFail($id);
        $like = $alert->likes()->where('user_id', auth('api')->id())->first();
        // if ($like) {
        //     if ($like->type == $type) {
        //         $like->delete();
        //     } else {
        //         $like->type = $type;
        //         $like->save();
        //     }
        // } else {
        $like = Like::create(
            [
                'user_id' => auth('api')->user()->id,
                'alert_id' => $alert->id,
                'type'     => $type
            ]
        );
        // }

        return new AlertResource(Alert::withCount('likes', 'likesPrayer', 'likesSad', 'likesLove', 'likesSmile')
            ->findOrFail($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function media($id)
    {
        $alert = Alert::findOrFail($id);
        return MediaResource::collection($alert->getMedia('videos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AlertResource
     */
    public function show($id)
    {
        // Update alert total view count to 1
        $alert = Alert::findOrFail($id);
        $alert->increment('total_view_count');
        return new AlertResource(Alert::with('user', 'city')
            ->withCount('likes', 'likesPrayer', 'likesSad', 'likesLove', 'likesSmile', 'updates', 'comments')
            ->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return AlertResource
     */
    public function destroy($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();
        return new AlertResource($alert);
    }

    /**
     * Get Alerts Broadcasted
     *
     * @return \Illuminate\Http\Response
     */
    public function getAlertsBroadcasted()
    {
        $city_id = request('city_id');
        $broadcasted = request('broadcasted');
        if (!isset($broadcasted)) {
            $broadcasted = 0;
        }

        if (isset($city_id)) {
            $alerts = Alert::with('city')
                ->withCount('likes', 'updates', 'comments')
                ->where('published', true)
                ->where('city_id', $city_id)
                ->where('broadcasted', $broadcasted)
                ->latest()
                ->get();
        } else {
            $alerts = Alert::with('city')
                ->withCount('likes', 'updates', 'comments')
                ->where('published', true)
                ->where('broadcasted', $broadcasted)
                ->latest()
                ->get();
        }
        return new AlertCollection($alerts);
    }

    /**
     * Update Alerts Broadcasted
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAlertsBroadcasted()
    {
        $city_id = request('city_id');
        $count = 0;

        try {
            if (isset($city_id)) {
                $count = count(Alert::select('id')->where('city_id', $city_id)->where('broadcasted', 0)->get());
                if ($count > 0) {
                    Alert::where('city_id', $city_id)
                        ->where('broadcasted', 0)
                        ->update(['broadcasted' => 1]);
                }
            } else {
                $count = count(Alert::select('id')->where('broadcasted', 0)->get());
                if ($count > 0) {
                    Alert::where('broadcasted', 0)->update(['broadcasted' => 1]);
                }
            }
            return response()->json(['status' => true, 'message' => "Alert Removed from broadcasted !!", 'total' => $count], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Something error happened. Error: " . $e->getMessage(), 'total' => $count], 200);
        }
    }


    /**
     * Update Alerts Broadcasted By Alert ID
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAlertsBroadcastedById($alert_id)
    {
        $city_id = request('city_id');
        $count = 0;

        try {
            if (isset($city_id)) {
                $count = count(Alert::select('id')->where('city_id', $city_id)->where('id', $alert_id)->where('broadcasted', 0)->get());
                if ($count > 0) {
                    Alert::where('city_id', $city_id)
                        ->where('broadcasted', 0)
                        ->update(['broadcasted' => 1]);
                }
            } else {
                $count = count(Alert::select('id')->where('id', $alert_id)->where('broadcasted', 0)->get());
                if ($count > 0) {
                    Alert::where('broadcasted', 0)->update(['broadcasted' => 1]);
                }
            }
            return response()->json(['status' => true, 'message' => "Alert Removed from broadcasted !!", 'total' => $count], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Something error happened. Error: " . $e->getMessage(), 'total' => $count], 200);
        }
    }

    public function getTotalViewCount($alert_id)
    {
        return $alert_id;
    }
}
