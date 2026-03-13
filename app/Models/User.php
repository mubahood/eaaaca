<?php

namespace App\Models;

use Encore\Admin\Form\Field\BelongsToMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as RelationsBelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    protected $table = "admin_users";

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function programs()
    {
        return $this->hasMany(UserHasProgram::class, 'user_id');
    }

    //boot
    public static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            $model2 = User::find($model->id);
            if ($model2 == null) {
                throw new \Exception("User not found");
            }
            if ($model2->status != $model->status) {
                if ($model->status == 1) {
                    $data['email'] = $model->email;
                    $data['name'] = $model->name;
                    $data['subject'] = 'Account Verification';
                    $login_link = admin_url('');
                    $data['body'] = 'Dear ' . $model->name . ',<br><br>Your account has been verified. You can now use the following link to login to your account.<br><b>LINK</b>: <a href="' . $login_link . '">' . $login_link . '</a><br><br>Regards,<br>Admin';
                    $data['view'] = 'mail';
                    $data['data'] = $data['body'];
                    try {
                        Utils::mail_sender($data);
                    } catch (\Throwable $th) {
                        return;
                    } 
                }
            }
        });
    }
}
