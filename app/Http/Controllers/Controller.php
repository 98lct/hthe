<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function generateNumber($length) {
        $number = rand(pow(10, $length-1), pow(10, $length)-1);
        return $number;
    }

    protected function saveNotification($data) {
        if ($data['user_id'] !== $data['source_id']){
            $where = [
                ['user_id',  $data['user_id']],
                ['source_id',  $data['source_id']],
                ['type',  $data['type']],
                ['notifiable_id',  $data['notifiable_id']],
                ['notifiable_type',  $data['notifiable_type']],
            ];
            if (DB::table('notifications')->where($where)->doesntExist()){
                $data['created_at'] = Carbon::now();
                return DB::table('notifications')->insert($data);
            } else {
                $data['created_at'] = Carbon::now();
                return DB::table('notifications')->where($where)->delete();
            }
        }
        return;
    }
}
