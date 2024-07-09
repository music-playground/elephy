<?php

namespace WhtsPoint\Elephy\Util;

use WhtsPoint\Elephy\Exception\HttpException;

class Curl
{
    /**
     * @throws HttpException
     */
    public function send(array $options): string
    {
        $ch = curl_init();

        curl_setopt_array(
            $ch,
            [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 0
            ] + $options
        );

        $output = curl_exec($ch);
        $code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (curl_errno($ch) !== 0 || $code[0] !== '2') {
            throw new HttpException($code, $output);
        }

        return $output;
    }
}