<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/register",
     *     tags={"register"},
     *     summary="Returns a Sample API response",
     *     description="A sample greeting to test out the API",
     *     operationId="register",
     *     @OA\Parameter(
     *          name="usernamr",
     *          description="nama depan",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="nama belakang",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     * @OA\Parameter(
     *          name="email",
     *          description="nama belakang",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
   
    public function register(Request $request)
{
$validator = Validator::make($request->all(),[
'name' => 'required|string|max:255',
'email' => 'required|string|email|max:255|unique:users',
'password' => 'required|string|min:8'
]);
if($validator->fails()){
return response()->json($validator->errors());
}
$user = User::create([
'name' => $request->name,
'email' => $request->email,
'password' => Hash::make($request->password)
]);
$token = $user->createToken('auth_token')->plainTextToken;
return response()
->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
}


    /**
     * @OA\Put(
     *     path="/program",
     *     tags={"program"},
     *     summary="Returns a Sample API response",
     *     description="A sample greeting to test out the API",
     *     operationId="login",
     *     @OA\Parameter(
     *          name="firstname",
     *          description="nama depan",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lastname",
     *          description="nama belakang",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function login(Request $request)
 {
    if (!Auth::attempt($request->only('email', 'password')))
    {
    return response()->json(['message' => 'Unauthorized'], 401);
    }
    $user = User::where('email', $request['email'])->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' =>
        'Bearer',]);
 }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

}
