<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{

    protected $table = 'records';

    const STATUS_PAID = 1;

    const STATUS_UNPAID = 0;


    protected $fillable = [
        'listening',
        'reading',
        'writing',
        'speaking',
        'overall',
        'status',
        'user_id',
        'remarks'
    
    ];

   


    public  function getStatus($id = null)
    {
        $list = array(
            self::STATUS_UNPAID => "Unpaid",
            self::STATUS_PAID => "Paid",
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public static function getUsers($id = null)
    {
      $list =   User::whereHas('roles', function($query) {
        $query->where('name','Student');
    })->where('status_id',User::STATUS_STUDENT)->pluck('name','id');
        
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function student()
    {
      return   $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtAttribute($value)
    {
        $date=date_create($value);
       return date_format($date,"d-m-Y");
    }

  

    // public function getLogoAttribute($value)
    // {
    //     if ($value != '') {
    //         return url('/') . '/uploads/' . $value;
    //     }
        
    //     return url('/') . '/uploads/user.png' ;
    // }

   

    // private function settings()
    // {
    //     self::line_one => "rr",
    // }

    

}
