<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Plugin\Mail;
use Codilar\MailTracker\Api\MailRepositoryInterface;
use Codilar\MailTracker\Block\Tracker;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Message as Subject;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\LayoutInterface;

class MessageInterface
{

    const EMAIL_MODEL_REGISTRY_KEY = "_codilar_mailtracker_log_model";

    /**
     * @var LayoutInterface
     */
    private $layout;
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var MailRepositoryInterface
     */
    private $mailRepository;
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * MessageInterface constructor.
     * @param LayoutInterface $layout
     * @param Registry $registry
     * @param MailRepositoryInterface $mailRepository
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        LayoutInterface $layout,
        Registry $registry,
        MailRepositoryInterface $mailRepository,
        TimezoneInterface $timezone
    )
    {
        $this->layout = $layout;
        $this->registry = $registry;
        $this->mailRepository = $mailRepository;
        $this->timezone = $timezone;
    }

    public function beforeSetBody(Subject $subject, $body) {
        try {
            $mail = $this->mailRepository->create();
            $mail->setFrom($subject->getFrom())->setTo(implode(",", $subject->getRecipients()))->setBody($body);
            $now = $this->timezone->date();
            $mail->setCreatedAt($now->format('Y-m-d H:i:s'));
            $this->mailRepository->save($mail);
            /* @var \Codilar\MailTracker\Block\Tracker $tracker */
            $tracker = $this->layout->createBlock(Tracker::class, "codilar_mailtracker");
            $body .= $tracker->setData('email_id', $mail->getId())->toHtml();
        } catch (LocalizedException $localizedException) {}
        return [$body];
    }
}