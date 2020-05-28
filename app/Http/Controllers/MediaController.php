<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Redirect;

class MediaController extends Controller
{
    public function destroy($id)
    {
        $media = Media::find($id);

        $model_type = $media->model_type;

        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);

        notify()->success('Media Successfully Deleted.', 'Success');
        return Redirect::back();
    }
}
