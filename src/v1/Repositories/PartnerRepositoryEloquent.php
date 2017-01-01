<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Presenters\PartnerPresenter;
use ErpNET\Models\v1\Interfaces\PartnerRepository;
use ErpNET\Models\v1\Entities\PartnerEloquent;
use ErpNET\Models\v1\Validators\PartnerValidator;

/**
 * Class PartnerRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class PartnerRepositoryEloquent extends BaseRepositoryEloquent implements PartnerRepository
{
    protected $modelClass = PartnerEloquent::class;
    protected $validatorClass = PartnerValidator::class;
    protected $presenterClass = PartnerPresenter::class;

}
