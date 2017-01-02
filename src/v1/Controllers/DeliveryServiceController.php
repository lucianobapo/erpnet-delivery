<?php

namespace ErpNET\Delivery\v1\Controllers;

use ErpNET\Delivery\v1\Services\DeliveryService;

/**
 *  Delivery resource representation.
 *
 * @Resource("Delivery", uri="/delivery")
 */
class DeliveryServiceController extends Controller
{
    protected $routeName = 'delivery';

    /**
     * @var integer
     */
    protected $paginateItemCount = 3;

    /**
     * Criterias to load
     * @var array
     */
    protected $defaultCriterias = [];

    /**
     * Controller constructor.
     */
    public function __construct(DeliveryService $deliveryService)
    {
        $this->service = $deliveryService;
    }

    public function delivery()
    {
//        $this->repo
    }
}
