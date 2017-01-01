<?php

namespace ErpNET\Delivery\v1\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

/**
 * Interface PartnerRepository
 * @package namespace ErpNET\Delivery\Interfaces;
 * @see \ErpNET\Delivery\v1\Repositories\BaseRepositoryEloquent
 */
interface BaseRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model();
}
