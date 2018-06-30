<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Helper;


use Magento\Framework\Encryption\Encryptor;

class Mail
{
    /**
     * @var Encryptor
     */
    private $encryptor;

    /**
     * Mail constructor.
     * @param Encryptor $encryptor
     */
    public function __construct(
        Encryptor $encryptor
    )
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @param string $data
     * @return string
     */
    public function encrypt($data) {
        return urlencode($this->encryptor->encrypt($data));
    }

    /**
     * @param string $data
     * @return string
     */
    public function decrypt($data) {
        return urldecode($this->encryptor->decrypt($data));
    }
}