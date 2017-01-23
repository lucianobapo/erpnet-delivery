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
use ErpNET\Models\v1\Interfaces\AddressRepository;
use ErpNET\Models\v1\Interfaces\OrderRepository;
use ErpNET\Models\v1\Interfaces\PartnerRepository;
use ErpNET\Models\v1\Interfaces\ProductRepository;
use ErpNET\Delivery\v1\Entities\DeliveryPackageEloquent;
use ErpNET\Models\v1\Interfaces\ProductGroupRepository;
use ErpNET\Models\v1\Interfaces\SharedOrderTypeRepository;
use ErpNET\Models\v1\Interfaces\SharedOrderPaymentRepository;
use ErpNET\Models\v1\Interfaces\OrderService;

class DeliveryService
{
    protected $productRepository;
    protected $productGroupRepository;
    protected $orderRepository;
    protected $addressRepository;
    protected $partnerRepository;
    protected $sharedOrderTypeRepository;
    protected $sharedOrderPaymentRepository;

    protected $orderService;

    /**
     * Service constructor.
     * 
     * @param ProductRepository $productRepository
     * @param ProductGroupRepository $productGroupRepository
     * @param OrderRepository $orderRepository
     * @param AddressRepository $addressRepository
     */
    public function __construct(
                                ProductRepository $productRepository, 
                                ProductGroupRepository $productGroupRepository, 
                                OrderRepository $orderRepository,
                                AddressRepository $addressRepository, 
                                PartnerRepository $partnerRepository,
                                SharedOrderTypeRepository $sharedOrderTypeRepository,
                                SharedOrderPaymentRepository $sharedOrderPaymentRepository,
                                OrderService $orderService
    )
    {
        $this->productRepository = $productRepository;
        $this->productGroupRepository = $productGroupRepository;
        $this->orderRepository = $orderRepository;
        $this->addressRepository = $addressRepository;
        $this->partnerRepository = $partnerRepository;
        $this->sharedOrderTypeRepository = $sharedOrderTypeRepository;
        $this->sharedOrderPaymentRepository = $sharedOrderPaymentRepository;

        $this->orderService = $orderService;
    }

    public function createPackage($fields)
    {
        if (!isset($fields['currency_id'])) $fields['currency_id'] = 1;
        
        if (!isset($fields['type_id'])) {
            $sharedOrderTypeFound = $this->sharedOrderTypeRepository->findByField('tipo', config('erpnetModels.salesOrderTypeName'));
            $fields['type_id'] = $sharedOrderTypeFound->id;
        }

        if (isset($fields['pagamento'])) {
            $sharedOrderPaymentFound = $this->sharedOrderPaymentRepository->findByField('pagamento', $fields['pagamento']);
            $fields['payment_id'] = $sharedOrderPaymentFound->id;
        }

        if (!isset($fields['address_id'])){
            $addressCreated = $this->addressRepository->create($fields);
            $fields['address_id'] = $addressCreated->id;
        }
        if (!isset($fields['partner_id'])){
            $partnerCreated = $this->partnerRepository->create($fields);
            $fields['partner_id'] = $partnerCreated->id;
        }
        
        $orderCreated = $this->orderRepository->create($fields);

        $orderCreated = $this->orderService->changeToOpenStatus($orderCreated->id);

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