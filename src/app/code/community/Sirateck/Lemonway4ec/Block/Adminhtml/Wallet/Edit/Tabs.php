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
 * Wallet admin edit tabs
 *
 * @category    Sirateck
 * @package     Sirateck_Lemonway4ec
 * @author Kassim Belghait kassim@sirateck.com
 */
class Sirateck_Lemonway4ec_Block_Adminhtml_Wallet_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Kassim Belghait kassim@sirateck.com
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('wallet_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sirateck_lemonway4ec')->__('Wallet'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Sirateck_Lemonway4ec_Block_Adminhtml_Wallet_Edit_Tabs
     * @author Kassim Belghait kassim@sirateck.com
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_wallet',
            array(
                'label'   => Mage::helper('sirateck_lemonway4ec')->__('Wallet'),
                'title'   => Mage::helper('sirateck_lemonway4ec')->__('Wallet'),
                'content' => $this->getLayout()->createBlock(
                    'sirateck_lemonway4ec/adminhtml_wallet_edit_tab_form'
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
     * @return Sirateck_Lemonway4ec_Model_Wallet
     * @author Kassim Belghait kassim@sirateck.com
     */
    public function getWallet()
    {
        return Mage::registry('current_wallet');
    }
}
