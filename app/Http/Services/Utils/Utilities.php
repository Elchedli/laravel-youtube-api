<?php

namespace App\Http\Services\Utils;
require_once('tools/UtilitiesFunctions.php');

define('GOOGLE_ABUSE_EXEMPTION', '');
define('HTTP_CODES_DETECTED_AS_SENDING_UNUSUAL_TRAFFIC', [302, 403, 429]);
class Utilities
{
    public static function isRedirection($url)
    {
        $opts = [
            'http' => [
                'ignore_errors' => true,
            ],
        ];
        $http_response_header = getHeadersFromOpts($url, $opts);
        $code = intval(explode(' ', $http_response_header[0])[1]);
        if (in_array($code, HTTP_CODES_DETECTED_AS_SENDING_UNUSUAL_TRAFFIC)) {
            detectedAsSendingUnusualTraffic();
        }
        return $code == 303;
    }
}


