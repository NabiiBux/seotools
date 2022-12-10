<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author Balaji
 * @name A to Z SEO Tools - PHP Script
 * @copyright 2022 ProThemes.Biz
 *
 */
?>

  <div class="container main-container">
	<div class="row">
      	    <?php
            if($themeOptions['general']['sidebar'] == 'left')
                require_once(THEME_DIR."sidebar.php");
            ?>
          	<div class="col-md-8 main-index">
            
            <div class="xd_top_box">
             <?php echo $ads_720x90; ?>
            </div>
            
              	<h2 id="title"><?php echo $data['tool_name']; ?></h2>

               <?php if ($pointOut != 'output') { ?>
               <br />
               <p><?php echo $lang['23']; ?>
               </p>
               <form method="POST" action="<?php echo $toolOutputURL;?>" onsubmit="return fixURL();"> 
               <input type="text" name="url" id="url" value="" class="form-control"/>
               <br />
               <?php if ($toolCap) echo $captchaCode; ?>
               <div class="text-center">
               <input class="btn btn-info" type="submit" value="<?php echo $lang['8']; ?>" name="submit"/>
               </div>
               </form>     
                          
               <?php 
               } else { 
               //Output Block
               if(isset($error)) {
                
                echo '<br/><br/><div class="alert alert-error">
                <strong>Alert!</strong> '.$error.'
                </div><br/><br/>
                <div class="text-center"><a class="btn btn-info" href="'.$toolURL.'">'.$lang['12'].'</a>
                </div><br/>';
                
               } else {
               ?>
        <br />

        <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller">
                        <?php echo $lang['74'].' '.$myHost; ?>?</h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <br />
                            <table class="table table-bordered table-striped">
                                <tbody><tr>
                                    <th style="width: 200px;">#</th>
                                    <th><?php echo $lang['75']; ?></th>
                                </tr>
                                <tr>
                                    <td><strong><?php echo $lang['76']; ?></strong></td>
                                    <td><?php echo $alexa_rank; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo $lang['77']; ?></strong></td>
                                    <td><?php echo $alexa_pop; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo $lang['78']; ?></strong></td>
                                    <td><?php echo $regional_rank; ?></td>
                                </tr>

                            </tbody></table>
                            <br />

                            <br />
                        </div><!-- /.widget-main -->
                    </div><!-- /.widget-body -->
            </div>
            

                                    <br />
   
    
    <div class="text-center">
    <br /> &nbsp; <br />
    <a class="btn btn-info" href="<?php echo $toolURL; ?>"><?php echo $lang['27']; ?></a>
    <br />
    </div>

    <?php } } ?>

        <br />
        
        <div class="xd_top_box">
        <?php echo $ads_720x90; ?>
        </div>
        
        <h2 id="sec1" class="about_tool"><?php echo $lang['11'].' '.$data['tool_name']; ?></h2>
        <p>
        <?php echo $data['about_tool']; ?>
        </p> <br />
        </div>              
            
        <?php
        if($themeOptions['general']['sidebar'] == 'right')
            require_once(THEME_DIR."sidebar.php");
        ?>      		
        </div>
    </div> <br />