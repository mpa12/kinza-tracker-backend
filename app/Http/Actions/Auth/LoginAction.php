<?php

namespace App\Http\Actions\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginAction extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse|AuthResource
     */
    public function __invoke(LoginRequest $request): JsonResponse|AuthResource
    {
        $validated = $request->validated();

        $accessToken = auth()->attempt($validated);

        if (! $accessToken) {
            return response()->json(
                ['error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $refreshToken = auth()->refresh();
        $expires_date = User::getNewExpiresDate();

        $user = auth()->user();

        $user->update([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_date' => $expires_date,
        ]);

        return new AuthResource($user);
    }
}
