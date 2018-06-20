<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Controller;


use Codilar\MailTracker\Controller\Tracker\TrackFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{

    const MAIL_TRACKER_ROUTE_KEY = "mailtracker.jpg";
    /**
     * @var TrackFactory
     */
    private $trackFactory;

    /**
     * Router constructor.
     * @param TrackFactory $trackFactory
     */
    public function __construct(
        TrackFactory $trackFactory
    )
    {
        $this->trackFactory = $trackFactory;
    }

    /**
     * Match application action by request
     *
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {
        $query = trim($request->getPathInfo(), "/");
        if ($query === static::MAIL_TRACKER_ROUTE_KEY) {
            return $this->trackFactory->create();
        } else {
            return null;
        }
    }
}