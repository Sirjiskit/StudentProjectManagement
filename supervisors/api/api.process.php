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
	when status = 2 then 'Reject' end statusname FROM `topic` WHERE stuid=$id  ORDER BY id DESC LIMIT 0,10");$i=0;
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
	$stuid = $data->getStaffID($id);
	$sql = $data->query("SELECT *, case when sender='$stuid' then 'Me' when receiverid=$id then sender end statusname
	 FROM inbox  WHERE (type=1 and receiverid=$id) OR (type =2 and sender='$stuid') ORDER BY id DESC LIMIT 0,10");$i=0;
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
	$rev = $_GET['rev'];
	$message = $_GET['message'];
	$sender = $data->getStaffID($id);
	$type =2;
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
if(isset($_GET['retructure'])){
	$id = $_GET['id'];
	$topic = $_GET['topic'];
	$stud_id = $_GET['stud_id'];
	$result = $data->reStructure($stud_id,$id,$topic);
	die(json_encode($result));
}
if(isset($_GET['approveRow'])){
	$status =1;
	$id = $_GET['id'];
	$stud_id = $_GET['stud_id'];
	$result = $data->UpdateTopic($stud_id,$id,$status);
	die(json_encode($result));
}
if(isset($_GET['rejectRow'])){
	$status =2;
	$id = $_GET['id'];
	$stud_id = $_GET['stud_id'];
	$result = $data->UpdateTopic($stud_id,$id,$status);
	die(json_encode($result));
}
if(isset($_GET['Login'])){
			$name = $_POST['firstname'];
			$password = $_POST['password'];
			$report = $data->SupervisorLogin($name,$password);
			die(json_encode($report));
			exit;
}
?>