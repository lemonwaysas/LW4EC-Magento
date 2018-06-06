<?php

/**
 * 
 * @method string getMessage()
 * @method int getCode()
 *
 */
class Sirateck_Lemonway4ec_Model_Apikit_Apimodels_LwError Extends Varien_Object
{
    public function __construct($arr = array()) 
    {
        if ($arr) {        
            $this->_data['code'] = $arr[0];
            $this->_data['message'] = $arr[1];
        }
    }
}
