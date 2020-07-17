<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
       
        $validate = $this->validate($request, ['name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'confirmed']);
        
        if ($validate) {
            $exist_email = DB::table('users')
                        ->where(['email'=>$request->email,
                                 'isDeleted'=>0])
                        ->first();
            if ($exist_email) {
                return response()->json(['error' => 'Email Already exist.'], 201);
            }
            else{

                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password;                
                $user->save();

                return response()->json(['success' => 'Registration successfully done.'], 200);
            }
        }
        else{
            return response()->json(['error' => 'Validation failed.'], 201);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validate = $this->validate($request, ['email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'confirmed']);
        
        if ($validate) {
            $user = DB::table('users')
                        ->where(['email'=>$request->email,
                                 'password'=>$request->password,
                                 'isDeleted'=>0])
                        ->first();
            if (!$user) {
                return response()->json(['error' => 'User not registered.'], 201);
            }
            else{
                return response()->json(['success' => 'Login successfully done.'], 200);
            }
        }
        else{
            return response()->json(['error' => 'Validation failed.'], 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
