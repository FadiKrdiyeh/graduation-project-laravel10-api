<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            if (!$token = auth()->attempt($validator->validated())) {
                return $this->apiResponse(false, 401, 'Login failed.');
            }

            $newToken = $this->createNewToken($token);

            return $this->apiResponse(true, 200, 'Logged in successfully.', $newToken);
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'cell_phone' => 'required',
                'subscription_package_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cell_phone' => $request->cell_phone,
                'subscription_package_id' => $request->subscription_package_id,
            ]);

            if ($user) {
                return $this->apiResponse(true, 201, 'User registered successfully.', $user);
            } else {
                return $this->apiResponse(false, 400, 'Registeration faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->logout();

            return $this->apiResponse(true, 200, 'Logged out successfully.');
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    public function refresh()
    {
        try {
            return $this->apiResponse(true, 200, 'Token refreshed successfuly.', $this->createNewToken(Auth::refresh()));
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    public function userProfile()
    {
        try {
            if (auth()->check()) {
                return $this->apiResponse(true, 200, 'Profile data fetched successfully.', auth()->user());
            } else {
                return $this->apiResponse(false, 401, 'Unauthorized.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    public function createNewToken($token)
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];
    }

    public function getAuthUserPosts ()
    {
        try {
            $userPosts = User::where('id', auth()->id())
                                ->with(['posts' => function ($query1) {
                                    $query1->select('*');
                                }])
                                ->get();

            if ($userPosts->posts->count() > 0) {
                return $this->apiResponse(true, 200, 'User posts fetched successfully.', $userPosts);
            } else {
                return $this->apiResponse(true, 404, 'User doesn\'t has any posts yet.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }
}
