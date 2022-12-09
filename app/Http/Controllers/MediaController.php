<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use DataTables;
use App\ImageUpload;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
    }

    public function create(Request $request)
    {
        $album_id = $request->id;
        $album = Album::find($album_id)->first();
        return view('media.create', compact('album_id', 'album'));
    }

    public function upload(Request $request)
    {

        $image = $request->file('file');
        $name = $image->getClientOriginalName();
        $imageName = time() . '.' . $image->extension();

        $image->move(public_path('images'), $imageName);

        $imageUpload = new Picture();
        $imageUpload->name = $name;
        $imageUpload->album_id = $request->album_id;
        $imageUpload->save();

        return response()->json(['success' => $imageName]);
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        Picture::where('name', $filename)->delete();
        $path = public_path() . '/images/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function fetch(Request $request)
    {

        $album_id = $request->id;
        $album = Album::find($album_id)->first();
        $images =  $album->pictures;
        $path = public_path() . '/images/';
      $url=URL::to('/');
        $output = '<div class="row">';
        foreach ($images as $image) {
            $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="' . $url.'/images/'.$image->name . '" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                <button type="button" class="btn btn-link remove_image" id="' . $image->name . '">Remove</button>
            </div>
      ';

      

        }
        $output .= '</div>';
        echo $output;
    }
}
