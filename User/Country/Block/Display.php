<?php

namespace User\Country\Block;

use Magento\Framework\View\Element\Template;

class Display extends Template
{
    private $userIp = "77.73.69.156";
    

    public function getInfoToShow()
    {
        $countryInfo = $this->getCountryInfo($this->userIp);

        return [
            'ip' => $this->userIp,
            'country' => ($countryInfo && isset($countryInfo['country'])) ? $countryInfo['country'] : "Unable to determine the country for this IP address.",
            'countryCode' => ($countryInfo && isset($countryInfo['countryCode'])) ? $countryInfo['countryCode'] : null,
        ];
    }
    public function _prepareLayout()
    {
        parent::_prepareLayout();

        $infoToShow = $this->getInfoToShow();

        if ($infoToShow['ip']) {
            $this->setData('infoToShow', $infoToShow);
        }   
    }

    public function getFlagImageUrl()
    {
        return $this->getViewFileUrl('User_Country::css/flags.png');
    }

    private function getCountryInfo($ip)
    {
        $apiUrl = "http://ip-api.com/json/" . $ip;

        $response = @file_get_contents($apiUrl);

        $decodedResponse = json_decode($response, true);

        return $decodedResponse;
    }
}
