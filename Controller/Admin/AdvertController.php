<?php

namespace Ekyna\Bundle\AdvertisementBundle\Controller\Admin;

use Ekyna\Bundle\AdminBundle\Controller\Resource;
use Ekyna\Bundle\AdminBundle\Controller\ResourceController;

/**
 * Class AdvertController
 * @package Ekyna\Bundle\AdvertisementBundle\Controller\Admin
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertController extends ResourceController
{
    use Resource\ToggleableTrait;
    use Resource\TinymceTrait;
}
