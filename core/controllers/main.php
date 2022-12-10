<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author Balaji
 * @name: A to Z SEO Tools - PHP Script
 * @copyright 2021 ProThemes.Biz
 *
 */

$tools = array();

$result = mysqli_query($con, 'SELECT tool_show,tool_name,tool_url,icon_name,tool_no FROM seo_tools ORDER BY CAST(tool_no AS UNSIGNED) ASC');
while ($row = mysqli_fetch_assoc($result)){

    if(isSelected($row['tool_show'])) 
        $tools[] = array(shortCodeFilter($row['tool_name']),createLink($row['tool_url'],true),$row['icon_name'],$row['tool_show'],$row['tool_no']);
}
