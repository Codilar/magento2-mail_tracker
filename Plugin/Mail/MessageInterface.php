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
use Magento\Framework\View\LayoutInterface;

class MessageInterface
{
    /**
     * @var LayoutInterface
     */
    private $layout;
    /**
     * @var MailRepositoryInterface
     */
    private $mailRepository;

    /**
     * MessageInterface constructor.
     * @param LayoutInterface $layout
     * @param MailRepositoryInterface $mailRepository
     */
    public function __construct(
        LayoutInterface $layout,
        MailRepositoryInterface $mailRepository
    )
    {
        $this->layout = $layout;
        $this->mailRepository = $mailRepository;
    }

    /**
     * @param Subject $subject
     * @param $body
     * @return array
     */
    public function beforeSetBody(Subject $subject, $body) {
        try {
            $mail = $this->mailRepository->create();
            $mail->setFrom($subject->getFrom())->setTo(implode(",", $subject->getRecipients()))->setSubject($mail->getSubject())->setBody($body);
            $this->mailRepository->save($mail);
            /** @var Tracker $tracker */
            $tracker = $this->layout->createBlock(Tracker::class, "codilar_mailtracker");
            $body = $mail->getBody();
            $body .= $tracker->setData('email_id', $mail->getId())->toHtml();
        } catch (LocalizedException $localizedException){}
        return [$body];
    }
}