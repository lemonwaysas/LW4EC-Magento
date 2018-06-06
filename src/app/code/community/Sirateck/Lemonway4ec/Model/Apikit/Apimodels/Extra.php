<?php
/**
 * Detailed information regarding Card payment
 */
class Sirateck_Lemonway4ec_Model_Apikit_Apimodels_Extra extends Varien_Object
{
    /**
     * CTRY country of card
     * @var string
     */
    public $CTRY;
    
    /**
     * AUTH authorization number
     * @var string
     */
    public $AUTH;
    
    /**
     * Number of registered card
     * @var string
     * @since api version 1.8
     */
    public $NUM;
    
    /**
     * Expiration date of registered card
     * @var string
     * @since api version 1.8
     */
    public $EXP;

    /**
     * Type of card
     * @var string
     * @since api version 1.8
     */
    public $TYP;
    
    public function __construct($extraXml)
    {
        $this->AUTH = $extraXml->AUTH;
        $this->CTRY = $extraXml->CTRY;
        $this->NUM = $extraXml->NUM;
        $this->EXP = $extraXml->EXP;
        $this->TYP = $extraXml->TYP;
    }
}
