<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('auth:api', ['except' => ['login', 'daftar']]);
    }

    public function akun()
    {
        $data = Admin::all();
        return response()->json($data);
    }

    public function daftar(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        $admin = Admin::create([
            'username' => $username,
            'password' => $password
        ]);

        return response()->json($admin);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only('username', 'password');

        if( ! $authorized = Auth::attempt($input)){
            $output = [
                'message' => 'User is not authorized'
            ];
        } else{
            $token = $this->respondWithToken($authorized);
            $output = [
                'message' => 'Anda berhasil Login',
                'token' => $token
            ];
        }
        return response()->json($output);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logout Berhasil'
        ]);
    }

    public function aktif()
    {
        return response()->json( Auth::guard()->user());
    }

    // public function guard()
    // {
    //     return Auth::guard();
    // }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }

}
