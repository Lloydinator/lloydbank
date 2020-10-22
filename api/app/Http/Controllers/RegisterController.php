<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    /**
     * Register a new user and automatically log them in.
     * 
     * @param $request
     */
    public function __invoke(Request $request){
        $validated = $request->validated;

        $validated['password'] = bcrypt($request->password);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $validated['password'];

        if ($user->save()){
            return app(AuthController::class)->login($request);
        }
        else {
            return response()->json([
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
