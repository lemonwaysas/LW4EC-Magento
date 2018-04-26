<?php

class Lemonway_Lemonway_Model_Apikit_Kit
{

    public function RegisterWallet($params)
    {
        $res = $this->sendRequest('RegisterWallet', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->wallet = Mage::getModel('Lemonway_lemonway/apikit_apimodels_wallet', array($res->lwXml->WALLET));//new Wallet($res->lwXml->WALLET);
        }
        return $res;
    }

    public function MoneyIn($params)
    {
        $res = $this->sendRequest('MoneyIn', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->operations = array(Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($res->lwXml->TRANS->HPAY)));// array(new Operation($res->lwXml->TRANS->HPAY));
        }
        return $res;
    }

    public function UpdateWalletDetails($params)
    {
        $res = $this->sendRequest('UpdateWalletDetails', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->wallet = Mage::getModel('Lemonway_lemonway/apikit_apimodels_wallet', array($res->lwXml->WALLET));
        }
        return $res;
    }

    public function GetWalletDetails($params)
    {
        $res = $this->sendRequest('GetWalletDetails', $params, '1.5');
//        if (!isset($res->lwError)) {
//            $res->wallet = Mage::getModel('Lemonway_lemonway/apikit_apimodels_wallet', array($res->lwXml->WALLET));
//        }
        return $res;
    }

    public function MoneyIn3DInit($params)
    {
        return $this->sendRequest('MoneyIn3DInit', $params, '1.1');
    }

    public function MoneyIn3DConfirm($params)
    {
        return $this->sendRequest('MoneyIn3DConfirm', $params, '1.1');
    }

    public function MoneyInWebInit($params)
    {
        return $this->sendRequest('MoneyInWebInit', $params, '1.3');
    }

    public function RegisterCard($params)
    {
        return $this->sendRequest('RegisterCard', $params, '1.1');
    }

    public function UnregisterCard($params)
    {
        return $this->sendRequest('UnregisterCard', $params, '1.0');
    }

    public function MoneyInWithCardId($params)
    {
        $res = $this->sendRequest('MoneyInWithCardId', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->operations = array(Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($res->lwXml->TRANS->HPAY)));
        }
        return $res;
    }

    public function MoneyInValidate($params)
    {
        return $this->sendRequest('MoneyInValidate', $params, '1.0');
    }

    public function SendPayment($params)
    {
        $res = $this->sendRequest('SendPayment', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operations = array(Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($res->lwXml->TRANS->HPAY)));
        }
        return $res;
    }

    public function RegisterIBAN($params)
    {
        $res = $this->sendRequest('RegisterIBAN', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->iban = Mage::getModel('Lemonway_lemonway/apikit_apimodels_iban', array($res->lwXml->IBAN));;//new Iban($res->lwXml->IBAN);
        }
        return $res;
    }

    public function MoneyOut($params)
    {
        $res = $this->sendRequest('MoneyOut', $params, '1.3');
        if (!isset($res->lwError)) {
            $res->operations = array(Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($res->lwXml->TRANS->HPAY)));
        }
        return $res;
    }

    public function GetPaymentDetails($params)
    {
        $res = $this->sendRequest('GetPaymentDetails', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($HPAY));
            }
        }
        return $res;
    }

    public function GetMoneyInTransDetails($params)
    {
        $res = $this->sendRequest('GetMoneyInTransDetails', $params, '1.8');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->TRANS->HPAY as $HPAY) {
                $res->operations[] = Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($HPAY));
            }
        }
        return $res;
    }

    public function GetMoneyOutTransDetails($params)
    {
        $res = $this->sendRequest('GetMoneyOutTransDetails', $params, '1.4');
        if (!isset($res->lwError)) {
            $res->operations = array();
            foreach ($res->lwXml->TRANS->HPAY as $HPAY) {
                $res->operations[] = Mage::getModel('Lemonway_lemonway/apikit_apimodels_operation', array($HPAY));
            }
        }
        return $res;
    }

    public function UploadFile($params)
    {
        $res = $this->sendRequest('UploadFile', $params, '1.1');
        if (!isset($res->lwError)) {
            $res->kycDoc = Mage::getModel('Lemonway_lemonway/apikit_apimodels_kycDoc', array($res->lwXml->UPLOAD));;//new KycDoc($res->lwXml->UPLOAD);
        }
        return $res;
    }

    public function GetKycStatus($params)
    {
        return $this->sendRequest('GetKycStatus', $params, '1.5');
    }

    public function GetMoneyInIBANDetails($params)
    {
        return $this->sendRequest('GetMoneyInIBANDetails', $params, '1.4');
    }

    public function RefundMoneyIn($params)
    {
        return $this->sendRequest('RefundMoneyIn', $params, '1.2');
    }

    public function GetBalances($params)
    {
        return $this->sendRequest('GetBalances', $params, '1.0');
    }

    public function MoneyIn3DAuthenticate($params)
    {
        return $this->sendRequest('MoneyIn3DAuthenticate', $params, '1.0');
    }

    public function MoneyInIDealInit($params)
    {
        return $this->sendRequest('MoneyInIDealInit', $params, '1.0');
    }

    public function MoneyInIDealConfirm($params)
    {
        return $this->sendRequest('MoneyInIDealConfirm', $params, '1.0');
    }

    public function RegisterSddMandate($params)
    {
        $res = $this->sendRequest('RegisterSddMandate', $params, '1.0');
        if (!isset($res->lwError)) {
            $res->sddMandate = Mage::getModel('Lemonway_lemonway/apikit_apimodels_sddMandate', array($res->lwXml->SDDMANDATE));;//new SddMandate($res->lwXml->SDDMANDATE);
        }
        return $res;
    }

    public function UnregisterSddMandate($params)
    {
        return $this->sendRequest('UnregisterSddMandate', $params, '1.0');
    }

    public function MoneyInSddInit($params)
    {
        return $this->sendRequest('MoneyInSddInit', $params, '1.0');
    }

    public function GetMoneyInSdd($params)
    {
        return $this->sendRequest('GetMoneyInSdd', $params, '1.0');
    }

    public function GetMoneyInChequeDetails($params)
    {
        return $this->sendRequest('GetMoneyInChequeDetails', $params, '1.4');
    }

    /**
     *
     * @param string $methodName
     * @param array $params
     * @param float $version
     * @return Lemonway_Lemonway_Model_Apikit_Apiresponse $apiResponse
     */
    private function sendRequest($methodName, $params, $version)
    {
        $ua = '';
        if (isset($_SERVER['HTTP_USER_AGENT']))
            $ua = $_SERVER['HTTP_USER_AGENT'];
        $ip = '';
        if (isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];

        $baseParams = array(
            'wlLogin' => $this->getConfig()->getApiLogin(),
            'wlPass' => $this->getConfig()->getApiPass(),
            'language' => 'fr',
            'version' => $version,
            'walletIp' => $ip,
            'walletUa' => $ua,
        );


        $requestParams = array_merge($baseParams, $params);
        $requestParams = array('p' => $requestParams);


        Mage::log(json_encode($requestParams), null, 'logfile.log');

        //self::printDirectkitInput($requestParams);

        $headers = array(
            "Content-type: application/json; charset=utf-8",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache"
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getConfig()->getDirectkitUrl() . '/' . $methodName);
        Mage::log($this->getConfig()->getDirectkitUrl() . '/' . $methodName, null, 'logfile.log');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //Mage::log($this->getConfig()->getDirectkitUrl());
        $response = curl_exec($ch);

        Mage::log($response, null, 'logfile.log');

        if (curl_errno($ch)) {
            Mage::throwException(curl_error($ch));
        } else {
            $responseCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            Mage::log($responseCode, null, 'logfile.log');

            $error = true;

            $message = "";
            switch ($responseCode) {
                case 200:
                    break;
                case 400:
                    $message = "Bad Request : The server cannot or will not process the request due to something that is perceived to be a client error";
                    break;
                case 403:
                    $message = "IP is not allowed to access Lemon Way's API, please contact support@lemonway.fr";
                    break;
                case 404:
                    $message = "Check that the access URLs are correct. If yes, please contact support@lemonway.fr";
                    break;
                case 500:
                    $message = "Lemon Way internal server error, please contact support@lemonway.fr";
                    break;
                default:
                    sprintf("HTTP CODE %d IS NOT SUPPORTED", $responseCode);
                    break;
            }


            if ($responseCode == 200) {
                //General parsing
                $response = json_decode($response);

                //Check error
                if (isset($response->d->E)) {
                    Mage::throwException($response->d->E->Msg, $response->d->E->Code);
                }

                return $response->d;
            }
        }
        curl_close($ch);
    }

    public function printCardForm($moneyInToken, $cssUrl = '', $language = 'fr')
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getConfig()->getWebkitUrl() . "?moneyintoken=" . $moneyInToken . '&p=' . urlencode($cssUrl) . '&lang=' . $language);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !$this->getConfig()->isTestMode());

        $server_output = curl_exec($ch);
        if (curl_errno($ch)) {
            print(curl_error($ch));//TODO : handle error
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($returnCode) {
                case 200:
                    curl_close($ch);
                    print($server_output);
                    break;
                default:
                    print($returnCode);//TODO : handle error
                    break;
            }
        }
    }

    /**
     * @return Lemonway_Lemonway_Model_Config
     */
    protected function getConfig()
    {
        return Mage::getSingleton('Lemonway_lemonway/config');
    }
}

?>