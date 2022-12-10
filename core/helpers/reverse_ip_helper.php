<?php

/*
 * @author Balaji
 * @name: A to Z SEO Tools - PHP Script
 * @copyright © 2017 ProThemes.Biz
 *
 */

function reverseIP($revIP){
    $link = "http://www.bing.com/search?q=ip%3A" . trim($revIP) .
        "&go=&qs=n&sk=&sc=8-5&form=QBLH";
    $source = getMyData($link);
    $s = explode('<span class="sb_count">', $source);
    $s = explode('<h4 class="b_hide">', $s[1]);
    $s = $s[0];
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>"; 
    
    if(preg_match_all("/$regexp/siU", $s, $matches)) {
        foreach($matches[2] as $link){
        if(!check_str_contains($link,'javascript:')){
            if(!check_str_contains($link,'microsofttranslator.com')){
                if(!check_str_contains($link,'microsoft.com')){
                    if(!check_str_contains($link,'#')){
                        if(!check_str_contains($link,'msn.com')){
                            if(!check_str_contains($link,$revIP)){
                            $link = parse_url($link);
                            $host = $link['host'];
                            if($host!=null || $host != "")
                            $revLink[] = $host;
                            }
                        }
                    }
                }
            }
        }
            
        }
    }
    return array_unique($revLink);
}
 
?>