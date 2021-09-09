<?php

namespace Sa\Content\Helper;

use Sa\Content\Helper\Data as DataHelper;

class Api
{
    protected $_dataHelper;

    public function __construct(
        DataHelper $dataHelper
    ) {
        $this->_dataHelper = $dataHelper;
    }

    public function getProxy()
    {
        return $this->_dataHelper->getGeneralConfig('proxy')
            ? $this->_dataHelper->getGeneralConfig('proxy')
            : null
        ;
    }

    public function getTokenPlatform()
    {
        return $this->_dataHelper->getGeneralConfig('token_platform')
            ? $this->_dataHelper->getGeneralConfig('token_platform')
            : null
        ;
    }

    public function getPage($slug) 
    {        
        $token = $this->getTokenPlatform() ? $this->getTokenPlatform() : 'token_';
        $url = "https://content.plateforme.wip/api/v1/page/" . $slug . '/' . $token;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url); 

        $proxy = $this->getProxy();
        if($proxy && $proxy != "") {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $data = json_decode($output, true);
        $infos = curl_getinfo($ch);

        curl_close($ch);

        return $data;
    }
}