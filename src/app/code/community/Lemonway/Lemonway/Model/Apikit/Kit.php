<?php

class Lemonway_Lemonway_Model_Apikit_Kit
{
    public function RegisterWallet($params)
    {
        return $this->sendRequest('RegisterWallet', $params);
    }

    public function MoneyIn($params)
    {
        return $this->sendRequest('MoneyIn', $params);
    }

    public function UpdateWalletDetails($params)
    {
        return $this->sendRequest('UpdateWalletDetails', $params);
    }

    public function GetWalletDetails($params)
    {
        return $this->sendRequest('GetWalletDetails', $params);
    }

    public function MoneyIn3DInit($params)
    {
        return $this->sendRequest('MoneyIn3DInit', $params);
    }

    public function MoneyIn3DConfirm($params)
    {
        return $this->sendRequest('MoneyIn3DConfirm', $params);
    }

    public function MoneyInWebInit($params)
    {
        return $this->sendRequest('MoneyInWebInit', $params);
    }

    public function RegisterCard($params)
    {
        return $this->sendRequest('RegisterCard', $params);
    }

    public function UnregisterCard($params)
    {
        return $this->sendRequest('UnregisterCard', $params);
    }

    public function MoneyInWithCardId($params)
    {
        return $this->sendRequest('MoneyInWithCardId', $params);
    }

    public function MoneyInValidate($params)
    {
        return $this->sendRequest('MoneyInValidate', $params);
    }

    public function SendPayment($params)
    {
        return $this->sendRequest('SendPayment', $params);
    }

    public function RegisterIBAN($params)
    {
        return $this->sendRequest('RegisterIBAN', $params);
    }

    public function MoneyOut($params)
    {
        return $this->sendRequest('MoneyOut', $params);
    }

    public function GetPaymentDetails($params)
    {
        return $this->sendRequest('GetPaymentDetails', $params);

    }

    public function GetMoneyInTransDetails($params)
    {
        return $this->sendRequest('GetMoneyInTransDetails', $params);
    }

    public function GetMoneyOutTransDetails($params)
    {
        return $this->sendRequest('GetMoneyOutTransDetails', $params);
    }

    public function UploadFile($params)
    {
        return $this->sendRequest('UploadFile', $params);
    }

    public function GetKycStatus($params)
    {
        return $this->sendRequest('GetKycStatus', $params);
    }

    public function GetMoneyInIBANDetails($params)
    {
        return $this->sendRequest('GetMoneyInIBANDetails', $params);
    }

    public function RefundMoneyIn($params)
    {
        return $this->sendRequest('RefundMoneyIn', $params);
    }

    public function GetBalances($params)
    {
        return $this->sendRequest('GetBalances', $params);

    }

    public function MoneyIn3DAuthenticate($params)
    {
        return $this->sendRequest('MoneyIn3DAuthenticate', $params);

    }

    public function MoneyInIDealInit($params)
    {
        return $this->sendRequest('MoneyInIDealInit', $params);
    }

    public function MoneyInIDealConfirm($params)
    {
        return $this->sendRequest('MoneyInIDealConfirm', $params);
    }

    public function RegisterSddMandate($params)
    {
        return $this->sendRequest('RegisterSddMandate', $params);
    }

    public function UnregisterSddMandate($params)
    {
        return $this->sendRequest('UnregisterSddMandate', $params);
    }

    public function MoneyInSddInit($params)
    {
        return $this->sendRequest('MoneyInSddInit', $params);
    }

    public function GetMoneyInSdd($params)
    {
        return $this->sendRequest('GetMoneyInSdd', $params);
    }

    public function GetMoneyInChequeDetails($params)
    {
        return $this->sendRequest('GetMoneyInChequeDetails', $params);
    }

    private function getUserIP()
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "127.0.0.1";
        }
        return $ip;
    }

    /**
     *
     * @param string $methodName
     * @param array $params
     * @param float $version
     * @return Lemonway_Lemonway_Model_Apikit_Apiresponse $apiResponse
     */
    private function sendRequest($methodName, $params)
    {
        $ua = '';
        if (isset($_SERVER['HTTP_USER_AGENT']))
            $ua = $_SERVER['HTTP_USER_AGENT'];


        $baseParams = array(
            'wlLogin' => $this->getConfig()->getApiLogin(),
            'wlPass' => $this->getConfig()->getApiPass(),
            'language' => 'fr',
            'version' => '10.0',
            'walletIp' => $this->getUserIP(),
            'walletUa' => $ua,
        );

        $requestParams = array_merge($baseParams, $params);
        $requestParams = array('p' => $requestParams);

        Mage::log(json_encode($requestParams), null, 'logfile.log');

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
                    Mage::throwException($response->d->E->Msg . " (Error code: " . $response->d->E->Code . ")");
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