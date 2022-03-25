<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ]);

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $purchased_packages=$user->user_packages()->get();
        $user_customers=$user->user_customers()->get();
        $user_sends=$user->user_sends()->get();

        $valueSum = 0;
        $medias = Media::query()->where('status',true)->get();
        foreach ($medias as $media){
            $media->link=$media->links()->where('user_id',$user->id)->first();
            if ($media->link)
                $valueSum += strlen($media->link->value);
        }
//        return $medias;
        return view('admin.users.show',compact(
            'user',
            'valueSum',
            'purchased_packages',
            'user_customers',
            'user_sends',
            'medias'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showUserLinks(User $user)
    {

        $medias = Media::query()->where('status',true)->get();
        foreach ($medias as $media){
            $media->link=$media->links()->where('user_id',$user->id)->first();
        }
//        return $medias;
        return view('admin.users.show_user_links',compact('user','medias'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
//        return $request->all();
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
        ]);

        $user->update($request->all());

        return redirect(route('admin.users.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateUserLinks(Request $request, User $user)
    {

        $request->validate([
            'values' => 'required'
        ]);

        foreach ($request->values as $media_id => $value){
            if(Media::query()->find($media_id)){
                $link = $user->links()->where('media_id',$media_id)->first();
                // $value roulls
                if($link){
                    $link->update(['value'=>$value]);
                }else{
                    if ($value != null){
                        $user->links()->create([
                            'value'=>$value,
                            'media_id'=>$media_id
                        ]);
                    }
                }
            }
        }

        return redirect(route('admin.users.show',['user'=>$user]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status'=>true
        ]);
    }
}
