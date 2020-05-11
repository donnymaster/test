<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_name = '';
        $user_email = '';

        if(Auth::user()){
            $user_name = Auth::user()->nick;
            $user_email = Auth::user()->email;
        }

        return view('user-side.feedback', compact('user_name', 'user_email'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_name' => 'required|max:255',
            'user_email' => 'required|string',
            'message' => 'required|min:6'
        ]);

        if(Auth::check()){
            $validatedData = array_merge($validatedData, ['user_id' => Auth::user()->id]);
        }

        Feedback::create($validatedData);

        return back()->with('send', 'Ваше повідомлення відправлено');
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
