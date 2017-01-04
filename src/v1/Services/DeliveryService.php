<?php

/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 01/01/17
 * Time: 20:36
 */

namespace ErpNET\Delivery\v1\Services;

class DeliveryService
{
    protected $productRepository;
    /**
     * Service constructor.
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;


    }

    public function deliveryPackage()
    {
        return $this->productRepository->all();
    }
}