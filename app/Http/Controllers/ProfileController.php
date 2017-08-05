<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\UserProfile;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontpage.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserProfile $userProfile
     * @return \Illuminate\Http\Response
     */
    public function store(UserProfile $userProfile)
    {
        return view('frontpage.profile.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('frontpage.profile.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function profileSettings(User $user)
    {
        return view('frontpage.profile.profile_settings', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProfileRequest $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfileSettings(ProfileRequest $request, User $user)
    {

        if($request->file('profilePicture')){
            Storage::put(
                'public/avatars/'.$user->id,
                file_get_contents($request->file('profilePicture')->getRealPath())
            );

            $user->picture_url = '/storage/avatars/' . $user->id;
            $user->save();
        }



        $userProfile = $user->profile;
        if($userProfile){

            $userProfile->education = request()->education;
            $userProfile->position = request()->position;
            $userProfile->location = request()->location;
            $userProfile->skills = request()->skills;
            $userProfile->notes = request()->notes;
            $user->profile()->save($userProfile);

        } else {

            $userProfile = new UserProfile([
                'user_id' => $user->id,
                'education' => request()->education,
                'position' => request()->position,
                'location' => request()->location,
                'skills' => request()->skills,
                'notes' => request()->notes,
            ]);
            $user->profile()->save($userProfile);
        }


        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
