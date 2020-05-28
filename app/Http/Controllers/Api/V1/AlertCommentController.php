<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlertCommentResource;
use App\Models\AlertComment;

class AlertCommentController extends Controller
{
    public function index($alertId)
    {
        $comments = AlertComment::where('alert_id', $alertId)->latest()->get();
        return AlertCommentResource::collection($comments);
    }

    public function store(Request $request, $alertId)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $comment = AlertComment::create(['user_id' => auth('api')->user()->id, 'alert_id' => $alertId, 'body' => $request->comment]);
        return new AlertCommentResource($comment);
    }

    public function destroy($alertId, $id)
    {
        $comment = AlertComment::where('alert_id', $alertId)->findOrFail($id);
        $comment->delete();
        return new AlertCommentResource($comment);
    }
}
