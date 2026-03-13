<?php

namespace Encore\Admin\Auth\Database;

use App\Models\Campus;
use App\Models\Company;
use App\Models\Country;
use App\Models\UserHasProgram;
use App\Models\Utils;
use Carbon\Carbon;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class Administrator extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;
    use HasPermissions;
    use DefaultDatetimeFormat;

    //list of this model to array for select
    public static function toSelectArray()
    {
        $data = [];
        $users = self::where([])->orderBy('first_name', 'asc')->get();
        foreach ($users as $user) {
            $country = $user->country;
            $country_text = "";
            if ($country != null) {
                $country_text = " - " . $country->name;
            }
            $data[$user->id] = $user->name . $country_text;
        }
        return $data;
    }

    //country
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
 

    protected $fillable = ['username', 'password', 'name', 'avatar', 'created_at_text'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($m) {
            return self::prepare($m);
        });
      

        static::updating(function ($model) {
            $model = self::prepare($model);
            $model2 = Administrator::find($model->id);
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

        //deleting
        self::deleting(function ($m) {
            $m->roles()->detach();
            $m->permissions()->detach();
        });
    }

    public static function prepare($m)
    {
        $n = $m->first_name . " " . $m->last_name;
        if (strlen(trim($n)) > 1) {
            $m->name = trim($n);
        }
        $m->username = strtolower($m->username);
        $m->email = strtolower($m->email);
        $company = Company::find($m->company_id);
        if ($company != null) {
            $m->country_id = $company->country_id;
        }
        return $m;
    }


    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        $default = config('admin.default_avatar') ?: '/assets/images/user.jpg';

        return admin_asset($default);
    }


    public function programs()
    {
        return $this->hasMany(UserHasProgram::class, 'user_id');
    }

    public function program()
    {
        $p = UserHasProgram::where(['user_id' => $this->id])->first();
        if ($p == null) {
            $p = new UserHasProgram();
            $p->name = "No program";
        }
        return $p;
    }


    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function getCreatedAtTextAttribute($name)
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }


    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.database.user_permissions_table');

        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }
}
