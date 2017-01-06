<?php

/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 01/01/17
 * Time: 20:36
 */

namespace ErpNET\Delivery\v1\Services;

use ErpNET\Models\v1\Interfaces\ProductRepository;
use ErpNET\Delivery\v1\Entities\DeliveryPackageEloquent;
use ErpNET\Models\v1\Interfaces\SharedStatRepository;

class DeliveryService
{
    protected $productRepository;
    /**
     * Service constructor.
     */
    public function __construct(ProductRepository $productRepository, SharedStatRepository $sharedStatRepository)
    {
        $this->productRepository = $productRepository;
        $this->sharedStatRepository = $sharedStatRepository;
    }

    public function deliveryPackage()
    {
//        $aa = new DeliveryPackageEloquent;
//        dd($aa);
        $sharedStats = $this->sharedStatRepository->all();
        dd($sharedStats);
        $products = $this->productRepository->all();
        
        return $products;
    }
}