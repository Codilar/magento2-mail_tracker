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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Delete extends AbstractController
{
    /**
     * @var MailRepositoryInterface
     */
    private $mailRepository;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     * @param MailRepositoryInterface $mailRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        MailRepositoryInterface $mailRepository
    )
    {
        parent::__construct($context, $pageFactory);
        $this->mailRepository = $mailRepository;
    }

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
        try {
            $model = $this->mailRepository->load($emailId);
            $this->mailRepository->delete($model);
            $this->messageManager->addSuccessMessage(__("Mail deleted successfully"));
        } catch (LocalizedException $localizedException) {
            $this->messageManager->addErrorMessage($localizedException->getMessage());
        }
        $result = $this->resultRedirectFactory->create();
        return $result->setPath('*/*');
    }
}