<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Interfaces\MandanteRepository;
use ErpNET\Models\v1\Entities\MandanteEloquent;
use ErpNET\Models\v1\Validators\MandanteValidator;

/**
 * Class MandanteRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class MandanteRepositoryEloquent extends BaseRepositoryEloquent implements MandanteRepository
{
    protected $modelClass = MandanteEloquent::class;
    protected $validatorClass = MandanteValidator::class;
}
