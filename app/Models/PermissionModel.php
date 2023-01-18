<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
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


    

}
