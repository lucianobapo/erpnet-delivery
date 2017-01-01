<?php

namespace ErpNET\Delivery\v1\Controllers;

use ErpNET\Delivery\v1\Interfaces\AttachmentRepository;
use ErpNET\Delivery\v1\Controllers\Controller;

/**
 *  Attachment resource representation.
 *
 * @Resource("Attachment", uri="/delivery")
 */
class DeliveryServiceController extends Controller
{
    protected $routeName = 'delivery';
    protected $repositoryClass = AttachmentRepository::class;

    /**
     * @var integer
     */
    protected $paginateItemCount = 3;

    /**
     * Criterias to load
     * @var array
     */
    protected $defaultCriterias = [];

}
