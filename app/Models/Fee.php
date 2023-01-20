<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{

    protected $table = 'fees';

    const STATUS_PAID = 1;

    const STATUS_UNPAID = 0;


    protected $fillable = [
        'month',
        'year',
        'amount',
        'user_id',
        'status',
        'due_date'
    
    ];

    public function getMonth($id= null){
        $list = array('Jan' => 'Jan.', 'Feb' => 'Feb.', 'Mar' => 'Mar.', 'Apr' => 'Apr.', 'May' => 'May', 'Jun' => 'Jun.', 'Jul' => 'Jul.', 'Aug' => 'Aug.', 'Sep' => 'Sep.', 'Oct' => 'Oct.', 'Nov' => 'Nov.', 'Dec' => 'Dec.');
        if ($id === null)
        return $list;
    return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }


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

    public function getCreatedAtAttribute($value)
    {
        $date=date_create($value);
       return date_format($date,"d-m-Y");
    }

    public function user()
    {
      return   $this->belongsTo(User::class, 'user_id');
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
