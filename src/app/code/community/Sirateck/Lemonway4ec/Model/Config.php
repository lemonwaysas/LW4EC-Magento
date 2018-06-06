<?php
/**
 * Sirateck_Lemonway4ec extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Sirateck
 * @package        Sirateck_Lemonway4ec
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Base configuration
 *
 * @category    Sirateck
 * @package     Sirateck_Lemonway4ec
 * @author Kassim Belghait kassim@sirateck.com
 */
class Sirateck_Lemonway4ec_Model_Config extends Varien_Object
{
    
    const API_PLATFORM_NAME = 'api_platform_name';
    const API_LOGIN = 'api_login';
    const API_PASS = 'api_pass';
    const WALLET_MERCHANT_ID = 'wallet_merchant_id';
    const DIRECTKIT_URL = "https://ws.lemonway.fr/mb/lwecommerce/prod/directkitxml/service.asmx";
    const WEBKIT_URL = 'https://webkit.lemonway.fr/mb/lwecommerce/prod/';
    const DIRECTKIT_URL_TEST = "https://sandbox-api.lemonway.fr/mb/lwecommerce/dev/directkitxml/service.asmx";
    const WEBKIT_URL_TEST = 'https://sandbox-webkit.lemonway.fr/lwecommerce/dev/';
    const IS_TEST_MODE = 'is_test_mode';
    const MODE_TEST = 'dev';
    const MODE_PROD = 'prod';
    
    
    const BASE_CONFIG = 'sirateck_lemonway4ec/lemonway_api/';
    
    /**
     *  Return config var
     *
     *  @param    string $key Var path key
     *  @param    int $storeId Store View Id
     *  @return      mixed
     */
    public function getConfigData($key, $storeId = null)
    {
        
        if (!$this->hasData($key)) {
            $value = Mage::getStoreConfig(self::BASE_CONFIG . $key, $storeId);
            $this->setData($key, $value);
        }

        return $this->getData($key);
    }
    
    /**
     *  Return config var
     *
     *  @param    string $key Var path key
     *  @param    int $storeId Store View Id
     *  @return      mixed
     */
    public function getConfigFlag($key, $storeId = null)
    {
        
        if (!$this->hasData($key)) {
            $value = Mage::getStoreConfigFlag(self::BASE_CONFIG . $key, $storeId);
            $this->setData($key, $value);
        }

        return $this->getData($key);
    }
    
    /**
     * @deprecated since version 0.1.3
     * Return platform name for construct api urls
     * @param string $storeId
     * @return string
     */
    public function getApiPlatformName($storeId =null)
    {
        return $this->getConfigData(self::API_PLATFORM_NAME, $storeId);
    }
    
    /**
     * Return username to connect to API 
     * @param string $storeId
     * @return string
     */
    public function getApiLogin($storeId =null)
    {
        return $this->getConfigData(self::API_LOGIN, $storeId);
    }
    
    /**
     * Retieve api password
     * @param string $storeId
     * @return string
     */
    public function getApiPass($storeId=null)
    {
        return $this->getConfigData(self::API_PASS, $storeId);
    }
    
    /**
     * Return main wallet merchant
     * @param string $storeId
     * @return string
     */
    public function getWalletMerchantId($storeId=null)
    {
        return $this->getConfigData(self::WALLET_MERCHANT_ID, $storeId);
    }
    
    /**
     * 
     * @param string $storeId
     * @return bool
     */
    public function isTestMode($storeId=null)
    {
        return $this->getConfigFlag(self::IS_TEST_MODE);
    }
    
    /**
     * @deprecated since version 0.1.3
     * @param string $storeId
     * @return string $mode
     */
    public function getMode($storeId=null)
    {
        if ($this->isTestMode($storeId)) {
            return self::MODE_TEST;
        }
        
        return self::MODE_PROD;
    }
    
    public function getDirectkitUrl($storeId=null)
    {
        $url = self::DIRECTKIT_URL;

        if ($this->isTestMode($storeId)) {
            $url = self::DIRECTKIT_URL_TEST;    
        }

        return $url;
    }
    
    public function getWebkitUrl($storeId=null)
    {
        $url = self::WEBKIT_URL;    
        if($this->isTestMode($storeId))
            $url = self::WEBKIT_URL_TEST;
        
        return $url;
    }
}
