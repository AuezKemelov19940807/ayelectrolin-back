<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\View\View;

class UserController extends Controller
{
   
   public function index()
{

    if(request()->wantsJson() || request()->is('api/*')) {
        return response()->json(User::all());
    }

  
    return view('user.profile', [
        'users' => User::all()
    ]);
}

  public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));

        return response()->json($user, 201);
    }

   public function show(string $name) {

    return User::whereRaw('LOWER(name) = ?', [strtolower($name)])->firstOrFail();

    //  return User::where('name', $name)->firstOrFail();
   }


}