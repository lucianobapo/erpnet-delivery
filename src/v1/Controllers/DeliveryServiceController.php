<?php

namespace ErpNET\Delivery\v1\Controllers;

use ErpNET\Delivery\v1\Interfaces\DeliveryRepository;

/**
 *  Delivery resource representation.
 *
 * @Resource("Delivery", uri="/delivery")
 */
class DeliveryServiceController extends Controller
{
    protected $routeName = 'delivery';
    protected $repositoryClass = DeliveryRepository::class;

    /**
     * @var integer
     */
    protected $paginateItemCount = 3;

    /**
     * Criterias to load
     * @var array
     */
    protected $defaultCriterias = [];

    public function delivery()
    {
//        $this->repo
    }
}
