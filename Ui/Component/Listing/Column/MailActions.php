<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class MailActions extends Column
{
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * MailActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $url,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->url = $url;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $title = __("Mail");
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['email_id'])) {
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->url->getUrl(
                                "codilar/mailtracker/view",
                                [
                                    'email_id' => $item['email_id']
                                ]
                            ),
                            'label' => __('View')
                        ],
                        'delete' => [
                            'href' => $this->url->getUrl(
                                "codilar/mailtracker/delete",
                                [
                                    'email_id' => $item['email_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1', $title),
                                'message' => __('Are you sure you want to delete a %1 record?', $title)
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}