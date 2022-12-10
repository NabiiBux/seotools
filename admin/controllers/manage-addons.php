<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
* @author Balaji
* @name: Rainbow PHP Framework
* @copyright 2022 ProThemes.Biz
*
*/

$activeTheme = getTheme($con);

$pageTitle = "Manage Addons";
$subTitle = "Install Add-on";
$fullLayout = 1; $footerAdd = false;

$addonDir = ADMIN_DIR.'addons';

$minError = false;
if(!class_exists('ZipArchive')){
    $minError = true;
    $minMsg[] = array('ZipArchive Extension','<span class="label label-danger">Not Found</span>'); 
}else{
    $minMsg[] = array('ZipArchive Extension','<span class="label label-success">Found</span>'); 
}

if (is_writable($addonDir)) {
    $minMsg[] = array('Directory - "<b>/admin/addons</b>"','<span class="label label-success">Writable</span>'); 
} else {
    $minError = true;
    $minMsg[] = array('Directory - "<b>/admin/addons</b>"','<span class="label label-danger">Not Writable</span>'); 
}

$minMsg[] = array('PHP Upload Limit','<span class="label label-warning">'.formatBytes(file_upload_max_size()).'</span>');

if($pointOut === 'delete'){
    if(isset($args[0]) && $args[0] !== ''){
        $delFileName = raino_trim($args[0]);
        $delPath = $addonDir.D_S.$delFileName.'.addonpk';

        if(file_exists($delPath)) {
            unlink($delPath);
            if (!file_exists($delPath)){
                redirectTo(adminLink($controller, true));
            }
        }
    }
    $msg = errorMsgAdmin('Sorry, unable to delete the file.');
}

//Install Addon
if (isset($_POST['addonID']))
{
    $target_dir = ADMIN_DIR . "addons/";
    $target_filename = basename($_FILES["addonUpload"]["name"]);
    $target_file = $target_dir . $target_filename;
    $uploadSs = 1;
    // Check if file already exists
    if (file_exists($target_file))
    {
        $target_filename = rand(1, 99999) . "_" . $target_filename;
        $target_file = $target_dir . $target_filename;
    }
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check file size
    if ($_FILES["addonUpload"]["size"] > 999500000){
        $msg = errorMsgAdmin('Sorry, your file is too large.');
        $uploadSs = 0;
    } else
    {
        // Allow certain file formats
        if ($imageFileType != "zip" && $imageFileType != "zipx" && $imageFileType != "addonpk")
        {
            $msg = errorMsgAdmin('Sorry, only ZIP, ZIPX and ADDONPK files are allowed.');
            $uploadSs = 0;
        }
    }

    // Check if $uploads is set to 0 by an error
    if (!$uploadSs == 0)
    {
        //No Error - Move the file to addon directory
        if (move_uploaded_file($_FILES["addonUpload"]["tmp_name"], $target_file))
        {
            $msg = successMsgAdmin('Adddon was successfully uploaded');
            
            //Package File Path
            $file_path = $target_dir . $target_filename;
            
            //Temporarily extract Addons Data
            $addon_path = ADMIN_DIR . "addons/" . "ad_" . rand(1000, 999999);
            extractZip($file_path, $addon_path);
            
            //Check Addons Installer is exists 
            if (file_exists($addon_path . "/atozseov3.tdata")){
                if (file_exists($addon_path . "/install.php"))
                {
                    //Found - Process Installer
                    require_once ($addon_path . "/install.php");
                    
                    if($activeTheme != 'default' && $activeTheme != 'simpleX'){
                        $addonRes.= "Copying Theme Files to $activeTheme<br>";
                        recurse_copy($addon_path."/theme/default",ROOT_DIR."/theme/$activeTheme");
                    }
                }else{
                    //Not Found
                    $addonRes = "Addons Installer is not detected!";
                    $addonError = true;
                    $errType = 1;
                }
            } elseif (file_exists($addon_path . "/atozseo.tdata")){
                $addonRes = "Incompatible with AtoZ SEO Tools v3.2 <br>Update your addon into the latest version!";
                $addonError = true;
                $errType = 1;
            }else{
                //Not Found
                $addonRes = "Not compatible add-on!";
                $addonError = true;
                $errType = 1; 
            }
            $addonRes = str_replace(array("<br>","<br/>","<br />"),PHP_EOL,$addonRes);
            //Delete the Addons Data
            delDir($addon_path);
            
            //Delete the package file
            delFile($file_path);
            $controller = "process-addon";

        } else{
            $msg = errorMsgAdmin('Sorry, there was an error uploading your file.');
        }
    }
}

$manualInstallFiles = array();
$manualInstall = false;

//Custom Cron Job Files
if(file_exists($addonDir)) {
    foreach (glob($addonDir . D_S . '*.addonpk', GLOB_BRACE) as $filename) {
        $manualInstallFiles[] = basename($filename);
        $manualInstall = true;
    }
}