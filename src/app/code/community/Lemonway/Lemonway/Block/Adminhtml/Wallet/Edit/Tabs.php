<?php
/**
 * Magento_Lemonway_Ecommerce extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Lemonway
 * @package        Magento_Lemonway_Ecommerce
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Wallet admin edit tabs
 *
 * @category    Lemonway
 * @package     Magento_Lemonway_Ecommerce
 * @author Kassim Belghait kassim@Lemonway.com
 */
class Lemonway_Lemonway_Block_Adminhtml_Wallet_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Kassim Belghait kassim@Lemonway.com
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('wallet_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('Lemonway_lemonway')->__('Wallet'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Lemonway_Lemonway_Block_Adminhtml_Wallet_Edit_Tabs
     * @author Kassim Belghait kassim@Lemonway.com
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_wallet',
            array(
                'label'   => Mage::helper('Lemonway_lemonway')->__('Wallet'),
                'title'   => Mage::helper('Lemonway_lemonway')->__('Wallet'),
                'content' => $this->getLayout()->createBlock(
                    'Lemonway_lemonway/adminhtml_wallet_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve wallet entity
     *
     * @access public
     * @return Lemonway_Lemonway_Model_Wallet
     * @author Kassim Belghait kassim@Lemonway.com
     */
    public function getWallet()
    {
        return Mage::registry('current_wallet');
    }
}
