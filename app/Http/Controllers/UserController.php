<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; 

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_info = User::where('id', '=', Auth::user()->id)->first();

        return view('user-side.account', compact('user_info'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nick' => 'required|max:255',
            'password' => 'required|min:6|max:20',
            'email' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        if($request->input('default_image') == 'men' || $request->input('default_image') == 'girl'){
            $validatedData['avatar'] = 'public/avatar/' . $request->input('default_image') . '.png';
        }

        if($request['img'] != null){
            $user_avatar = User::where('id', '=', Auth::user()->id)->first()->avatar;
            if($user_avatar != 'public/avatar/men.png' || $user_avatar != 'public/avatar/girl.png'){
                Storage::delete('public/avatar/' . explode('/', $user_avatar)[2]);
                $path = Storage::putFile('public/avatar', $request['img']);
                $validatedData['avatar'] = 'public/avatar/' . explode('/', $path)[2];
            }else{
                $path = Storage::putFile('public/avatar', $request['img']);
                $validatedData['avatar'] = 'public/avatar/' . explode('/', $path)[2];
            }
        }

        User::where('id', '=', Auth::user()->id)->update(
            $validatedData
        );

        return back()->with('update', 'Ваш аккаунт оновлений');
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
