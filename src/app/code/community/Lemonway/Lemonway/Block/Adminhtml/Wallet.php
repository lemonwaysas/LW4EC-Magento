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
 * Wallet admin block
 *
 * @category    Lemonway
 * @package     Magento_Lemonway_Ecommerce
 * @author Kassim Belghait kassim@Lemonway.com
 */
class Lemonway_Lemonway_Block_Adminhtml_Wallet extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Kassim Belghait kassim@Lemonway.com
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_wallet';
        $this->_blockGroup = 'Lemonway_lemonway';
        parent::__construct();
        $this->_headerText = Mage::helper('Lemonway_lemonway')->__('Wallet');
        $this->_removeButton('add');
        //$this->_updateButton('add', 'label', Mage::helper('Lemonway_lemonway')->__('Add Wallet'));
    }
}
