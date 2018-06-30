<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Controller\Tracker;


use Codilar\MailTracker\Api\MailRepositoryInterface;
use Codilar\MailTracker\Block\Tracker;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Codilar\MailTracker\Helper\Mail as MailHelper;

class Track extends Action
{
    /**
     * @var MailRepositoryInterface
     */
    private $mailRepository;
    /**
     * @var MailHelper
     */
    private $mailHelper;

    /**
     * Track constructor.
     * @param Context $context
     * @param MailRepositoryInterface $mailRepository
     * @param MailHelper $mailHelper
     */
    public function __construct(
        Context $context,
        MailRepositoryInterface $mailRepository,
        MailHelper $mailHelper
    )
    {
        parent::__construct($context);
        $this->mailRepository = $mailRepository;
        $this->mailHelper = $mailHelper;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $emailId = $this->mailHelper->decrypt($this->getRequest()->getParam(Tracker::EMAIL_ID_PARAM_NAME));
        try {
            $mail = $this->mailRepository->load($emailId);
            if (empty($mail->getOpenedAt())) {
                $mail->setOpenedAt(gmdate('Y-m-d H:i:s'));
                $mail->setAdditionalInformation($this->getAllHeaders());
                $this->mailRepository->save($mail);
            }
        } catch (NoSuchEntityException $noSuchEntityException){}
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents("");
        return $result;
    }

    /**
     * @return array|false
     */
    private function getAllHeaders() {
        if (!function_exists('getallheaders')) {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        } else {
            return getallheaders();
        }
    }
}