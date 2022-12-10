<?php

defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
* @author Balaji
* @name: Rainbow PHP Framework
* @copyright © 2017 ProThemes.Biz
*
*/
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>  
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php adminLink(); ?>"><i class="<?php getAdminMenuIcon($controller,$menuBarLinks); ?>"></i> Admin</a></li>
        <li class="active"><a href="<?php adminLink($controller); ?>"><?php echo $pageTitle; ?></a> </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
            
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Install Addons</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                 <?php if(isset($msg)) echo $msg. '<br>'; ?>
                
                <table class="table table-hover">
                <tbody><tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
                <?php
                $loopC = 1;
                foreach($minMsg as $msg){
                  echo '
                  <tr>
                    <td>'.$loopC.'</td>
                    <td>'.$msg[0].'</td>
                    <td>'.$msg[1].'</td>
                  ';  
                  $loopC++;
                } 
                ?>
                 </tbody></table>

                <?php if($manualInstall) { ?>
                    <hr />
                    <div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th colspan="3" class="text-center">Manually Uploaded Files</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Filename</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; foreach($manualInstallFiles as $file){
                                echo '<tr id="myid_'.$i.'"><td>'.$i.'</td><td>'.$file.'</td><td><form method="POST" action="'.adminLink('process-addon',true).'"><input value="'.$file.'" type="hidden" name="addon"><button type="submit" class="btn btn-success btn-xs"> <i class="fa fa-cog"></i> &nbsp; Install</button>
                        <a href="'.adminLink($controller.'/delete/'.str_replace(array('.addonpk','.zip','.zipx'), '', $file),true).'" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i> &nbsp; Delete</a></form>
                        </td></tr>';
                                $i++;
                            } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

                                        
                <hr />
                <form action="#" method="POST" enctype="multipart/form-data">

                <br />
                <div class="form-group">											
					<label for="addonID">Select a addon package:</label>
					<div class="controls">			   
                 <input type="file" name="addonUpload" id="addonUpload" class="btn btn-default" />
                 <input type="hidden" name="addonID" id="addonID" value="1" /> <br />
                 <?php if($minError){ ?>
                 <input type="submit" value="Upload" name="submit" class="btn btn-primary" disabled="" />
                 <?php } else { ?>
                 <input type="submit" value="Upload" name="submit" class="btn btn-primary" />
                 <?php } ?>
                  </div> <!-- /controls -->	

				</div> <!-- /control-group -->
                </form>
                
                <div class="row">
                <div class="col-md-6">
                <br />
                <div class="callout callout-danger">
                    <h4>Note!</h4>
                    <p>1) Don't upload unknown addons and make sure it is downloaded from authorized websites.</p>
                    <p>2) Unauthorized addons may crash the website and we weren't responsible for that.</p>
                    <p>3) Make sure the PHP upload limit is greater than file size.</p>
                    <p>4) Upload only "<b>addonpk</b>" file format. You have ZIP package file then extract and find "addonpk" file.</p>
                  </div>
                </div>
                </div>

                </div><!-- /.box-body -->
      
              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->