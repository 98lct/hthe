<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    protected $userID, $friendsList;

    public function __construct()
    {
        $this->middleware('jwt.verify');
        $this->userID = auth('api')->user()->user_id;
    }

    public function readAll(Request $request) {
        try {
            Notification::where('source_id', $this->userID)->update(['is_read' => 1]);
            return response()->json([
                'status' => 'success',
                'notifications' => Notification::where('source_id', auth()->user()->user_id)->with('user')->orderBy('created_at', 'DESC')->get()
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($notificationID) {
        // try {
        //     Notification::where('source_id', $this->userID)->update(['is_read' => 1]);
        //     return response()->json([
        //         'status' => 'success',
        //         'notifications' => Notification::where('source_id', auth()->user()->user_id)->with('user')->get()
        //     ], 200);
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
    }

    public function list(Request $request) {
        try {
            $notifications = Notification::where('source_id', $this->userID)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->limit('10')
            ->get();
            return response()->json([
                'status' => 'success',
                'notifications' => $notifications
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
