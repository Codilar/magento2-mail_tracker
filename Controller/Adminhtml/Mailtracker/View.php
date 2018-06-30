<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Controller\Adminhtml\Mailtracker;


use Codilar\MailTracker\Api\MailRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class View extends AbstractController
{
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $emailId = $this->getRequest()->getParam('email_id');
        if ($emailId) {
            $page = $this->pageFactory->create();
            $mailId = $this->getRequest()->getParam('email_id');
            $page->getConfig()->getTitle()->set(__("View Mail #$mailId"));
            return $page;
        } else {
            $this->messageManager->addErrorMessage(__("The mail you requested for doesn't exist anymore"));
            $result = $this->resultRedirectFactory->create();
            $result->setPath('*/*');
            return $result;
        }
    }
}