<?php

namespace ErpNET\Models\v1\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PageOrderedCriteria
 * @package namespace ErpNET\Models\v1\Criteria;
 */
class PageOrderedCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Query\Builder         $model
     * @param RepositoryInterface   $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy('ordem');
    }

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }
}
