<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Supervisor Progress</title>
    <link rel="stylesheet" href="../alert/css/jquery-confirm.css">
    <?php include('head.php'); 
	?>
    
    <style>
    </style>
</head>
    <body>
       <!-- Include Top here-->
    
			<?php include('top.php'); ?>
        <div id="body-container">
            <div id="body-content">
                <!-- Include navigator here-->
                <?php include('nav.php'); ?>
                <!-- Content goes here -->
                           <section class="nav nav-page">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3><i class="icon-user"></i>STUDENT'S WORK PROGRESS
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options">
                    <div class="span9">
                        <ul class="nav nav-pills">
                            <li>
                                <a href="../supervisors"><i class="icon-home icon-large"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page container">
        <div class="row">
                <div class="span4">
                    <div class="blockoff-right">
                        <ul id="person-list" class="nav nav-list">
                            <li class="nav-header">Assigned students</li>
                            <li class="active">
                                <a id="view-all" href="#">
                                    <i class="icon-chevron-right pull-right"></i>
                                    <b>View All</b>
                                </a>
                            	</li>
                            	 <?php 
										$sql =$data->query($data->StudentList($id));$i =0;
										while($row=$data->fetch_array($sql)){$i+=1;
									?>
                                <li>
                                    <a href="#Person-<?php echo $i ?>">
                                        <i class="icon-chevron-right pull-right"></i>
                                        <?php echo $row['studentid'] ?>
                                    </a>
                                </li>
                                <?php }?>
                        </ul>
                    </div>
                </div>
                <div class="span12">
                 <?php 
										$sql =$data->query($data->StudentList($id));$j =0;
										while($row=$data->fetch_array($sql)){$j+=1;
									?>
                    <div id="Person-<?php echo $j ?>" class="box">
                        <div class="box-header">
                            <i class="icon-user icon-large"></i>
                            <h5><?php echo $row['studentid'] ?></h5>
                            
                        </div>
                        <div class="box-content box-table">
                        <table class="table table-hover tablesorter">
                            <thead>
                                <tr>
                                	<th>#</th>
                                    <th>Date Submitted</th>
                                    <th>Work type</th>
                                    <th>View</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $cmd = $data->query("SELECT  *, case when status=1 then 'Approved' when status=2 then 'Rejected' when
							 status=0 then 'pending' end statusname FROM `projectwork` WHERE studid=".$row['id']);$k=0;
							if($data->no_rows($cmd)>0){
								while($tr = $data->fetch_array($cmd)){$k+=1;
							?>
                                <tr>
                                	<td><?php echo $k ?></td>
                                    <td><?php echo date_format(date_create($tr['subdate']),"d F, Y"); ?></td>
                                    <td><?php echo $tr['work']; ?></td>
                                    <td><a href="../students/upload/<?php echo $tr['workfile'] ?>" class="btn btn-info" target="_blank">View</a></td>
                                    <td><span class="label label-warning"><?php echo $tr['statusname']; ?></span></td>
                                    <td>
                                    <?php if($tr['status']==0){?>
                                    <div class="btn-group">
								<button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
									<ul class="dropdown-menu">
									<li><a href="#myAlert<?php echo $tr[0] ?>1" data-toggle="modal">Approve</a>
                                     </li>
									<li><a href="#myAlert<?php echo $tr[0] ?>2" data-toggle="modal">Reject</a></li>
									 </ul>
								</div><!-- /btn-group -->
                                    <?php }?>
                                    </td>
                                    
                                </tr>
                                <div id="myAlert<?php echo $tr[0] ?>1" class="modal hide">
                      <form action="" enctype="multipart/form-data" method="post" id="workResponse<?php echo $tr[0] ?>1"
                                 class="form-horizontal" name="workResponse<?php echo $tr[0] ?>1">
                                 <input name="frmUpload" type="hidden" value="">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>APPROVE <?php echo strtoupper($tr['work']) ?></h3>
											</div>
											<div class="modal-body">
                                                <div class="control-group">
                                                <div class="controls">
                                                <input type="hidden" id="stud_id" value="<?php echo $tr['studid'] ?>" name="studid">
                                                 <input type="hidden" id="id<?php echo $tr[0] ?>1" value="<?php echo $id ?>" name="id">
                                                  <input type="hidden" id="workid" value="<?php echo $tr['id'] ?>" name="workid">
                                                  <input name="uploadType" type="hidden" value="1">
                                                    <textarea name="comment" id="comment<?php echo $tr[0] ?>1" required class="span7"
                                                     placehoder="Place comment here" rows="5" cols="30"></textarea>
                                                </div>
                                                </div>
                                                <div class="control-group">
                                                <label for="workfile" class="control-label">Upload edited work:</label>
                                                <div class="controls">
                                                   <input name="image" type="file" required placeholder="Upload work file">
                                                </div>
                                                </div>
											</div>
											<div class="modal-footer">
												<a class="btn btn-primary" 
                                                href="javascript:void(0)" onClick="ApproveRow('<?php echo $tr[0] ?>1')">
                                                Approve</a>
												<a data-dismiss="modal" class="btn" href="#">Cancel</a>
											</div>
                                            </form>
										</div>
                            <div id="myAlert<?php echo $tr[0] ?>2" class="modal hide">
                      <form action="" enctype="multipart/form-data" method="post" id="workResponse<?php echo $tr[0] ?>2"
                                 class="form-horizontal" name="workResponse<?php echo $tr[0] ?>2">
                                 <input name="frmUpload" type="hidden" value="">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>REJECT <?php echo strtoupper($tr['work']) ?></h3>
											</div>
											<div class="modal-body">
                                                <div class="control-group">
                                                <div class="controls">
                                                <input  type="hidden" id="stud_id" value="<?php echo $tr['studid'] ?>" name="studid">
                                                 <input type="hidden" id="id<?php echo $tr[0] ?>2" value="<?php echo $id ?>" name="id">
                                                  <input type="hidden" id="workid" value="<?php echo $tr['id'] ?>" name="workid">
                                                  <input name="uploadType" type="hidden" value="2">
                                                    <textarea name="comment" id="comment<?php echo $tr[0] ?>2" required class="span7"
                                                     placehoder="Place comment here" rows="5" cols="30"></textarea>
                                                </div>
                                                </div>
                                                <div class="control-group">
                                                <label for="workfile" class="control-label">Upload edited work:</label>
                                                <div class="controls">
                                                   <input name="image" type="file" required placeholder="Upload work file">
                                                </div>
                                                </div>
											</div>
											<div class="modal-footer">
												<a class="btn btn-primary" 
                                                href="javascript:void(0)" onClick="RejectRow('<?php echo $tr[0] ?>2')">
                                                Approve</a>
												<a data-dismiss="modal" class="btn" href="#">Cancel</a>
											</div>
                                            </form>
										</div>
                                
                                <?php }}else{
									?>
                                    <tr>
                                    <td colspan="5">No Project work submitted</td>
                                    
                                	</tr>
                                    <?php
								}  ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                <?php }?>
                   
                
                </div>
            </div>
  </section>  
  </div>
  </div>
  									
        <!-- Include footer here-->
        <?php include('footer.php'); ?>
        <script>
		$(document).ready(function(){
			$('#li-Progress').parent('li').addClass("active");
		});
		$(function() {
            $('#person-list.nav > li > a').click(function(e){
                if($(this).attr('id') == "view-all"){
                    $('div[id*="Person-"]').fadeIn('fast');
                }else{
                    var aRef = $(this);
                    var tablesToHide = $('div[id*="Person-"]:visible').length > 1
                            ? $('div[id*="Person-"]:visible') : $($('#person-list > li[class="active"] > a').attr('href'));

                    tablesToHide.hide();
                    $(aRef.attr('href')).fadeIn('fast');
                }
                $('#person-list > li[class="active"]').removeClass('active');
                $(this).parent().addClass('active');
                e.preventDefault();
            });

            $(function(){
                $('table').tablesorter();
                $("[rel=tooltip]").tooltip();
            });
        });
		function ApproveRow(id){
			var comment = $('#comment'+id).val();
			var supid = $('#id'+id).val();
			if(!comment){
				$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Attention',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Enter comment and contiue'
							 });
							 return false;
			}
			if(!supid){
				$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Error',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'An error occured please try again later'
							 });
							 return false;
			}
			 $.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to prove this work',
                            icon: 'icon-question-sign',
                            animation: 'scale',
                            closeAnimation: 'scale',
							boxWidth: '20%',
   							useBootstrap: false,
                            opacity: 0.5,
							theme: 'supervan',
                            buttons: {
                                'confirm': {
                                    text: '<i class="icon-ok"></i> Yes',
                                    btnClass: 'btn-blue',
									 boxWidth: '30%',
   									 useBootstrap: false,
                                    action: function () {
									$('#workResponse'+id).trigger('submit');
			 						}
                                },
                                cancel:function () {
                                    $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-remove-circle',
									type:'red',
									title:'Cancelled',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Operation <strong>Cancelled</strong>'
									});
                                },
                                
                            }
                        });
		}
                function RejectRow(id){
			var comment = $('#comment'+id).val();
			var supid = $('#id'+id).val();
			if(!comment){
				$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Attention',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Enter comment and contiue'
							 });
							 return false;
			}
			if(!supid){
				$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Error',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'An error occured please try again later'
							 });
							 return false;
			}
			 $.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to reject this work',
                            icon: 'icon-question-sign',
                            animation: 'scale',
                            closeAnimation: 'scale',
							boxWidth: '20%',
   							useBootstrap: false,
                            opacity: 0.5,
							theme: 'supervan',
                            buttons: {
                                'confirm': {
                                    text: '<i class="icon-ok"></i> Yes',
                                    btnClass: 'btn-blue',
									 boxWidth: '30%',
   									 useBootstrap: false,
                                    action: function () {
									$('#workResponse'+id).trigger('submit');
			 						}
                                },
                                cancel:function () {
                                    $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-remove-circle',
									type:'red',
									title:'Cancelled',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Operation <strong>Cancelled</strong>'
									});
                                },
                                
                            }
                        });
		}
		</script>
           <?php 
	   if(isset($_POST['frmUpload'])){
	$id = $_POST['id'];
	$studid = $_POST['studid'];
	$regno=$data->getStudentID($studid);
	$comment = $_POST['comment'];
	$workid = $_POST['workid'];
	$uploadType = $_POST['uploadType'];
	$fileId = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"),0,4);
	if (isset($_FILES)) {
	$msg = array();
	$path ='../students/upload';
	//$userfile_error is size in bytes
	$userfile_error = $_FILES['image']['error'];
	if ($userfile_error > 0){
		switch ($userfile_error){
			case 1: $msg['m']='Image exceeded upload_max_filesize '; break;
			case 2: $msg['m']='Image exceeded 2mb '; break;
			case 3: $msg['m']='Image only partially uploaded'; break;
			case 4: $msg['m']='Please upload choose file to upload'; break;
			}
			?>
            <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Uploading failed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'<?php echo $msg['m'] ?>'
							 });
			</script>
            <?php
		}
	else{
	$str = $regno;
	//$id = inject($_POST['last_id'],'int');
	$Image_name = 're-'.strtolower(str_replace('/','',$str)).$fileId;
	//$userfile where file went on webserver
	$userfile = $_FILES['image']['tmp_name'];
	//$userfile_name is original fie name
	$userfile_name = $_FILES['image']['name'];
	//$userfile_size is size in bytes
	$userfile_size = $_FILES['image']['size'];
	//$userfile_type is mime type
	$userfile_type = $_FILES['image']['type'];
	$extension = explode('.',$userfile_name);
	$exten = $extension[1];
	if (($exten != 'doc') && ($exten != 'docx')){
			$msg['m']='Invalide File type, the document most be doc or docx!';
			?>
            <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Uploading failed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'<?php echo $msg['m'] ?>'
							 });
			</script>
            <?php
			
	}else{
	
		global $newfile_name;
		$newfile_name = $Image_name.'.'.$extension[1];
	//put file in the right directory/* || ($userfile_type != 'image/gif'))*/
		$upfile = $path.'/'.$newfile_name;
		//unlink($upfile);
		if (is_uploaded_file($userfile)){
			if (!move_uploaded_file($userfile, $upfile)){
				$msg['m']= 'Could not upload the image to the destination!';
				?>
            <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Uploading failed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'<?php echo $msg['m'] ?>'
							 });
			</script>
            <?php
			}else{
				if(!$comment){
				?>
            <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Uploading failed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Comment is empty!'
							 });
			</script>
            <?php
			}else{
                   $report =$data->UpdateWork($workid,$studid,$newfile_name,$uploadType,$comment);
                   if($report=='success'){
                       $statusMsg ="";
                       switch ($uploadType){
                           case 1: $statusMsg="Project work approved successfully";break;
                            case 2: $statusMsg="Project work rejected";break;
                       }
                     ?>
             <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-info-sign',
									type:'green',
									title:'Succeed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'<?php echo $statusMsg; ?>'
							 });
                                                         setTimeout(function(){window.location='';},1000);
			</script>
            <?php  
                   }else{
                    ?>
             <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Uploading failed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'An error occurred please try again later'
							 });
			</script>
            <?php   
                   }
				}	
			}
		}
		else {
			$msg['m']='Problem: Possible file upload attack. Filename!'.$userfile_name;
			?>
             <script>
			$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-exclamation-sign',
									type:'red',
									title:'Uploading failed',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'<?php echo $msg['m'] ?>'
							 });
			</script>
            <?php
		}
	}
	}
	}
	
}
	   
	   
	   ?>
	</body>
</html>