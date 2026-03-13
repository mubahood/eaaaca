<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionBoardPostComment extends Model
{
    use HasFactory;

    //fillables
    protected $fillable = [
        'discussion_board_post_id',
        'administrator_id',
        'body',
    ]; 

    //DiscussionBoardPost relationship
    public function discussionBoardPost()
    {
        return $this->belongsTo(DiscussionBoardPost::class, 'discussion_board_post_id');
    }

    //administrator relationship
    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }
}
