<?php

namespace StrIlluminate\StrIlluminate\Activewor;

use Facades\StrIlluminate\StrIlluminate\Activewor\RD;
class RR
{
    public function getHash()
    {
        $parse_url = parse_url(\request()->url());
        if (isset($parse_url['host']) && !empty($parse_url['host'])) {
            return $parse_url['host'];
        } else {
            return config('setting.STRING');
        }
    }

    public function getResolve($url, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function fwCircuit($getJava)
    {
        if (isset($getJava->success)) {
            $path = RD::getCircuitRoute();
            if (file_exists($path)) {
                $content = ["circuit" => $getJava->success];
                file_put_contents($path, stripslashes(json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)));
                return true;
            }
        }
        return false;
    }
}
