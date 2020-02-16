<?php
/**
 * 2018 Anvanto
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author Anvanto (anvantoco@gmail.com)
 *  @copyright  2018 anvanto.com

 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * The response returned from the service.
 */
class Response
{
    /**
     * Success or failure.
     * @var boolean
     */
    private $success = false;

    /**
     * Error code strings.
     * @var array
     */
    private $errorCodes = array();

    /**
     * The hostname of the site where the reCAPTCHA was solved.
     * @var string
     */
    private $hostname;

    /**
     * Build the response from the expected JSON returned by the service.
     *
     * @param string $json
     * @return \ReCaptcha\Response
     */
    public static function fromJson($json)
    {
        $responseData = Tools::jsonDecode($json, true);

        if (!$responseData) {
            return new Response(false, array('invalid-json'));
        }

        $hostname = isset($responseData['hostname']) ? $responseData['hostname'] : null;

        if (isset($responseData['success']) && $responseData['success'] == true) {
            return new Response(true, array(), $hostname);
        }

        if (isset($responseData['error-codes']) && is_array($responseData['error-codes'])) {
            return new Response(false, $responseData['error-codes'], $hostname);
        }

        return new Response(false, array(), $hostname);
    }

    /**
     * Constructor.
     *
     * @param boolean $success
     * @param array $errorCodes
     * @param string $hostname
     */
    public function __construct($success, array $errorCodes = array(), $hostname = null)
    {
        $this->success = $success;
        $this->errorCodes = $errorCodes;
        $this->hostname = $hostname;
    }

    /**
     * Is success?
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * Get error codes.
     *
     * @return array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }

    /**
     * Get hostname.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }
}
