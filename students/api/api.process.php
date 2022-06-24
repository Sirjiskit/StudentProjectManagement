<?php require('api.classess.php'); ?>
<?php 
$data = new api_classes();
if(isset($_GET['removeNotify'])){
	$id = $_GET['removeNotify'];
	$data->Notification($id);
}
if(isset($_GET['TopicList'])){
	$id = intval($_GET['TopicList']);
	$sql = $data->query("SELECT *, case when status=1 then 'Approved' when status=0 then 'Not Approved' 
	when status = 2 then 'Reject' end statusname FROM `topic` WHERE stuid=$id");$i=0;
	if($data->no_rows($sql)==0){
	?>
    <li>
    <div class="alert alert-error">Have not submitted topic yet</div>
    </li> 
     <?php
						}
						while($row=$data->fetch_array($sql)){$i+=1;
						?>
                            <li class="row">
                               <span class="span9"><?php echo $i.'&nbsp;&nbsp;'.$row['topic'] ?></span>
                               <span class="span1"><span class="label label-info"><?php echo $row['statusname'] ?></span></span>
                            </li>
                            <?php }
}
if(isset($_GET['MessageList'])){
	$id = intval($_GET['MessageList']);
	$stuid = $data->getStudentID($id);
	$sql = $data->query("SELECT *, case when sender='$stuid' then 'Me' when receiverid=$id then 'My supervisor' end statusname
	 FROM inbox  WHERE (type=2 and receiverid=$id) OR (type =1 and sender='$stuid') ORDER BY id DESC LIMIT 0,10");$i=0;
	if($data->no_rows($sql)==0){
	?>
    <li>
    <div class="alert alert-error">No message</div>
    </li> 
     <?php
						}
						while($row=$data->fetch_array($sql)){$i+=1;
						?>
                           <li>
                                <div>
                                <button class="close" onClick="closeNoties(<?php echo $row['id'] ?>,this)">&times;</button>
                                    <a href="#" class="news-item-title"><?php echo $row['statusname'] ?></a>
                                    <p class="news-item-preview"><?php echo $row['message'] ?></p>
                                  <p class="news-item-preview"><span class="label label-warning"><?php echo $row['date'];?></span></p>
                                </div>
                            </li>
                            <?php }
}
if(isset($_GET['AddTopic'])){
	$id = $_GET['id'];
	$topic = $_GET['topic'];
	$result = $data->submitTopic($id,$topic);
	die(json_encode($result));
}
if(isset($_GET['SendMessage'])){
	$id = $_GET['id'];
	$rev = $data->getSupAssignedStudents($id);
	$message = $_GET['message'];
	$sender = $data->getStudentID($id);
	$type =1;
	$msg=array();
	if(intval($rev)=='' || intval($rev==0) || !is_numeric($rev)){
			$msg['s']=2;
			$msg['m']="No supervisor assigned to you! ";
			$msg['t']='Success';
			$msg['ico']='icon-exclamation-sign';
			$msg['tp']='red';
			die(json_encode($msg));
			exit();
	}
	$result = $data->Send_Message($type,$id,$sender,$message,$rev);
	die(json_encode($result));	
}
if(isset($_GET['WorkProgress'])){
					$id = $_GET['WorkProgress'];
					$sql = $data->query("SELECT *, case when status=1 then 'Approved' when status=2 then 'Reject' when status=0 then 
					'pending' end statusname FROM `projectwork` WHERE studid=$id");
					if($data->no_rows($sql)==0){
										?><li class="row">
                                        <div class="span12">
					<div class="alert alert-error alert1" >No work progress found
					 <button class="close" onClick="$('.alert1').hide(1000)" style="color:#FFF"><i class="icon-remove"></i></button>
												</div></div></li>
										<?php
						exit();
						}
					?>
                    <li class="label label-info" style="color:#FFF;">
                         <div class="row">
                         	<div class="span2 news-item-title">DATE SUBMITTED</div>
                             <div class="span2 news-item-title">WORK TYPE</div>
                             <div class="span4 news-item-title">COMMENT</div>
                             <div class="span2 news-item-title">STATUS</div>
                             <div class="span1 news-item-title">ACTION</div>
                         </div>
                     </li>
                    <?php
				 while($row=$data->fetch_array($sql)){
	?>
     						
                            <li>
                                <div class="row">
                                <div class="span2 news-item-title"><?php echo date_format(date_create($row['subdate']),"d F, Y")?>
                                </div>
                                	<div class="span2 news-item-title"><?php echo $row['work'] ?></div>
                                    <div class="span4 news-item-title"><?php echo $row['comment'] ?></div>
                                    <div class="span2 news-item-title"><?php echo $row['statusname'];?></div>
                                    <div class="span1 news-item-title"><?php 
									if($row['status']>0){
										?>
                                        <a href="upload/<?php echo $row['reworkfile'] ?>" class="btn btn-info" target="_blank">View</a>
                                        <?php
									}
									 ?></div>
                                </div>
                            </li>
                           
    <?php
	}
}
if(isset($_GET['frmUploadWork'])){
	$id = $_POST['id'];
	$stuid = $data->getStudentID($id);
	$supid = $data->getSupAssignedStudents($id);
	$work = $_POST['work'];
	$fileId = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"),0,4);
	$Filedata='';
	if (isset($_FILES)) {
	$msg = array();
	$path ='../upload';
	//$userfile_error is size in bytes
	$userfile_error = $_FILES['image']['error'];
	if ($userfile_error > 0){
		$msg['s']=2;
		switch ($userfile_error){
			case 1: $msg['m']='Image exceeded upload_max_filesize '; break;
			case 2: $msg['m']='Image exceeded 2mb '; break;
			case 3: $msg['m']='Image only partially uploaded'; break;
			case 4: $error="null"; break;
			}
		}
	
	$str = $stuid;
	//$id = inject($_POST['last_id'],'int');
	$Image_name = strtolower(str_replace('/','',$str)).$fileId;
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
			$msg['s']=2;
			$msg['m']='Invalide File type, the document most be doc or docx!';
			die(json_encode($msg));
			exit;
	}
	
		global $newfile_name;
		$newfile_name = $Image_name.'.'.$extension[1];
	//put file in the right directory/* || ($userfile_type != 'image/gif'))*/
		$upfile = $path.'/'.$newfile_name;
		//unlink($upfile);
		if (is_uploaded_file($userfile)){
			if (!move_uploaded_file($userfile, $upfile)){
				$msg['s']=2;
				$msg['m']= 'Could not upload the image to the destination!';
				die(json_encode($msg));
				exit;
			}
			$Filedata=$newfile_name;
		}
		else {
			$msg['s']=2;
			$msg['m']='Problem: Possible file upload attack. Filename!'.$userfile_name;
			die(json_encode($msg));
			exit;
		}
		$resul = $data->uploadwork($id,$work,$Filedata,$supid);
		die(json_encode($resul));
		exit;
	}
	
}
if(isset($_GET['Login'])){
			$name = $_POST['firstname'];
			$password = $_POST['password'];
			$report = $data->StudentLogin($name,$password);
			die(json_encode($report));
			exit;
}
?>