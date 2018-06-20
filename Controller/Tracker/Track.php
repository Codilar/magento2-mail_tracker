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
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Track extends Action
{
    /**
     * @var MailRepositoryInterface
     */
    private $mailRepository;
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * Track constructor.
     * @param Context $context
     * @param MailRepositoryInterface $mailRepository
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        Context $context,
        MailRepositoryInterface $mailRepository,
        TimezoneInterface $timezone
    )
    {
        parent::__construct($context);
        $this->mailRepository = $mailRepository;
        $this->timezone = $timezone;
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
        $emailId = $this->getRequest()->getParam(Tracker::EMAIL_ID_PARAM_NAME);
        try {
            $mail = $this->mailRepository->load($emailId);
            if (empty($mail->getOpenedAt())) {
                $now = $this->timezone->date();
                $mail->setOpenedAt($now->format('Y-m-d H:i:s'));
                $mail->setAdditionalInformation($_SERVER);
                $this->mailRepository->save($mail);
            }
        } catch (NoSuchEntityException $noSuchEntityException){}
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents("");
        return $result;
    }
}