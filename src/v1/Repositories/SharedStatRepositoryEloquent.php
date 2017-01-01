<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Interfaces\SharedStatRepository;
use ErpNET\Models\v1\Entities\SharedStatEloquent;

/**
 * Class SharedStatRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class SharedStatRepositoryEloquent extends BaseRepositoryEloquent implements SharedStatRepository
{
    protected $modelClass = SharedStatEloquent::class;

}
