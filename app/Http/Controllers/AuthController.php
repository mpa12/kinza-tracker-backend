<?php

namespace App\Http\Controllers;

use App\Http\Actions\Auth\LoginAction;
use App\Http\Actions\Auth\RefreshAction;
use App\Http\Actions\Auth\RegisterAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            'auth:api',
            ['except' => ['login', 'register', 'refresh']]
        );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginAction $action
     * @param LoginRequest $request
     *
     * @return JsonResponse|AuthResource
     *
     * @OA\Post(
     *      path="/api/auth/login",
     *      summary="User login",
     *      description="User login with email and password",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="User login data",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="email@mail.ru"),
     *              @OA\Property(property="password", type="string", example="password")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User successfully logged in",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="access_token", type="string", example="token"),
     *                  @OA\Property(property="refresh_token", type="string", example="token"),
     *                  @OA\Property(property="expires_date", type="string", format="date-time", example="2024-01-07T09:27:14.580415Z"),
     *                  @OA\Property(property="token_type", type="string", example="bearer")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorized")
     *          )
     *      )
     *  )
     */
    public function login(LoginAction $action, LoginRequest $request): JsonResponse|AuthResource
    {
        return ($action)($request);
    }

    /**
     * Register a User.
     *
     * @param RegisterAction $action
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *      path="/api/auth/register",
     *      summary="Register a new user",
     *      description="Register a new user",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="User registration data",
     *          @OA\JsonContent(
     *              required={"email", "password", "password_confirmation", "name"},
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="password", type="string", example="example"),
     *              @OA\Property(property="password_confirmation", type="string", example="example"),
     *              @OA\Property(property="name", type="string", example="example")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User successfully registered",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User successfully registered"),
     *              @OA\Property(property="user", type="object",
     *                  @OA\Property(property="name", type="string", example="admin"),
     *                  @OA\Property(property="email", type="string", example="email@mail.ru"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-07T06:50:59.000000Z"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-07T06:50:59.000000Z"),
     *                  @OA\Property(property="id", type="integer", example=1)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="array",
     *                  @OA\Items(type="string", example="The email has already been taken.")
     *              ),
     *              @OA\Property(property="password", type="array",
     *                  @OA\Items(type="string", example="The password field confirmation does not match.")
     *              )
     *          )
     *      )
     *  )
     */
    public function register(RegisterAction $action, RegisterRequest $request): JsonResponse
    {
        return ($action)($request);
    }

    /**
     * Refresh a token.
     *
     * @param RefreshAction $action
     * @param RefreshRequest $request
     *
     * @return JsonResponse|AuthResource
     *
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      summary="Refresh a token",
     *      description="Refresh a token",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Refresh token",
     *          @OA\JsonContent(
     *              required={"refresh_token"},
     *              @OA\Property(property="refresh_token", type="string", example="token")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User tokens have been updated",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="access_token", type="string", example="token"),
     *                  @OA\Property(property="refresh_token", type="string", example="token"),
     *                  @OA\Property(property="expires_date", type="string", format="date-time", example="2024-01-07T09:27:19.966543Z"),
     *                  @OA\Property(property="token_type", type="string", example="bearer")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorized")
     *          )
     *      )
     *  )
     */
    public function refresh(RefreshAction $action, RefreshRequest $request): JsonResponse|AuthResource
    {
        return ($action)($request);
    }
}
