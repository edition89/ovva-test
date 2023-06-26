<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationController extends Controller
{

    /**
     * @OA\Post(
     *  path="/api/v1/register",
     *  summary="Register",
     *  description="Register user into app",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *          required={"email","password", "name"},
     *          @OA\Property(property="email", type="string", format="email", example="user@mail.com"),
     *          @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *          @OA\Property(property="name", type="string", example="admin"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="User Account Created Successfully"),
     *        @OA\Property(property="access_token", type="string", example="18|NYsetnjDO8HclbkubosW5ZFeVkVpGsL5L72WPzjN"),
     *        @OA\Property(property="token_type", type="string", example="Bearer"),
     *     )
     *  ),
     *  @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="email", type="array",
     *                      @OA\Items(type="string", example="'The email field is required.','The email must be a valid email address.','The email has already been taken.'"),
     *                  ),
     *                  @OA\Property(property="password", type="array",
     *                      @OA\Items(type="string", example="The password field is required.")
     *                  ),
     *                  @OA\Property(property="name", type="array",
     *                      @OA\Items(type="string", example="The name field is required.")
     *                  ),
     *              )
     *          )
     *  )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $name = $request->input('name');
        $email = strtolower($request->input('email'));
        $password = $request->input('password');

        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'User Account Created Successfully',
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 201);
    }

    /**
     * @OA\Post(
     *  path="/api/v1/login",
     *  summary="Log in",
     *  description="Login user into app",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *          required={"email","password"},
     *          @OA\Property(property="email", type="string", format="email", example="user@mail.com"),
     *          @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="access_token", type="string", example="18|NYsetnjDO8HclbkubosW5ZFeVkVpGsL5L72WPzjN"),
     *        @OA\Property(property="token_type", type="string", example="Bearer"),
     *     )
     *  ),
     *  @OA\Response(
     *          response=401,
     *          description="Invalid login credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid login credentials")
     *          )
     *  ),
     *  @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="email", type="array",
     *                      @OA\Items(type="string", example="'The email field is required.','The email must be a valid email address.'"),
     *                  ),
     *                  @OA\Property(property="password", type="array",
     *                      @OA\Items(type="string", example="The password field is required.")
     *                  ),
     *              )
     *          )
     *  )
     * )
     */
    public function login(LoginRequest $request)
    {
        $email = strtolower($request->input('email'));
        $password = $request->input('password');

        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 200);
    }

    /**
     * @OA\Post(
     *  path="/api/v1/logout",
     *  summary="Logout",
     *  description="Logout user from app",
     *  tags={"Auth"},
     *  @OA\SecurityScheme(
     *  securityScheme="bearerAuth",
     *  type="http",
     *  scheme="bearer"
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Succesfully Logged out"),
     *     )
     *  ),
     *  @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *              @OA\Property(property="Description", type="string", example="Missing or Invalid Access Token"),
     *          )
     *  )
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Succesfully Logged out',
        ], 200);
    }
}
