<?php

namespace ErpNET\Models\v1\Repositories;

use ErpNET\Models\v1\Interfaces\AttachmentRepository;
use ErpNET\Models\v1\Entities\AttachmentEloquent;

/**
 * Class AttachmentRepositoryEloquent
 * @package namespace ErpNET\Models\v1\Repositories;
 */
class AttachmentRepositoryEloquent extends BaseRepositoryEloquent implements AttachmentRepository
{
    protected $modelClass = AttachmentEloquent::class;
}
