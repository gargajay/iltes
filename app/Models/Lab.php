<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{

    const STATUS_ACTIVE = 1;

    const STATUS_DEACTIVED = 0;


    protected $fillable = [
        'name',
    
    ];


    public static function getStatus($id = null)
    {
        $list = array(
            self::STATUS_ACTIVE => "Active",
            self::STATUS_DEACTIVED=> "Deactivated",
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public static function getUsers($id = null)
    {
      $list =   User::pluck('name','id');
        
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getLogoAttribute($value)
    {
        if ($value != '') {
            return url('/') . '/uploads/' . $value;
        }
        
        return url('/') . '/uploads/user.png' ;
    }

    public function owner()
    {
      return   $this->belongsTo(User::class, 'user_id');
    }

    // private function settings()
    // {
    //     self::line_one => "rr",
    // }

    

}
