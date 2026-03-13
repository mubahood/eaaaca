<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    //toSelectArray
    public static function toSelectArray()
    {
        $data = [];
        $companies = self::where([])->orderBy('name', 'asc')->get();
        foreach ($companies as $company) {
            $data[$company->id] = $company->name;
        }
        return $data;
    }

    public static function boot()
    {
        parent::boot();

        //deleting
        static::deleting(function ($m) {
            //you cannot delete this item
            throw new \Exception("You cannot delete this item");
            return false;
        });

        static::created(function ($m) {
            $owner = Administrator::find($m->administrator_id);
            if ($owner == null) {
                throw new \Exception("Owner not found");
            }
            $owner->company_id = $m->id;
            $owner->save();
        });
        static::updated(function ($m) {
            $owner = Administrator::find($m->administrator_id);
            if ($owner == null) {
                throw new \Exception("Owner not found");
            }
            $owner->company_id = $m->id;
            $owner->save();
        });
    }

    //for administrator
    public function owner()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }
}
