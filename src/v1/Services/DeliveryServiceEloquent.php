<?php

/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 01/01/17
 * Time: 20:36
 */

namespace ErpNET\Delivery\v1\Services;

use ErpNET\Models\v1\Criteria\OpenItemOrdersCriteria;
use ErpNET\Models\v1\Criteria\ProductActiveCriteria;
use ErpNET\Models\v1\Criteria\ProductGroupActivatedCriteria;
use ErpNET\Models\v1\Criteria\ProductGroupCategoriesCriteria;
use ErpNET\Models\v1\Criteria\UserActiveCriteria;
use ErpNET\Models\v1\Interfaces\AddressRepository;
use ErpNET\Models\v1\Interfaces\ItemOrderRepository;
use ErpNET\Models\v1\Interfaces\OrderRepository;
use ErpNET\Models\v1\Interfaces\PartnerRepository;
use ErpNET\Models\v1\Interfaces\ContactRepository;
use ErpNET\Models\v1\Interfaces\ProductRepository;
use ErpNET\Models\v1\Interfaces\ProductGroupRepository;
use ErpNET\Models\v1\Interfaces\ProviderRepository;
use ErpNET\Models\v1\Interfaces\SharedOrderTypeRepository;
use ErpNET\Models\v1\Interfaces\SharedOrderPaymentRepository;
use ErpNET\Models\v1\Interfaces\SharedCurrencyRepository;
use ErpNET\Models\v1\Interfaces\OrderService;
use ErpNET\Models\v1\Interfaces\PartnerService;
use ErpNET\Models\v1\Interfaces\UserRepository;

use ErpNET\Delivery\v1\Interfaces\DeliveryService;
use Illuminate\Support\Facades\DB;

class DeliveryServiceEloquent implements DeliveryService
{
    protected $contactRepository;
    protected $productRepository;
    protected $productGroupRepository;
    protected $orderRepository;
    protected $itemOrderRepository;
    protected $addressRepository;
    protected $partnerRepository;
    protected $sharedOrderTypeRepository;
    protected $sharedOrderPaymentRepository;
    protected $sharedCurrencyRepository;
    protected $userRepository;
    protected $providerRepository;

    protected $orderService;
    protected $partnerService;

    /**
     * Service constructor.
     *
     * @param ProductRepository $productRepository
     * @param ProductGroupRepository $productGroupRepository
     * @param OrderRepository $orderRepository
     * @param AddressRepository $addressRepository
     * @param PartnerRepository $partnerRepository
     * @param SharedOrderTypeRepository $sharedOrderTypeRepository
     * @param SharedOrderPaymentRepository $sharedOrderPaymentRepository
     * @param SharedCurrencyRepository $sharedCurrencyRepository
     * @param OrderService $orderService
     * @param PartnerService $partnerService
     */
    public function __construct(
                                ContactRepository $contactRepository, 
                                ProductRepository $productRepository, 
                                ProductGroupRepository $productGroupRepository, 
                                OrderRepository $orderRepository,
                                ItemOrderRepository $itemOrderRepository,
                                AddressRepository $addressRepository,
                                PartnerRepository $partnerRepository,
                                SharedOrderTypeRepository $sharedOrderTypeRepository,
                                SharedOrderPaymentRepository $sharedOrderPaymentRepository,
                                SharedCurrencyRepository $sharedCurrencyRepository,
                                UserRepository $userRepository,
                                ProviderRepository $providerRepository,

                                OrderService $orderService,
                                PartnerService $partnerService
    )
    {
        $this->contactRepository = $contactRepository;
        $this->productRepository = $productRepository;
        $this->productGroupRepository = $productGroupRepository;
        $this->orderRepository = $orderRepository;
        $this->itemOrderRepository = $itemOrderRepository;
        $this->addressRepository = $addressRepository;
        $this->partnerRepository = $partnerRepository;
        $this->sharedOrderTypeRepository = $sharedOrderTypeRepository;
        $this->sharedOrderPaymentRepository = $sharedOrderPaymentRepository;
        $this->sharedCurrencyRepository = $sharedCurrencyRepository;
        $this->userRepository = $userRepository;
        $this->providerRepository = $providerRepository;

        $this->orderService = $orderService;
        $this->partnerService = $partnerService;
    }

