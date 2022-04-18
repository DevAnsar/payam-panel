<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\lib\FileUploader;
use App\lib\SafeSettings;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use FileUploader,SafeSettings;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $packagesQuery = Package::query();
        if ($request->has('status') && ( $request->input('status') == 'true' || $request->input('status') == 'false') ){
            $packagesQuery->whereStatus($request->status);
        }
        $packages = $packagesQuery->get();
        $smsTariff= $this->getSmsTariff();

        return view('admin.packages.index',compact('packages','smsTariff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $smsTariff= $this->getSmsTariff();
        return view('admin.packages.create',compact('smsTariff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'count' => 'required',
            'days' => 'required',
            'icon' => 'nullable',
            'status' => 'required',
        ]);
        try {
            $file = null;
            if($request->hasFile('icon')){
                $file = $this->saveFile($request->file('icon'),'images/packages');
            }

            Package::create([
                'title'=>$request->input('title'),
                'price'=>$request->input('price'),
                'count'=>$request->input('count'),
                'days'=>$request->input('days'),
                'icon'=>$file != null ? $file : null,
                'status'=>$request->input('status')
            ]);

            return redirect(route('admin.packages.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $smsTariff= $this->getSmsTariff();
        return view('admin.packages.edit',compact('package','smsTariff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'count' => 'required',
            'days' => 'required',
            'icon' => 'nullable',
            'status' => 'required',
        ]);

        try {
            $file = null;
            if($request->hasFile('icon')){
                $file = $this->saveFile($request->file('icon'),'images/packages');
            }
            $package->update([
                'title'=>$request->input('title'),
                'price'=>$request->input('price'),
                'count'=>$request->input('count'),
                'days'=>$request->input('days'),
                'icon'=>$file != null ? $file : $package->icon,
                'status'=>$request->input('status')
            ]);

            return redirect(route('admin.packages.index'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return response()->json([
            'status'=>true
        ]);
    }
}
