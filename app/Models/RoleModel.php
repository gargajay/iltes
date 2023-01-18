<?php

namespace App\Models;

use Spatie\Permission\Models\Role;

class RoleModel extends Role
{

    const STATUS_ACTIVE = 1;

    const STATUS_DEACTIVED = 0;


    protected $fillable = [
        'name',
        'email',
        'password',
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