    public function createUser($fields){
        $userCreated = $this->userRepository->create($fields);

        //Partner
        $partnerAttributes = [
            'mandante' => $fields['mandante'],
            'user_id'=>$userCreated->id,
            'nome' => $fields['name'],
        ];
        if(isset($fields['birthday'])) $partnerAttributes['data_nascimento'] = $fields['birthday'];
        $partnerData = $this->partnerRepository->create($partnerAttributes);

        $partnerData = $this->partnerService->setToClientGroup($partnerData);
        $partnerData = $this->partnerService->changeToActiveStatus($partnerData);

        //Provider
        $providerCreated = $this->providerRepository->create([
            'mandante' => $fields['mandante'],
            'user_id'=>$userCreated->id,
            'provider' => $fields['provider'],
            'provider_id' => $fields['provider_id'],
        ]);

        //Contact
        if (isset($fields['email']))
            $contactData = $this->contactRepository->create([
                'partner_id'=>$partnerData->id,
                'mandante'=>$fields['mandante'],
                'contact_type'=>'email',
                'contact_data'=>$fields['email'],
            ]);

        $this->userRepository->pushCriteria(UserActiveCriteria::class);
        return $this->userRepository->find($userCreated->id);
    }

    public function createPackage($fields)
    {
        $orderCreated = $this->orderRepository->create($fields);

        $partnerData = null;
        if (isset($fields['partner_id'])) $partnerData = $this->partnerRepository->find($fields['partner_id']);
        if (is_null($partnerData)) {
            $partnerData = $this->partnerRepository->create($fields);
            $partnerData = $this->partnerService->setToClientGroup($partnerData);
            $partnerData = $this->partnerService->changeToActiveStatus($partnerData);
        }
        $orderCreated->partner()->associate($partnerData);

        if(isset($fields['contacts']) && is_array($fields['contacts']) && count($fields['contacts'])>0){
            if (isset($fields['contacts']['emailCheck']) && $fields['contacts']['emailCheck'])
                $contactData = $this->contactRepository->create([
                    'partner_id'=>$partnerData->id,
                    'mandante'=>$fields['mandante'],
                    'contact_type'=>'email',
                    'contact_data'=>$fields['contacts']['email'],
                ]);
            if (isset($fields['contacts']['smsCheck']) && $fields['contacts']['smsCheck'])
                $contactData = $this->contactRepository->create([
                    'partner_id'=>$partnerData->id,
                    'mandante'=>$fields['mandante'],
                    'contact_type'=>'sms',
                    'contact_data'=>$fields['contacts']['sms'],
                ]);
            if (isset($fields['contacts']['whatsappCheck']) && $fields['contacts']['whatsappCheck'])
                $contactData = $this->contactRepository->create([
                    'partner_id'=>$partnerData->id,
                    'mandante'=>$fields['mandante'],
                    'contact_type'=>'whatsapp',
                    'contact_data'=>$fields['contacts']['whatsapp'],
                ]);
        }

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

        if(isset($fields['items']) && is_array($fields['items']) && count($fields['items'])>0){
            $orderCreated->orderItems()->createMany($fields['items']);
        }
        
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

    public function productStock()
    {
        $cacheQuery = DB::table('orders')
            ->select(DB::raw('count(id), MAX(updated_at)'))
            ->get();
        $key = md5($cacheQuery);

        if (config('erpnetMigrates.forceProductStockCache') && \Cache::has($key)){
            $productStock = \Cache::get($key);
        }else{
            $productStock = $this->calculateProductStock();
        }

        if (config('erpnetMigrates.forceProductStockCache') && !\Cache::has($key)){
            $expiresAt = \Carbon\Carbon::now()->addDay();
            \Cache::put($key, $productStock, $expiresAt);
        }

        return $productStock;
    }

    /**
     * @return array
     */
    private function calculateProductStock(): array
    {
        $itemData = $this->itemOrderRepository
            ->pushCriteria(app(OpenItemOrdersCriteria::class))
            ->all()
            ->toArray();

        $productStock = [];
        foreach ($itemData as $itemOrder){
            $product_id = $itemOrder['product_id'];
            $stockQuantity = 0;
            if($itemOrder['order']['shared_order_type']['tipo']==config('erpnetModels.salesOrderTypeName')){
                $stockQuantity = -$itemOrder['quantidade'];
            }
            if($itemOrder['order']['shared_order_type']['tipo']==config('erpnetModels.purchaseOrderTypeName')){
                $stockQuantity = $itemOrder['quantidade'];
            }

            if(isset($productStock[$product_id])){
                $productStock[$product_id]['stockQuantity'] = $productStock[$product_id]['stockQuantity']+$stockQuantity;
            }else{
                $productStock[$product_id] = $itemOrder['product'];
                $productStock[$product_id]['stockQuantity'] = $stockQuantity;
            }
        }
        $result = [];
        foreach ($productStock as $key=>$value){
            array_push($result, $value);
        }
        return $result;
    }
}