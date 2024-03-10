<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    friend_requests,
    Notification,
    Feeling,
    Location
};
use Str;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'signup', 'logout']]);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'    => 400,
                'message'   => $validator->errors()
            ]);
        }
        $user = User::create(
            [
                'username'      => Str::uuid(),
                'user_id'       => Str::random(36),
                'password'      => bcrypt($request->password),
                'email'         => $request->email,
                'profile_img'   => 'default.jpg',
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'full_name'     => $request->first_name . ' ' .$request->last_name
            ]
        );
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
                'status'  => 400,
            ]);
        }

        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::id());
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'friends' => $this->getFriends(),
            'notifications' => $this->getNotifications(),
            'friend_requests' => $this->getFriendRequests(),
            'friend_suggests' => $this->getFriendSuggests(),
            'feeling_list'  => $this->getFeelings(),
            'location_list' => $this->getLocations()
        ]);
    }

    protected function getFriends(){
        // $user = User::where('user_id', auth()->user()->user_id)
        // ->with('acceptedFriendsFrom')->get();
        // return $user;
        $user = User::where('user_id', auth()->user()->user_id)->first();
        $friendList = $user->acceptedFriendsTo->merge($user->acceptedFriendsFrom);
        return $friendList;
    }

    protected function createNewToken($token){
        return response()->json([
            'status'      => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'friends' => $this->getFriends(),
            'notifications' => $this->getNotifications(),
            'friend_requests' => $this->getFriendRequests(),
            'friend_suggests' => $this->getFriendSuggests(),
            'feeling_list'  => $this->getFeelings(),
            'location_list' => $this->getLocations()
        ], 200);
    }

    protected function getNotifications(){
        return Notification::where('source_id', auth()->user()->user_id)
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->get();
    }

    protected function getFriendRequests(){
        $user = User::where('user_id', auth()->user()->user_id)->first();
        $friendRequestList = $user->pendingFriendsTo;
        return $friendRequestList;
    }

    protected function getFriendSuggests(){
        $user = User::where('user_id', auth()->user()->user_id)->first();
        //Get Friends;
        $friendList = $user->acceptedFriendsTo->merge($user->acceptedFriendsFrom);
        $otherUser = User::where('user_id', '<>' ,auth()->user()->user_id)->get();
        $friendSuggest = $otherUser->filter(function ($friend) use ($friendList){
            return $friendList->where('user_id', '<>', $friend->user_id)->count() > 0;
        });
        return $friendSuggest;
    }

    protected function getFeelings() {
        $feelingList = Feeling::where('is_actived', 1);
        return [
            'feeling' => $feelingList->where('feel_type', 'feeling')->get(),
            'activity' => Feeling::where('is_actived', 1)->where('feel_type', '<>','feeling')->get(),
        ];
    }

    protected function getLocations(){
        return Location::all();
    }
}
