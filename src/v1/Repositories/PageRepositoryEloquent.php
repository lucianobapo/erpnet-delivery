<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Criteria\PageOrderedCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use ErpNET\Models\v1\Interfaces\PageRepository;
use ErpNET\Models\v1\Entities\PageEloquent;
use ErpNET\Models\v1\Validators\PageValidator;

/**
 * Class PageRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class PageRepositoryEloquent extends BaseRepositoryEloquent implements PageRepository
{
    protected $modelClass = PageEloquent::class;
    protected $validatorClass = PageValidator::class;

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(PageOrderedCriteria::class));
    }

}
