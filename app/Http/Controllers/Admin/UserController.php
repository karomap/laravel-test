<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('has_access_level:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:'.implode(',', array_values(UserRole::getConstants()))],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => $request->role,
        ]);

        session()->flash('status', Lang::get('User :name has been created.', ['name' => $user->name]));

        return redirect()->route('admin.user.index', app()->getLocale());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string                    $locale
     * @param  \App\User                 $user
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, User $user)
    {
        return view('user.edit', [
            'title' => Lang::get('Edit User'),
            'action' => route('admin.user.update', [$locale, $user]),
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $locale
     * @param  \App\User                 $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $locale, User $user)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:'.implode(',', array_values(UserRole::getConstants()))],
        ]);

        $attributes = $request->only('name', 'email', 'role');

        if ($request->password) {
            $attributes['password'] = \Hash::make($request->password);
        }

        $user->update($attributes);
        session()->flash('status', Lang::get('User :name has been updated.', ['name' => $user->name]));

        return redirect()->route('admin.user.index', $locale);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string                    $locale
     * @param  \App\User                 $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($locale, User $user)
    {
        /** @var \App\User $currentUser */
        $currentUser = Auth::user();

        if ($currentUser == $user) {
            return back()->withErrors(Lang::get('Could not delete current user.'));
        }

        $user->forceDelete();
        session()->flash('status', Lang::get('User :name has been deleted.', ['name' => $user->name]));

        return redirect()->route('admin.user.index', $locale);
    }
}
