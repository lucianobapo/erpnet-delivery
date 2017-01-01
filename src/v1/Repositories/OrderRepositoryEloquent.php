<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Presenters\OrderPresenter;
use ErpNET\Models\v1\Interfaces\OrderRepository;
use ErpNET\Models\v1\Entities\OrderEloquent;
use ErpNET\Models\v1\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepositoryEloquent implements OrderRepository
{
    protected $modelClass = OrderEloquent::class;
    protected $validatorClass = OrderValidator::class;
    protected $presenterClass = OrderPresenter::class;

    protected $fieldSearchable = [
//        'product.name',
//        'name'=>'like',
//        'email', // Default Condition "="
//        'your_field'=>'condition'
    ];

}
