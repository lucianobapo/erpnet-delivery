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

    protected $service;

    /**
     * Controller constructor.
     */
    public function __construct(DeliveryService $deliveryService)
    {
        $this->service = $deliveryService;
    }

    public function package()
    {
        return $this->service->deliveryPackage();

    }
}
