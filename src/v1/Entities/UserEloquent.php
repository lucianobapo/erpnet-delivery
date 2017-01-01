<?php

namespace ErpNET\Models\v1\Entities;

class UserEloquent extends BaseEloquent
{
    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return (array_search($this->email, explode(',', env('ADMIN_EMAILS', 'luciano.bapo@gmail.com')))!==false);
    }
}
