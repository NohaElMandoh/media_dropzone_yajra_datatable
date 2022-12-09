<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use DataTables;
use App\ImageUpload;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
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

        if ($request->ajax()) {
            $data = Album::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm" style="margin-right:5px">View</a>';
                           $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" style="margin-right:5px">Edit</a>';
                           $btn = $btn.'<a href=" '. route('media.create',['id'=>$row->id]) . '"  class="edit btn btn-secondary btn-sm" style="margin-right:5px">Add Pictures</a>';
                           $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm" style="margin-right:5px">Delete</a>';
         
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('album.index');
    }

    

    public function create(Request $request)
    {
        return view('album.create');
    }

    public function store(Request $request)
    {
         $album = Album::create([
            'name' => $request->name,
            'user_id'=>Auth::user()->id,
        ]);

        if($album){
            return redirect()->back()->with('success', 'your album created successfully');   
        }
    }
   
}
