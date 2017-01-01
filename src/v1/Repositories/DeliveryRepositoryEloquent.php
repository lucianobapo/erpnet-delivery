<?php

namespace ErpNET\Delivery\v1\Repositories;

use ErpNET\Delivery\v1\Interfaces\DeliveryRepository;
use ErpNET\Delivery\v1\Entities\AttachmentEloquent;
use ErpNET\Delivery\v1\Repositories\BaseRepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class DeliveryRepositoryEloquent
 * @package namespace ErpNET\Delivery\v1\Repositories;
 */
class DeliveryRepositoryEloquent extends BaseRepository implements DeliveryRepository
{
    protected $modelClass = AttachmentEloquent::class;
}
