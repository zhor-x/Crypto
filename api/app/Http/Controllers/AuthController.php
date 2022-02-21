<?php

namespace App\Http\Controllers;

use App\Helpers\AuthConstant;
use App\Helpers\HttpConstant;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), HttpConstant::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return $this->errorResponse(AuthConstant::UNAUTHORIZED, HttpConstant::HTTP_UNAUTHORIZED);
        }
        return $this->createNewToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->successResponse(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return $this->successResponse(null, AuthConstant::LOGOUT);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }




    /**
     * Get the token json structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        return $this->successResponse([
            AuthConstant::ACCESS_TOKEN => $token,
            AuthConstant::TOKEN_TYPE => AuthConstant::BEARER,
            AuthConstant::EXPIRES_IN => auth()->factory()->getTTL() * 60,
        ]);
    }
}
