<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Ui\Component\Mail;


use Codilar\MailTracker\Api\MailRepositoryInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param MailRepositoryInterface $mailRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        MailRepositoryInterface $mailRepository,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $mailRepository->getCollection();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}