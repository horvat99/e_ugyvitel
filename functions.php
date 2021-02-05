<?php

function getCountryByIp(): string
{
    $country = "unknown country";
    $ip = "unknown ip";
    $url = "https://www.iplocate.io/api/lookup/";

    # Client URL Library  https://www.php.net/manual/en/book.curl.php
    # https://doc.bccnsoft.com/docs/php-docs-7-en/function.curl-setopt.html

    $curl = curl_init();
    # Initialize a cURL session
    curl_setopt($curl, CURLOPT_URL, $url);
    # The URL to fetch. This can also be set when initializing a session with curl_init().
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    #  	TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_HEADER, false);
    #  	TRUE to include the header in the output.
    $details = json_decode(curl_exec($curl), true);
    # Perform a cURL session
    curl_close($curl);
    # Close a cURL session

    if (!empty($details['country'])) {
        $country = $details['country'];
    }

    return $country;
}

function getIpAdress(): string
{
    $country = "unknown country";
    $ip = "unknown ip";
    $url = "https://www.iplocate.io/api/lookup/";

    # Client URL Library  https://www.php.net/manual/en/book.curl.php
    # https://doc.bccnsoft.com/docs/php-docs-7-en/function.curl-setopt.html

    $curl = curl_init();
    # Initialize a cURL session
    curl_setopt($curl, CURLOPT_URL, $url);
    # The URL to fetch. This can also be set when initializing a session with curl_init().
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    #  	TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_HEADER, false);
    #  	TRUE to include the header in the output.
    $details = json_decode(curl_exec($curl), true);
    # Perform a cURL session
    curl_close($curl);
    # Close a cURL session

    if (!empty($details['ip'])) {
        $ip = $details['ip'];
    }

    return $ip;
}