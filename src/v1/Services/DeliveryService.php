<?php

/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 01/01/17
 * Time: 20:36
 */

namespace ErpNET\Delivery\v1\Services;

use ErpNET\Models\v1\Criteria\ProductActiveCriteria;
use ErpNET\Models\v1\Criteria\ProductGroupActivatedCriteria;
use ErpNET\Models\v1\Criteria\ProductGroupCategoriesCriteria;
use ErpNET\Models\v1\Interfaces\OrderRepository;
use ErpNET\Models\v1\Interfaces\ProductRepository;
use ErpNET\Delivery\v1\Entities\DeliveryPackageEloquent;
use ErpNET\Models\v1\Interfaces\ProductGroupRepository;

class DeliveryService
{
    protected $productRepository;
    protected $productGroupRepository;
    /**
     * Service constructor.
     */
    public function __construct(ProductRepository $productRepository, 
                                ProductGroupRepository $productGroupRepository, 
                                OrderRepository $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->productGroupRepository = $productGroupRepository;
        $this->orderRepository = $orderRepository;
    }

    public function createPackage($fields)
    {
        $orderCreated = $this->orderRepository->create($fields);
        
        
//        $productGroups = $this->productGroupRepository
//            ->pushCriteria(ProductGroupCategoriesCriteria::class)
//            ->pushCriteria(ProductGroupActivatedCriteria::class)
//            ->all();
//        dd($productGroups);
        
//        $products = $this->productRepository
//            ->pushCriteria(ProductActiveCriteria::class)
//            ->all();
//        dd($products->toArray());
        
        return $orderCreated;
    }
}