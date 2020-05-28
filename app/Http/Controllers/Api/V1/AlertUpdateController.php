<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlertUpdateResource;
use App\Models\AlertUpdate;

class AlertUpdateController extends Controller
{
    public function index($alertId)
    {
        $updates = AlertUpdate::where('alert_id', $alertId)->latest()->get();
        return new AlertUpdateResource($updates);
    }

    public function store(Request $request, $alertId)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        $update = AlertUpdate::create(['alert_id' => $alertId, 'description' => $request->description]);

        return new AlertUpdateResource($update);
    }

    public function destroy($alertId, $id)
    {
        $update = AlertUpdate::where('alert_id', $alertId)->findOrFail($id);
        $update->delete();
        return new AlertUpdateResource($update);
    }
}
