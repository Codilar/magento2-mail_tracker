<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Controller\Adminhtml\Mailtracker;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

abstract class AbstractController extends Action
{
    const ADMIN_RESOURCE = "Codilar_MailTracker::mail_tracker";
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * AbstractController constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }
}