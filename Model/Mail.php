<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Model;


use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Codilar\MailTracker\Model\ResourceModel\Mail as ResourceModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Mail
 * @package Codilar\MailTracker\Model
 * @method $this setFrom(string $from)
 * @method string getFrom()
 * @method $this setTo(string $to)
 * @method string getTo()
 * @method $this setBody(string $body)
 * @method string getBody()
 * @method $this setOpenedAt(string $openedAt)
 * @method string getOpenedAt()
 */
class Mail extends AbstractModel
{
    /**
     * @var Json
     */
    private $json;

    /**
     * Mail constructor.
     * @param Context $context
     * @param Registry $registry
     * @param Json $json
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Json $json,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->json = $json;
    }

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @param array $additionalInformation
     * @return $this
     */
    public function setAdditionalInformation(array $additionalInformation) {
        return $this->setData('additional_information', $this->json->serialize($additionalInformation));
    }

    /**
     * @return array
     */
    public function getAdditionalInformation() {
        try {
            return $this->json->unserialize($this->getData('additional_information'));
        } catch (\InvalidArgumentException $invalidArgumentException) {
            return [];
        }
    }
}