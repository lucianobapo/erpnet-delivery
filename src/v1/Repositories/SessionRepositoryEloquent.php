<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Interfaces\SessionRepository;
use ErpNET\Models\v1\Entities\SessionEloquent;
use ErpNET\Models\v1\Validators\SessioValidator;

/**
 * Class SessionRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class SessionRepositoryEloquent extends BaseRepositoryEloquent implements SessionRepository
{
    protected $modelClass = SessionEloquent::class;
//    protected $validatorClass = SessioValidator::class;

}
