<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Interfaces\UserRepository;
use ErpNET\Models\v1\Entities\UserEloquent;
use ErpNET\Models\v1\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepository
{
    protected $modelClass = UserEloquent::class;
    protected $validatorClass = UserValidator::class;

    protected $fieldSearchable = [
        'provider_id',
//        'product.name',
//        'name'=>'like',
//        'email', // Default Condition "="
//        'your_field'=>'condition'
    ];
}
