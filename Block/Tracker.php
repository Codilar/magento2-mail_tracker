<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Block;


use Codilar\MailTracker\Controller\Router;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Codilar\MailTracker\Helper\Mail as MailHelper;

class Tracker extends Template
{

    const EMAIL_ID_PARAM_NAME = "eid";
    /**
     * @var MailHelper
     */
    private $mailHelper;

    /**
     * Tracker constructor.
     * @param Template\Context $context
     * @param MailHelper $mailHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        MailHelper $mailHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->mailHelper = $mailHelper;
    }

    protected function _prepareLayout()
    {
        $this->setTemplate("Codilar_MailTracker::tracker.phtml");
        return parent::_prepareLayout();
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    protected function getEmailId() {
        $emailId = $this->getData('email_id');
        if (!$emailId) {
            throw new LocalizedException(__("Email ID not initialized"));
        } else {
            return $this->mailHelper->encrypt($emailId);
        }
    }

    /**
     * @return string
     */
    public function getTrackerUrl() {
        try {
            return $this->getBaseUrl() . Router::MAIL_TRACKER_ROUTE_KEY . "?".self::EMAIL_ID_PARAM_NAME."=" . $this->getEmailId();
        } catch (LocalizedException $e) {
            return $e->getMessage();
        }
    }
}