<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Interfaces\PostRepository;
use ErpNET\Models\v1\Entities\PostEloquent;
use ErpNET\Models\v1\Validators\PostValidator;

/**
 * Class PostRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
    protected $modelClass = PostEloquent::class;
    protected $validatorClass = PostValidator::class;
//    protected $presenterClass = PostPresenter::class;

    protected $fieldSearchable = [
//        'product.name',
//        'name'=>'like',
//        'email', // Default Condition "="
//        'your_field'=>'condition'
    ];
}
