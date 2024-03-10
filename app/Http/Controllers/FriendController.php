<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{
    User,
    Post,
    user_friends,
    friend_requests
};

class FriendController extends Controller
{
    protected $userID, $friendsList;

    public function __construct()
    {
        $this->middleware('jwt.verify');
        $this->userID       = auth('api')->user()->user_id;
    }
    public function getNewfeed($userID) {
        try {
            $newfeeds = Post::where([
                ['is_delete', 0],
                ['status',  0],
                ['user_id', $userID]
            ])
            ->whereIn('postable_type', ['App\Models\Post', 'App\Models\User'])
            ->orderBy('created_at', 'DESC')
            ->with('user', 'medias', 'reacts', 'shared', 'page', 'comments')
            ->limit(50)
            ->get();

            return response()->json([
                'newfeeds' => $newfeeds
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getFriends() {
        $user = User::where('user_id', auth()->user()->user_id)->first();
        return response()->json([
            // 'friends' => ($user->friendsFrom)->merge($user->friendsTo)->unique()
        ], 200);
    }

    public function getFriend($userID) {
        $user = User::where('user_id', $userID)->first();
        //Get Friends;
        $friendList = $user->acceptedFriendsTo->merge($user->acceptedFriendsFrom);
        $friendRequest = $user->pendingFriendsTo;
        $otherUser = User::where('user_id', '<>' ,$userID)->get();
        $friendSuggest = $otherUser->filter(function ($friend) use ($friendList){
            return $friendList->where('user_id', '<>', $friend->user_id)->count() > 0;
        });
        return response()->json([
            'user' => $user,
            'friends' => $friendList,
            'is_friend' =>(boolean) $friendList->where('user_id', $this->userID)->count(),
            'is_request' =>(boolean) $friendRequest->where('user_id', $this->userID)->count(),
            'friends_suggest' => $friendSuggest,
            'auth' => auth()->user()->user_id,
        ], 200);
    }

    public function acpectFriends(Request $request) {
        try {
            user_friends::where([
                ['friend_id' , $request->requested_by],
                ['user_id' ,  $this->userID],
            ])
            ->orWhere([
                ['friend_id', $this->userID],
                ['user_id', $request->requested_by],
            ])->update(['accepted' => true]);
            return response()->json([
                'message' => 'Appcet friends request success'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function unfriend(Request $request) {
        try {
            user_friends::where([
                ['friend_id' , $request->requested_by],
                ['user_id' ,  $this->userID],
            ])
            ->orWhere([
                ['friend_id', $this->userID],
                ['user_id', $request->requested_by],
            ])->update(['accepted' => 2]);
            return response()->json([
                'message' => 'Unfriend success'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function declineFriends(Request $request) {
        try {
            user_friends::where([
                ['friend_id' , $request->requested_by],
                ['user_id' ,  $this->userID],
            ])
            ->orWhere([
                ['friend_id', $this->userID],
                ['user_id', $request->requested_by],
            ])->update(['accepted' => 2]);
            return response()->json([
                'message' => 'Removed friends request'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function friendRequest(Request $request) {
        try {
            if ($request->type == 'send') {
                user_friends::create([
                    'user_id' =>  $request->requested_by,
                    'friend_id' => $this->userID,
                    'created_at' => Carbon::now()
                ]);
                //acceptedFriendsTo
                return response()->json([
                    'message' => 'Send friends request success'
                ], 200);
            } else {
                user_friends::where([
                    ['friend_id' , $request->requested_by],
                    ['user_id' ,  $this->userID],
                ])
                ->orWhere([
                    ['friend_id', $this->userID],
                    ['user_id', $request->requested_by],
                ])->delete();
                return response()->json([
                    'message' => 'unSend friends request'
                ], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
