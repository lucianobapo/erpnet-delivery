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
use ErpNET\Models\v1\Interfaces\SharedCurrencyRepository;
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
    protected $sharedCurrencyRepository;

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
                                SharedCurrencyRepository $sharedCurrencyRepository,
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
        $this->sharedCurrencyRepository = $sharedCurrencyRepository;

        $this->orderService = $orderService;
    }

    public function createPackage($fields)
    {        
        $orderCreated = $this->orderRepository->create($fields);

        $partnerData = null;
        if (isset($fields['partner_id'])) $partnerData = $this->partnerRepository->find($fields['partner_id']);
        if (is_null($partnerData)) $partnerData = $this->partnerRepository->create($fields);
        $orderCreated->partner()->associate($partnerData);

        $addressData = null;
        if (isset($fields['address_id'])) $addressData = $this->addressRepository->find($fields['address_id']);
        if (is_null($addressData)) $addressData = $this->addressRepository->create($fields);
        $orderCreated->address()->associate($addressData);
        
        if (isset($fields['pagamento'])) {
            $sharedOrderPaymentData = null;
            $sharedOrderPaymentData = $this->sharedOrderPaymentRepository
                ->findByField('pagamento', $fields['pagamento'])->first();
            if(!is_null($sharedOrderPaymentData))
                $orderCreated->sharedOrderPayment()->associate($sharedOrderPaymentData);
        }

        $sharedOrderTypeData = null;
        $sharedOrderTypeData = $this->sharedOrderTypeRepository
            ->findByField('tipo', config('erpnetModels.salesOrderTypeName'))->first();
        if(!is_null($sharedOrderTypeData))
            $orderCreated->sharedOrderType()->associate($sharedOrderTypeData);

        $sharedCurrencyData = null;
        $sharedCurrencyData = $this->sharedCurrencyRepository
            ->findByField('nome_universal', config('erpnetModels.currencyName'))->first();
        if(!is_null($sharedCurrencyData))
            $orderCreated->sharedCurrency()->associate($sharedCurrencyData);

        $orderCreated->save();

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