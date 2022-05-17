<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{
    /**
     * Creates a new access token based on provided user credentials.
     */
    public function token(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->respondForbidden(__('auth.failed'));
        }

        /** @var User $user */
        $user = User::where('email', $request['email'])->firstOrFail();

        return $this->respondWithToken($user->createToken('auth_token'));
    }

    /**
     * Returns user profile information.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->respondWithSuccess(UserProfileResource::make($request->user()));
    }

    /**
     * Destroys the current access token.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->respondOk(__('auth.logout'));
    }

    /**
     * Creates a new access token response.
     */
    protected function respondWithToken(NewAccessToken $token): JsonResponse
    {
        return $this->respondWithSuccess([
            'access_token' => $token->plainTextToken,
            'expires_in_minutes' => config('sanctum.expiration'),
            'expires_at' => Carbon::now()->addMinutes(config('sanctum.expiration')),
        ]);
    }
}
