<?php

namespace App\Http\Actions\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RefreshRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RefreshAction extends Controller
{
    /**
     * Refresh a token.
     *
     * @param RefreshRequest $request
     *
     * @return JsonResponse|AuthResource
     */
    public function __invoke(RefreshRequest $request): JsonResponse|AuthResource
    {
        $user = User::where([
            ['refresh_token', '=', $request->refresh_token],
        ])->first();

        if (! $user) {
            return response()->json(
                ['error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $accessToken = auth()->login($user);
        $refreshToken = auth()->refresh();
        $expires_date = User::getNewExpiresDate();

        $user->update([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_date' => $expires_date,
        ]);

        return new AuthResource($user);
    }
}
