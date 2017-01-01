<?php

namespace ErpNET\Delivery\v1\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

/**
 * Interface PartnerRepository
 * @package namespace ErpNET\Models\Interfaces;
 * @see \ErpNET\Models\v1\Repositories\BaseRepository
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
