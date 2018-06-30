<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Block\Adminhtml\Mail;


use Codilar\MailTracker\Api\MailRepositoryInterface;
use Codilar\MailTracker\Model\Mail;
use Magento\Backend\Block\Template;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;

class View extends Template
{
    /**
     * @var MailRepositoryInterface
     */
    private $mailRepository;
    /**
     * @var Json
     */
    private $json;

    /**
     * View constructor.
     * @param MailRepositoryInterface $mailRepository
     * @param Template\Context $context
     * @param Json $json
     * @param array $data
     */
    public function __construct(
        MailRepositoryInterface $mailRepository,
        Template\Context $context,
        Json $json,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->mailRepository = $mailRepository;
        $this->json = $json;
    }

    /**
     * @return Mail|null
     */
    public function getMail() {
        try {
            return $this->mailRepository->load($this->getRequest()->getParam('email_id'));
        } catch (NoSuchEntityException $noSuchEntityException) {
            return null;
        }
    }

    public function getGoBackUrl() {
        return $this->getUrl('*/*');
    }

    /**
     * @param array $data
     * @return string
     */
    public function jsonEncode(array $data) {
        $response = $this->json->serialize($data);
        if (!$response) {
            $response = "{}";
        }
        return $response;
    }
}