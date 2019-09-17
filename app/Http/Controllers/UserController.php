<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the user.
     *
     * @return \App\User
     */
    protected function user()
    {
        $user = \Auth::user();
        return $user->refresh();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('user.show', ['user' => $this->user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('user.edit', ['user' => $this->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $this->user();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $attributes = $request->only('name', 'email');

        if ($request->password) {
            $attributes['password'] = \Hash::make($request->password);
        }

        $user = $user->update($attributes);
        $request->session()->flash('status', 'Profile updated!');

        return redirect()->route('user.show', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = $this->user();
        \Auth::logout();
        $user->forceDelete();

        return redirect()->route('welcome', app()->getLocale());
    }
}
