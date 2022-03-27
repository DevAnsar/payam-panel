<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\lib\FileUploader;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias = Media::all();
        return view('admin.medias.index',compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.medias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'base_url' => 'nullable',
            'icon' => 'nullable',
            'status' => 'required',
        ]);
        try {
            $file = null;
            if($request->hasFile('icon')){
                $file = $this->saveFile($request->file('icon'),'images/medias');
            }
            Media::create([
                'title'=>$request->input('title'),
                'base_url'=>$request->input('base_url'),
                'icon'=> $file != null ? $file : null,
                'status'=>$request->input('status')
            ]);

            return redirect(route('admin.medias.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        return view('admin.medias.edit',compact('media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        $request->validate([
            'title' => 'required',
            'base_url' => 'nullable',
            'icon' => 'nullable',
            'status' => 'required',
        ]);

        try {
            $file = null;
            if($request->hasFile('icon')){
                $file = $this->saveFile($request->file('icon'),'images/medias');
            }
            $media->update([
                'title'=>$request->input('title'),
                'base_url'=>$request->input('base_url'),
                'icon'=>$file != null ? $file : $media->icon,
                'status'=>$request->input('status')
            ]);
            return redirect(route('admin.medias.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json([
            'status'=>true
        ]);
    }
}
