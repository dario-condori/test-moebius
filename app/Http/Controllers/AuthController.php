<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Login de nuevo
     * Metodo: POST
     * Url: http://test-dev.test/api/login
     * Parámetros en formato: JSON
     *      {
     *           "email": "juan.perez@gmail.com",
     *           "password": "juanp",
     *       }
     * Respuesta en formato JSON
     *      Sino coincide los credenciales a un usuario valido:
     *          state: 401
     *          menssage: 'Unauthorized'
     *          errors: Lista errores de validación
     *      Si existe el usuario con credenciales correctas:
     *          state: 200
     *          menssage: 'User authenticated successfully'
     *          user: Datos del usuario en formato JSON
     *          authorization: 
     *              'token' => $token,
     *              'type' => 'bearer',
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        // $token = Auth::attempt($credentials);
        // if (!$token) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthorized',
        //     ], 401);
        // }

        // $user = Auth::user();
        // return response()->json([
        //     'status' => true,
        //     'message' => 'User authenticated successfully',
        //     'user' => $user,
        //     'authorization' => [
        //         'token' => $token,
        //         'type' => 'bearer',
        //     ]
        // ], 200);

    }

    /**
     * Logout de usuarios
     * Metodo: POST
     * Url: http://test-dev.test/api/logout
     * Parámetros: Ninguna
     * Respuesta en formato JSON
     *          state: 200
     *          menssage: 'Successfully logged out'
     */
    public function logout()
    {
        try{
            Auth::guard('api')->logout();
        }catch(JWTException $e){
            return response()->json([
                'status' => false,
                'message' => $e,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);

        // Auth::logout();
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Successfully logged out',
        // ], 200);
    }

    /**
     * Regeneracion de token de autenticación
     * Metodo: POST
     * Url: http://test-dev.test/api/refresh
     * Parámetros: Ninguna
     * Respuesta en formato JSON
     *          state: 200
     *          menssage: 'Refresh token successfully'
     *          user: Usuario autenticado
     *          authorization: 
     *              'token' => $token,
     *              'type' => 'bearer',
     */
    public function refresh()
    {
        return response()->json([
            'status' => true,
            'message' => 'Refresh token successfully',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ], 200);
    }
}
