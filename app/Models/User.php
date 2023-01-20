<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;


    const STATUS_INQUIRY  = 0;

    const STATUS_STUDENT = 1;

    const TYPE_IELTS = 'Ielts';
    const TYPE_PTE = 'PTE';
    const TYPE_SPOKEN_ENGLISH = 'Spoken english';
    const TYPE_VISA = 'Visa';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo',
        'type_id',
        'f_name',
        'address',
        'dob',
        'parent_no',
        'status_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRole(){
        return  Auth::user()->roles->pluck('name')[0] ?? '';
    }

    public  function getType($id = null)
    {
        $list = array(
            self::TYPE_IELTS=> "Ielts",
            self::TYPE_PTE=> "PTE",
            self::TYPE_SPOKEN_ENGLISH=> "Spoken english",
            self::TYPE_VISA=> "Visa",
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    
    public static function getStatus($id = null)
    {
        $list = array(
            self::STATUS_INQUIRY=> "Inquiry",
            self::STATUS_STUDENT=> "Student",
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }


    public function getProfilePhotoAttribute($value)
    {
        if ($value != '') {
            return url('/') . '/uploads/' . $value;
        }
        
        return url('/') . '/uploads/user.png' ;
    }

    public function getCreatedAtAttribute($value)
    {
        $date=date_create($value);
       return date_format($date,"d-m-Y");
    }

    public  function fee()
    {
        return $this->hasOne(Fee::class,'user_id')->orderBy('month','asc')->latest();
    }






}
