<?php

function dieWithJsonMessage($message, $code = 400)
{
    $error = [
        'code' => $code,
        'message' => $message,
    ];
    $result = [
        'error' => $error,
    ];
    die(json_encode($result, JSON_PRETTY_PRINT));
}

function detectedAsSendingUnusualTraffic()
{
    dieWithJsonMessage('YouTube has detected unusual traffic from this YouTube operational API instance. Please try your request again later or see alternatives at https://github.com/Benjamin-Loison/YouTube-operational-API/issues/11', 403);
}

function getContextFromOpts($opts)
{
    if (GOOGLE_ABUSE_EXEMPTION !== '') {
        $cookieToAdd = 'GOOGLE_ABUSE_EXEMPTION=' . GOOGLE_ABUSE_EXEMPTION;

        $opts['http']['header'][] = 'Cookie: ' . ($opts['http']['header'] ?? []) + [$cookieToAdd];

        $context = stream_context_create($opts);
        return $context;
    }
}

function getHeadersFromOpts($url, $opts)
{
    $context = getContextFromOpts($opts);
    $headers = get_headers($url, false, $context);
    return $headers;
}