<?php

namespace ErpNET\Delivery\v1\Interfaces;

use ErpNET\Delivery\v1\Interfaces\BaseRepository;

/**
 * Interface DeliveryRepository
 * @package namespace ErpNET\Models\v1\Interfaces;
 * @see \ErpNET\Delivery\v1\Services\DeliveryDeliveryServiceEloquent
 */
interface DeliveryService
{
    public function createUser($fields);

    public function createPackage($fields);

    public function productStock();
}
