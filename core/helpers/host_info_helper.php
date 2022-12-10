<?php

/*
* @author Balaji
* @name Rainbow PHP Framework - PHP Script
* @copyright 2022 ProThemes.Biz
*
*/

function host_info($site) {

    $ip = $isp = $country = $tableData = '';

    $ch = curl_init('https://www.iplocationfinder.com/' . clean_url($site));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:93.0) Gecko/20100101 Firefox/93.0');
    $data = curl_exec($ch);
    curl_close($ch);

    $tableData = getCenterText('<tbody>', '</table>', $data);
    $ip = strip_tags(getCenterText('<th>IP:<td>', '<tr>', $tableData));
    $isp = strip_tags(getCenterText('<th>ISP:<td>', '<tr>', $tableData));
    $country = ucfirst(trim(strip_tags(getCenterText('<th>Country:<td>', '<tr>', $tableData))));

    if ($country == '') $country = 'Not Available';

    if ($isp == '') {
        if ($ip != '') {
            //Behind Cloudflare Check?
            $ranges = array('173.245.48.0/20', '103.21.244.0/22', '103.22.200.0/22', '103.31.4.0/22', '141.101.64.0/18', '108.162.192.0/18', '190.93.240.0/20', '188.114.96.0/20', '197.234.240.0/22', '198.41.128.0/17', '162.158.0.0/15', '104.16.0.0/13', '104.24.0.0/14', '172.64.0.0/13', '131.0.72.0/22');

            if (find_cidr($ip, $ranges)) {
                $isp = 'Cloudflare';
            } else {
                $isp = 'Not Available';
            }
        } else {
            $isp = 'Not Available';
        }
    }

    if ($ip == '') $ip = 'Not Available';

    return array($ip, $country, $isp);
}


function find_cidr($ip, $ranges)
{
    foreach ($ranges as $range) {
        if (cidr_match($ip, $range)) {
            return true;
        }
    }
    return false;
}

function cidr_match($ip, $range)
{
    list ($subnet, $bits) = explode('/', $range);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask;
    return ($ip & $mask) == $subnet;
}
