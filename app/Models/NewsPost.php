<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory;

    //administrator
    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }
    //category 
    public function category()
    {
        return $this->belongsTo(NewsPostCategory::class, 'news_post_category_id');
    } 
}
