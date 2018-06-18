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
 * Main Controller
 *
 * @category    Lemonway
 * @package     Magento_Lemonway_Ecommerce
 * @author Kassim Belghait kassim@Lemonway.com
 */
class Lemonway_Lemonway_PaymentController extends Mage_Core_Controller_Front_Action
{
    protected $_order = null;
    /**
     *
     * @var Lemonway_Lemonway_Model_Apikit_Apimodels_Operation
     */
    protected $_moneyin_trans_details = null;

    public function preDispatch()
    {
        parent::preDispatch();

        $action = $this->getRequest()->getRequestedActionName();
        if ($this->getRequest()->isPost() && !$this->_validateOperation($action)) {
            $this->getResponse()->setBody("NOK. Wrong Operation!");
            $this->setFlag('', 'no-dispatch', true);
        }
    }

    protected function _validateOperation($action)
    {
        $actionToStatus = array("return" => "3", "error" => "0", "cancel" => "0");
        if (!isset($actionToStatus[$action]))
            return false;
        if ($this->getMoneyInTransDetails()->TRANS->HPAY[0]->STATUS == $actionToStatus[$action])
            return true;
        return false;
    }

    /**
     * Call api to get transaction detail for this transaction
     * @return Lemonway_Lemonway_Model_Apikit_Apimodels_Operation
     */
    protected function getMoneyInTransDetails()
    {
        if (is_null($this->_moneyin_trans_details)) {
            // Call directkit to get wkToken
            // Date to timestamp
            $time=strtotime($this->_getOrder()->getCreatedAt());
            $params = array('transactionMerchantToken' =>$time."_". $this->_getOrder()->getIncrementId());

            //Init API kit
            /* @var $kit Lemonway_Lemonway_Model_Apikit_Kit */
            $kit = Mage::getSingleton('Lemonway_lemonway/apikit_kit');

            $res = $kit->GetMoneyInTransDetails($params);
            if (isset($res->lwError)) {
                Mage::throwException("Error code: " . $res->lwError->getCode() . " Message: " . $res->lwError->getMessage());
            }
            $this->_moneyin_trans_details = $res;
        }
        return $this->_moneyin_trans_details;
    }

    /**
     * Get singleton of Checkout Session Model
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * @return Mage_Sales_Model_Order
     */
    protected function _getOrder()
    {
        if (is_null($this->_order)) {

            //The strpos() finds the offset of the underscore, then substr grabs everything from that index plus 1, onwards.
            $data = $this->getRequest()->getParam('response_wkToken');
            $responseToken=substr($data, strpos($data, "_") + 1);
            $order = Mage::getModel('sales/order')->loadByIncrementId($responseToken);

            if ($order->getId())
                $this->_order = $order;
            else {
                Mage::logException(new Exception("Order not Found"));
                Mage::throwException("Order not found!");
            }
        }

        return $this->_order;
    }

    /**
     *  Create invoice for order
     *
     * @param    Mage_Sales_Model_Order $order
     * @return      boolean Can save invoice or not
     */
    protected function createInvoice($order)
    {
        if ($order->canInvoice()) {

            $version = Mage::getVersion();
            $version = substr($version, 0, 5);
            $version = str_replace('.', '', $version);
            while (strlen($version) < 3) {
                $version .= "0";
            }
            if (((int)$version) < 111) {
                $convertor = Mage::getModel('sales/convert_order');
                $invoice = $convertor->toInvoice($order);
                foreach ($order->getAllItems() as $orderItem) {
                    if (!$orderItem->getQtyToInvoice()) {
                        continue;
                    }
                    $item = $convertor->itemToInvoiceItem($orderItem);
                    $item->setQty($orderItem->getQtyToInvoice());
                    $invoice->addItem($item);
                }
                $invoice->collectTotals();
            } else {
                $invoice = $order->prepareInvoice();
            }

            $invoice->register()->capture();
            Mage::getModel('core/resource_transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder())
                ->save();
            return true;
        }
        return false;
    }

    /**
     * Success Action
     * Used for redirection and notification process
     */
    public function returnAction()
    {
        if (!$this->getRequest()->isGet() && !$this->getRequest()->isPost()) {
            die("HTTP Method not Allowed");
        }
        $params = $this->getRequest()->getParams();
        $order = $this->_getOrder();

        $successUrl = 'checkout/onepage/success';

        if ($this->getRequest()->isGet()) {
            if (Mage::helper('Lemonway_lemonway')->oneStepCheckoutInstalled()) {
                $successUrl = 'onestepcheckout/index/success';
            }
            $this->_redirect($successUrl);
            $methodInstance = Mage::getSingleton('Lemonway_lemonway/method_webkit');
            if (!$status = $methodInstance->getConfigData('order_status_success')) {
                $status = $order->getStatus();
            }
            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $status);
        } elseif ($this->getRequest()->isPost()) {
            if ($params['response_code'] == "0000") { // Success
                $methodInstance = Mage::getSingleton('Lemonway_lemonway/method_webkit');
                if (!$status = $methodInstance->getConfigData('order_status_success')) {
                    $status = $order->getStatus();
                }
                $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $status);
            } else { // Error
                if ($order->canCancel()) {
                    $order->cancel();
                }
            }
        }
        // Doublecheck
        $details = $this->getMoneyInTransDetails();
        if ($details->TRANS->HPAY[0]->STATUS == '3') {
            $realAmount = $details->TRANS->HPAY[0]->COM + $details->TRANS->HPAY[0]->CRED;

            if (($order->getBaseGrandTotal() == $realAmount)) {
                $methodInstance = Mage::getSingleton('Lemonway_lemonway/method_webkit');
                if (!$status = $methodInstance->getConfigData('order_status_success')) {
                    $status = $order->getStatus();
                }
                $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $status);
            }
        } else {
            if ($order->canCancel()) {
                $order->cancel();
            }
        }
        try {
            $order->save();
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::throwException($e->getMessage());
        }

        return $this;
    }

    /**
     * Transaction canceled by user
     */
    public function cancelAction()
    {
        //When canceled by user, notification by POST not sended
        //So we cancel with get request
        if ($this->getRequest()->isGet()) {

            $order = $this->_getOrder();
            $status = $order->getStatus();
            $message = $this->__('Transaction was canceled by customer');
            $order->addStatusToHistory($status, $message);

            if ($order->canCancel()) {
                $order->cancel();
            }
            $order->save();

            //Reload products in cart
            Mage::helper('Lemonway_lemonway')->reAddToCart($order->getIncrementId());

            $this->_getCheckout()->addError($this->__('Your order is canceled.'));
            $this->_redirect('checkout/cart');

        } else {
            die("HTTP Method not Allowed");
        }
        return $this;
    }

    /**
     * Transaction Failure action.
     */
    public function errorAction()
    {
        //When transaction failed, notification by POST not sended
        //So we cancel the order with GET request
        if ($this->getRequest()->isGet()) {
            //DATA POST FROM NOTIFICATION
            $order = $this->_getOrder();

            if ($order->canCancel()) {
                $order->cancel();
            }

            $status = $order->getStatus();
            $message = $this->__('Transaction Failed. Order was canceled automatically.');
            $order->addStatusToHistory($status, $message);

            try {
                $order->save();
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::throwException($e->getMessage());
            }
            $this->_redirect('checkout/onepage/failure');
            return $this;
        } else {
            die("HTTP Method not Allowed");
        }

    }


}
