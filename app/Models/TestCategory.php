<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TestCategory extends Model
{
    use HasFactory;

    protected $table = 'test_categories';


    const STATUS_ACTIVE = 1;

    const STATUS_DEACTIVED = 0;


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

    public static function getLabs($id = null)
    {
       $user =  Auth::user();

       $list  =    Lab::where('user_id',$user->id)->pluck('name','id');
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function lab()
    {
      return   $this->belongsTo(Lab::class, 'lab_id');
    }

}
