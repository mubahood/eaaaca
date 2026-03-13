<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionBoardPost extends Model
{
    use HasFactory;

    //boot
    protected static function boot()
    {
        parent::boot();
        static::updating(function ($m) {
            if (
                ($m->last_comment_body != null) &&
                ($m->last_comment_administrator_id != null)
            ) {
                $new_comment = DiscussionBoardPostComment::create([
                    'discussion_board_post_id' => $m->id,
                    'administrator_id' => $m->last_comment_administrator_id,
                    'body' => $m->last_comment_body,
                ]);
                $m->last_comment_body = null;
                $m->last_comment_administrator_id = null;
            }
            return $m; 
        });
    }

    //administrator
    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }

    //comments 
    public function comments()
    {
        return $this->hasMany(DiscussionBoardPostComment::class, 'discussion_board_post_id');
    }
}
