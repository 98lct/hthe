<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Image;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;

use App\Models\{
    Comment,
    Media,
    Post,
    React,
    User,
    Share,
    Notification,
    Feeling
};
use App\Events\NotificationPublished;

class NewfeedController extends Controller
{
    protected $userID, $friendsList;

    public function __construct()
    {
        $this->middleware('jwt.verify');
        $this->userID = auth('api')->user()->user_id;
    }

    public function index(Request $request)
    {
        try {
            $request->user_id = null;
            if (is_null($request->user_id)){
                // check users no post
                // $userSource = User::where('user_id', $this->userID)->with('pages','acceptedFriendsFrom', 'acceptedFriendsTo')->first();
                // $friendsList = ($userSource->acceptedFriendsFrom->pluck('friend_id'))->merge($userSource->acceptedFriendsTo->pluck('user_id'))->unique();

                // $pageList = $userSource->pages->pluck('page_id');
                // $userID = $this->userID;
                // if ($friendsList->isNotEmpty()) {
                //     //A
                //     $newfeeds = Post::where(function ($query) use ($friendsList, $pageList) {
                //         return $query->where('user_id', $this->userID)
                //         ->when(!is_null($friendsList), function ($query) use ($friendsList) {
                //             return $query->orWhereIn('user_id', $friendsList)
                //             ->where('user_id', '<>', $this->userID)->whereIn('status', [0, 1]);
                //         })
                //         ->when(!is_null($pageList), function ($query) use ($pageList) {
                //             return $query->orWhereIn('postable_id', $pageList)
                //             ->where('postable_type', 'App\Models\Page')
                //             ->whereIn('status', [0, 1]);
                //         });
                //     })
                //     ->where('is_delete', 0)
                //     ->orderBy('created_at', 'DESC')
                //     ->with('user', 'medias', 'reacts', 'shared', 'page')
                //     ->limit(50)
                //     ->get();

                // } else {
                //     // B
                //     $newfeeds = Post::where([
                //         ['is_delete', 0],
                //         ['status', 0],
                //     ])
                //     ->when(!is_null($pageList), function ($query) use ($pageList) {
                //         return $query->whereIn('postable_id', $pageList)
                //         ->orWhere('postable_type', 'App\Models\Page')
                //         ->whereIn('status', [0, 1]);
                //     })
                //     ->orderBy('created_at', 'DESC')
                //     ->with('user', 'medias', 'reacts', 'shared', 'page', 'comments')
                //     ->limit(50)
                //     ->get();
                // }
                $newfeeds = Post::where([
                    ['is_delete', 0],
                    ['status', 0],
                ])
                ->orderBy('created_at', 'DESC')
                ->with('user', 'medias', 'reacts', 'shared', 'page', 'comments', 'activitys', 'feelings', 'locations')
                ->limit(50)
                ->get();
                return response()->json([
                    'newfeeds' => $newfeeds,
                ], 200);
            } else {
                $newfeeds = Post::where([
                    ['is_delete', 0],
                    ['status',  0],
                    ['user_id', $request->user_id]
                ])
                ->whereIn('postable_type', ['App\Models\Post', 'App\Models\User'])
                ->orderBy('created_at', 'DESC')
                ->with('user', 'medias', 'reacts', 'shared', 'page', 'comments', 'activitys', 'feelings', 'locations')
                ->limit(50)
                ->get();

                return response()->json([
                    'newfeeds' => $newfeeds,
                ], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getNewFeed($newfeedID)
    {
        return Post::where('post_id', $newfeedID)->with('user', 'medias', 'comments', 'reacts', 'shared', 'page', 'feelings', 'activitys', 'locations')->first();
    }

    public function show($newfeedID)
    {
        return response()->json([
            'newfeed' => $this->getNewFeed($newfeedID),
        ], 200);
    }

    private function getComment($newfeedID)
    {
        return Comment::where('commentable_id', $newfeedID)->whereNull('parent_id')->with('user', 'replies', 'post')->get();
    }

    public function comment($newfeedID)
    {
        return response()->json([
            'comments' => $this->getComment($newfeedID),
        ], 200);
    }

    public function share($newfeedID, Request $request)
    {
        try {
            $postID = $this->generateNumber(8);
            Post::create([
                'post_id' => (string) $postID,
                'user_id' => $this->userID,
                'content' => !is_null($request->content) ? $request->content : null,
                'shared_by' => $newfeedID,
                'postable_id' => (string) $postID,
                'postable_type' => 'App\Models\Post',
                'status' => !is_null($request->status) ? $request->status : 0,
                'created_at' => Carbon::now()
            ]);
            $share = Share::insertGetId([
                'user_id' => $this->userID,
                'shareable_id' => $newfeedID,
                'shareable_type' => 'App\Models\Post',
                'created_at' => Carbon::now()
            ]);
            $userID = $this->getNewFeed($newfeedID)->user_id;
            $this->saveNotification([
                'user_id' => $this->userID,
                'source_id' => $userID,
                'title' => null,
                'type' => 1,
                'notifiable_id' => $newfeedID,
                'notifiable_type' => 'App\Models\Post',
            ]);
            // Load về thông báo
            $notifications = Notification::where('source_id', $userID)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->where('is_read', 0)
            ->count();

            // event(new NotificationPublished($NotificationPublished));
            broadcast(new NotificationPublished($notifications, $userID));
            return response()->json([
                'newfeed' => $this->getNewFeed($postID),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveComment($newfeedID, Request $request)
    {
        try {
            $comment = Comment::insertGetId([
                'user_id' => $this->userID,
                'parent_id' => $request->parent_id ?? null,
                'body' => $request->body,
                'commentable_id' => $request->post_id,
                'commentable_type' => $request->postable_type,
                'created_at' => Carbon::now()
            ]);
            $userID =  $this->getNewFeed($newfeedID)->user_id;

            if (is_null($request->parent_id)) {
                $this->saveNotification([
                    'user_id' => $this->userID,
                    'source_id' => $userID,
                    'title' => null,
                    'type' => 2,
                    'notifiable_id' => $newfeedID,
                    'notifiable_type' => 'App\Models\Post',
                ]);
            }
            else {
                $this->saveNotification([
                    'user_id' => $this->userID,
                    'source_id' => $userID,
                    'title' => null,
                    'type' => 2,
                    'notifiable_id' => $comment,
                    'notifiable_type' => 'App\Models\Comment',
                ]);
            }
            // Load về thông báo
            $notifications = Notification::where('source_id', $userID)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->where('is_read', 0)
            ->count();

            // event(new NotificationPublished($NotificationPublished));
            broadcast(new NotificationPublished($notifications, $userID));

            return response()->json([
                'comments' => $this->getComment($newfeedID),
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function removeComment($commentID)
    {
        try {
            $comment = Comment::find($commentID)->delete();
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reply($commentID)
    {
        try {
            $comments = Comment::where('parent_id', $commentID)->get();
            return response()->json([
                'comments' => $comments,
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function disabledComment($newfeedID)
    {
        try {
            $newfeed = Post::where(['post_id' => $newfeedID])->first();
            $newfeed->disabled = $newfeed->disabled == 1 ? 0 : 1;
            $newfeed->save();
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reactPost($newfeedID)
    {
        try {
            $newfeed = Post::where('post_id', $newfeedID)->first();
            if (!is_null($newfeed)){
                if (!$newfeed->reacts()->get()->contains('user_id', $this->userID)) {
                    // Add
                    $react = new React([
                        'type' => 1,
                        'user_id' => $this->userID,
                        'reactable_type' => 'App\Models\Post',
                        'reactable_id' => $newfeedID,
                    ]);
                    $newfeed->reacts()->save($react);

                } else {
                    //remove
                    React::where([
                        ['user_id', $this->userID],
                        ['reactable_id', $newfeedID],
                        ['reactable_type', 'App\Models\Post'],
                    ])->delete();
                }
                $this->saveNotification([
                    'user_id' => $this->userID, // user tương tác bài viết
                    'source_id' => $newfeed->user_id, // chủ bài viêts
                    'title' => null,
                    'type' => 0,
                    'notifiable_id' => $newfeedID,
                    'notifiable_type' => 'App\Models\Post',
                ]);
                // Load về thông báo
                $notifications = Notification::where('source_id', $newfeed->user_id)
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->where('is_read', 0)
                ->count();

                // event(new NotificationPublished($NotificationPublished));
                broadcast(new NotificationPublished($notifications, $newfeed->user_id));

                return response()->json([
                    'status' => 'success',
                    'detail' => $this->getNewFeed($newfeedID),
                ], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reactList($newfeedID)
    {
        try {
            $reacts = React::where(['reactable_id' => $newfeedID])->with('user')->get();
            return response()->json([
                'status' => 'success',
                'reacts' => $reacts,
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($newfeedID)
    {
        try {
            $newfeed = Post::where(['post_id' => $newfeedID])->first();
            $newfeed->save();
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($newfeedID)
    {
        try {
            $newfeed = Post::where('id', $newfeedID)->update([
                'is_delete' => 1,
                'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function restore($newfeedID)
    {
        try {
            $newfeed = Post::where(['post_id' => $newfeedID])->first();
            $newfeed->is_delete = 0;
            $newfeed->save();
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function changeStatus($newfeedID, Request $request)
    {
        try {
            Post::where('post_id', $newfeedID)->update([
                'status' => $request->status,
                'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'status' => 'success',
                'newfeed' => $this->getNewFeed($newfeedID),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function uploadPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'content'   => 'required',
                'media.*'   => 'nullable|mimes:jpeg,png,jpg,mp4,JPG,PNG,JPEG,MP4',
            ]);
            if($validator->fails()){
                return response()->json([
                    'status'    => 400,
                    'message'   => $validator->errors()->first()
                ]);
            }

            if ($request->action == 'Create') {
                $postID = $this->generateNumber(8);
                $newfeed = Post::insertGetId([
                    'post_id' => $postID,
                    'user_id' => $this->userID,
                    'content' => $request->content ?? null,
                    'postable_id' => $postID,
                    'postable_type' => 'App\Models\Post',
                    'status' => $request->status ?? 0,
                    'activity' => $request->activity ?? null,
                    'feeling' => $request->feeling ?? null,
                    'location_id' => $request->location_id ?? null,
                    'created_at' => Carbon::now()
                ]);
                //Process Media
                if (!is_null($request->media)) {
                    $this->processMedia(true, $request->file('media'), $this->userID, $postID, 'App\Models\Post');
                }
            } else {
                $postID = $request->post_id;
                $newfeed = Post::where('post_id', $postID)->update([
                    'content' => $request->content ?? null,
                    'status' => $request->status ?? 0,
                    'activity' => $request->activity ?? null,
                    'feeling' => $request->feeling ?? null,
                    'location_id' => $request->location_id ?? null,
                    'updated_at' => Carbon::now()
                ]);
                //Process Media
                // if (!is_null($request->media)) {
                    $this->processMedia(false, $request->file('media'), $this->userID, $postID, 'App\Models\Post');
                // }
            }

            if ($newfeed) {
                return response()->json([
                    'status' => 200,
                    'newfeed' => $this->getNewFeed($postID),
                ], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function processMedia($state, $medias, $userID, $mediableID, $mediableType) {
        try {
            // Action Edit Post
            if ($state == false) {
                $this->removeMedia($mediableID, $mediableType);
            }
            if (!is_null($medias)) {
                $dataMedia = [];
                foreach ($medias as $key => $media) {
                    $mediaSrc = $mediableID . '_' . $key . '.' . $media->extension();
                    $media->move(public_path('uploads/media'), $mediaSrc);
                    $optimizerChain = OptimizerChainFactory::create();
                    $optimizerChain->optimize(public_path('uploads/media') . '/' . $mediaSrc);
                    $image = Image::make(public_path('uploads/media') . '/' . $mediaSrc);
                    // Compress the image with a desired quality (e.g., 70)
                    $image->encode('jpg', 0);

                    // Save the compressed image back to the same path
                    $image->save(public_path('uploads/media') . '/' . $mediaSrc);

                    $dataMedia[] = [
                        'user_id' => $userID,
                        'media_id' => $this->generateNumber(8),
                        'type' => 'image',
                        'src' => $mediaSrc,
                        'mediable_id' => $mediableID,
                        'mediable_type' => $mediableType,
                        'status' => $media->status ?? 0,
                        'is_delete' => 0,
                        'url' => '',
                        'created_at' => Carbon::now()
                    ];
                }
                return Media::insert($dataMedia);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function removeMedia($mediableID, $mediableType) {
        try {
            return Media::where([
                'mediable_id' => $mediableID,
                'mediable_type' => $mediableType
            ])->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
