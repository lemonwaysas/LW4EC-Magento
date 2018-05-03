<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Encrypted config field backend model
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Lemonway_Lemonway_Model_Adminhtml_Backend_Wallet extends Mage_Core_Model_Config_Data
{
    /**
     * Decrypt value after loading
     *
     */
    protected function _beforeSave()
    {
        try {
            $apiLogin = $this->getValue();
            $technical_wallet = Mage::getStoreConfig('Lemonway_lemonway/lemonway_config/technical_wallet_name');
            $environment_name = Mage::getStoreConfig('Lemonway_lemonway/lemonway_config/custom_environment_name');
            $password = Mage::app()->getRequest()->getPost('groups')["lemonway_api"]["fields"]["api_pass"]["value"];

            Mage::log(print_r("Login: " . $apiLogin, true), null, 'AdminLog.log');
            Mage::log(print_r("MDP: " . $password, true), null, 'AdminLog.log');
            Mage::log(print_r("Tech Wallet: " . $technical_wallet, true), null, 'AdminLog.log');
            Mage::log(print_r("Env: " . $environment_name, true), null, 'AdminLog.log');

            if (empty($environment_name)) {
                // If lwecommerce, get wallet by email
                $params = array('email' => $apiLogin);
            } else {
                // If custom env, get custom wallet
                $params = array('wallet' => $technical_wallet);
            }
            if ($password != "******") {
                $params['wlPass'] = $password;
            }
            $params['wlLogin'] = $apiLogin;

            Mage::log(print_r("MDP: " . Mage::getStoreConfig('Lemonway_lemonway/lemonway_api/api_pass'), true), null, 'AdminLog.log');
            Mage::log(print_r($params, true), null, 'Params.log');
            $wallet = Mage::getSingleton('Lemonway_lemonway/apikit_kit')->GetWalletDetails($params);
            Mage::log(print_r($wallet, true), null, 'AdminLog.log');
            Mage::getConfig()->saveConfig('Lemonway_lemonway/lemonway_api/wallet_merchant_id', $wallet->WALLET->ID, 'default', 0);
        } catch (Exception $e) {
            $session = Mage::getSingleton('adminhtml/session');
            $session->addException($e, Mage::helper('adminhtml')->__(' ') . $e->getMessage());
        }
        return parent::_beforeSave();
    }
}
