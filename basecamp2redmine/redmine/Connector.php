<?php
namespace basecamp2redmine\redmine;

use basecamp2redmine\abstracts\AbstractConnector;
use basecamp2redmine\exceptions\ApiException;

class Connector extends AbstractConnector {
    protected function curlexec(&$ch)
    {
        $result = parent::curlexec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == 422) {
            if (($resp = json_decode($result, true)) && isset($resp['errors'])) {
                throw new ApiException(implode(', ', $resp['errors']));
            } else {
                throw new ApiException('HTTP Error 422');
            }
        }
        return $result;
    }

    protected function checkerror(&$ch)
    {
        parent::checkerror($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code >= 400) {
            throw new ApiException('HTTP Error '.$code);
        }
    }

    protected function setoptions(&$ch)
    {
        parent::setoptions($ch);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
    }

//    protected function preparepost(&$ch, $data)
//    {
//        curl_setopt($ch, CURLOPT_POST, true);
//        if ($data) {
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        }
//    }


}
