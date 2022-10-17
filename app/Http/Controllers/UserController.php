<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
       $formFields = $request->validate([
         'name' => 'required',
         'email' => ['required', 'email', Rule::unique('users', 'email')],
         'password' => ['required', 'confirmed']
       ]);

       $formFields['password'] = bcrypt($request->password);

       $user = User::create($formFields);

       $token = $user->createToken('token')->plainTextToken;

       $response = ['user' => $user, 'token' => $token];

       return response($response, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return ['message' => 'Logged out.'];
    }

    public function login(Request $request)
    {
       $formFields = $request->validate([
         'email' => ['required', 'email'],
         'password' => 'required'
       ]);

       $user = User::where('email', $request->email)->first();

       if(!$user || !Hash::check($request->password, $user->password))
       {
          return response(['message' => 'Bad credentials'], 401);
       }

       $token = $user->createToken('token')->plainTextToken;

       $response = ['user' => $user, 'token' => $token];

       return response($response, 201);
    }
}
