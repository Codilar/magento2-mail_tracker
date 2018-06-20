<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Model\ResourceModel\Mail;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Codilar\MailTracker\Model\Mail as Model;
use Codilar\MailTracker\Model\ResourceModel\Mail as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}