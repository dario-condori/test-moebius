<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        $usuarios = User::where('deleted_at', null)->get();

        if($usuarios->isEmpty()){
            return response()->json([
                'state' => false,
                'message' => 'There are no users',
            ], 404);
        }
        return response()->json([
            'state' => true,
            'message' => 'Users list',
            'users' => $usuarios,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'birth_date' => 'required|date|after:date'.date('Y-m-d'),
            'gender' => 'required|in:M,F'
        ]);

        if($validacion->fails()){
            return response()->json([
                'state' => false,
                'message' => 'User not created',
                'errors' => $validacion->errors(),
            ], 400);
        }

        $usuario = new User();
        $usuario->uid = Str::uuid();
        $usuario->first_name = $request->first_name;
        $usuario->last_name = $request->last_name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->address = $request->address;
        $usuario->phone = $request->phone;
        $usuario->phone_2 = $request->phone_2;
        $usuario->postal_code = $request->postal_code;
        $usuario->birth_date = $request->birth_date;
        $usuario->gender = $request->gender;
        $usuario->save();

        return response()->json([
            'state' => true,
            'message' => 'User created',
            'users' => $usuario,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = User::where('id',$id)->where('deleted_at', null)->first();

        if(!$usuario){
            return response()->json([
                'state' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'state' => true,
            'message' => 'User found',
            'users' => $usuario,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::where('id',$id)->where('deleted_at', null)->first();

        if(!$usuario){
            return response()->json([
                'state' => false,
                'message' => 'User not found',
            ], 404);
        }

        $validacion = Validator::make($request->all(),[
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,'.$usuario->id,
            'password' => 'string|max:255',
            'address' => 'string|max:255',
            'phone' => 'string|max:255',
            'postal_code' => 'string|max:255',
            'birth_date' => 'date|after:date'.date('Y-m-d'),
            'gender' => 'in:M,F'
        ]);

        if($validacion->fails()){
            return response()->json([
                'state' => false,
                'message' => 'User not updated',
                'errors' => $validacion->errors(),
            ], 400);
        }

        if($request->has('first_name'))$usuario->first_name = $request->first_name;
        if($request->has('last_name'))$usuario->last_name = $request->last_name;
        if($request->has('email'))$usuario->email = $request->email;
        if($request->has('password'))$usuario->password = $request->password;
        if($request->has('address'))$usuario->address = $request->address;
        if($request->has('phone'))$usuario->phone = $request->phone;
        if($request->has('phone_2'))$usuario->phone_2 = $request->phone_2;
        if($request->has('postal_code'))$usuario->postal_code = $request->postal_code;
        if($request->has('birth_date'))$usuario->birth_date = $request->birth_date;
        if($request->has('gender'))$usuario->gender = $request->gender;
        $usuario->save();

        return response()->json([
            'state' => true,
            'message' => 'User updated',
            'users' => $usuario,
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = User::where('id',$id)->where('deleted_at', null)->first();

        if(!$usuario){
            return response()->json([
                'state' => false,
                'message' => 'User not found',
            ], 404);
        }

        $usuario->deleted_at = date('Y-m-d H:i:s');
        $usuario->save();

        return response()->json([
            'state' => true,
            'message' => 'User deleted',
        ], 200);
    }
}
