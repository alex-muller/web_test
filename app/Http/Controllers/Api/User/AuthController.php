<?php declare(strict_types = 1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

final class AuthController extends ApiController
{

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials,true)) {
            return response()->json(['status' => 'success']);
        }

        abort(401);
    }

}