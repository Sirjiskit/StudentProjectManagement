<?php require('api.classess.php'); ?>
<?php 
$data = new api_classes();
if(isset($_GET['AddSuppervisor'])){
	$staffid = $_GET['staffid'];
	$firstname = $_GET['firstname'];
	$othernames = $_GET['othernames'];
	$School = $_GET['School'];
	$department = $_GET['department'];
	$Status = $_GET['Status'];
	$result = $data->AddSupervisor($staffid,$firstname,$othernames,$School,$department,$Status);
	die(json_encode($result));
}
if(isset($_GET['AddStudent'])){
	$studentid = $_GET['studentid'];
	$firstname = $_GET['firstname'];
	$othernames = $_GET['othernames'];
	$School = $_GET['School'];
	$department = $_GET['department'];
	$Status = $_GET['Status'];
	$result = $data->AddStudent($studentid,$firstname,$othernames,$School,$department,$Status);
	die(json_encode($result));
}
if(isset($_GET['StudentList'])){
				$start = 0;
				if (isset($_GET['start'])) {
				  $start = $_GET['start'];
				}
				$startRow = intval($start) * 5;
				$query="";
				$allquery1="";
				if(isset($_POST['dpm']) && !empty($_POST['dpm'])){
				$string = $_POST['dpm'];
				$exp = explode(',',$string);
				$dpm = $exp[1];
				$sch = $exp[0];
				if(isset($_GET['txtsearch']) && !empty($_GET['txtsearch'])){
					$query = $data->filter_search_Student($_GET['txtsearch'],$dpm,$sch);
					$allquery1 = $data->Search_Student($_GET['txtsearch'],$dpm,$sch);
				}else{
					$query = $data->filter_Student($startRow,$dpm,$sch);
					$allquery1 =$data->StudentList($dpm,$sch);
				}
				}else{
					if(isset($_GET['txtsearch']) && !empty($_GET['txtsearch'])){
						$query = $data->filter_search_StudentAll($_GET['txtsearch']);
						$allquery1 = $data->Search_StudentAll($_GET['txtsearch']);
					}else{
						$query = $data->filter_StudentAll($startRow);
						$allquery1 =$data->StudentListAll();
					}
				}
				
				 if (isset($_GET['totalRows'])) {
					  $totalRows = $_GET['totalRows'];
					} else {
					  $all = $data->query($allquery1);
					  $totalRows = $data->no_rows($all);
					}
					$sql = $data->query($query);
					$totalPages= ceil($totalRows/5)-1;
					if($data->no_rows($sql)==0){
						?>
    <div class="alert alert-error alert1" >No student found
     <button class="close" onClick="$('.alert1').hide(1000)" style="color:#FFF"><i class="icon-remove"></i></button>
                                </div>
                        <?php
						exit();
						}
					?>
                    <li class="label label-info" style="color:#FFF;">
                         <div class="row">
                             <div class="span2 news-item-title">STUDENT ID</div>
                             <div class="span4 news-item-title">STUDENT NAME</div>
                             <div class="span3 news-item-title">SUPERVISOR</div>
                             <div class="span2 news-item-title">ACTION</div>
                         </div>
                     </li>
                    <?php
				 while($row=$data->fetch_array($sql)){
	?>
     						
                            <li>
                                <div class="row">
                                	<div class="span2 news-item-title"><?php echo $row['studentid'] ?></div>
                                    <div class="span4 news-item-title"><?php echo $row['fullname'] ?></div>
                                    <div class="span3 news-item-title"><?php 
									if($row['isAssigned']==0){
										echo '<span class="label label-warning">Not assign</span>';
									}else{
										echo $data->getSupervisorName($data->Stud_ScheduleDetail($row['id'],4));
									}
									 ?></div>
                                    <div class="span2 news-item-title"><?php 
									if($row['isAssigned']==0){
										echo '<a class="btn btn-primary" onclick="AssignSupervisor('.$row[0].')">Assign</a>';
									}else{
										echo '<a class="btn btn-info" onclick="ReAssignSupervisor('.$row[0].')">Re-assign</a>';
									}
									 ?></div>
                                </div>
                            </li>
                           
    <?php
	}
	?>	<li>
    <ul class="pager">
                        <?php if ($start > 0) { // Show if not first page ?>
        <li class="blue"><a href="javascript:void(0)" name="<?php echo 0 ?>" lang="<?php echo $totalRows ?>" onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-fast-backward" ></i>&nbsp;First</a></li>
        <?php } // Show if not first page ?>
    <?php if ($start > 0) { // Show if not first page ?>
        <li class="blue"><a href="javascript:void(0)" name="<?php echo max(0, $start - 1) ?>" lang="<?php echo $totalRows ?>"   onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-backward"></i>&nbsp;Back</a></li>
      <?php } // Show if not first page ?>
    <?php if ($start < $totalPages) { // Show if not last page ?>
       <li class="blue"> <a href="javascript:void(0)" name="<?php echo min($totalPages, $start + 1) ?>" lang="<?php echo $totalRows?>"  onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-forward"></i>&nbsp;Next</a></li>
      <?php } // Show if not last page ?>
   <?php if ($start < $totalPages) { // Show if not last page ?>
       <li class="blue"> <a href="javascript:void(0)" name="<?php echo $totalPages ?>" lang="<?php echo $totalRows ?>"  onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-fast-forward"></i>&nbsp;Last</a></li>
      <?php } // Show if not last page
?>
                    
                        </ul>
    </li>
    <?php
}
if(isset($_GET['InitiateAssign'])){
	$id = $_GET['InitiateAssign'];
	$list = $data->getStudents($id);
	die(json_encode($list));
}
if(isset($_GET['CBoxSupevisor'])){
	$query ='';
	if(!empty($_POST['dpm'])){
	$string = $_POST['dpm'];
	$exp = explode(',',$string);
	$dpm = $exp[1];
	$sch = $exp[0];
	$query = $data->getsupervisors($sch,$dpm);;
	}else{
		$query = $data->supervisors_list();
	}
	$sql = $data->query($query);
	echo ' <option value="" disabled selected>-- Choose --</option>';
	while($row = $data->fetch_array($sql)){
		echo ' <option value="'.$row['id'].'">'.$row['fullname'].'</option>';
	}
}
if(isset($_GET['assignStudent'])){
	$type = $_GET['type'];
	$id = $_GET['id'];
	$dpm = $_GET['dpm'];
	$sch = $_GET['sch'];
	$sup = $_GET['supevisor'];
	$result = $data->AssignStudent($id,$sch,$dpm,$type,$sup);
	die(json_encode($result));
}
if(isset($_GET['assignAllStudent'])){
	if(empty($_GET['assignAllStudent'])){
		$result = $data->AutomaticAssignAllStudentInAlldpm();
		die(json_encode($result));
		exit();
	}
	$string = $_GET['assignAllStudent'];
	$exp = explode(',',$string);
	$dpm = $exp[1];
	$sch = $exp[0];	
	$result = $data->AutomaticAssignAllStudentInSelecteddpm($sch,$dpm);
	die(json_encode($result));
}
if(isset($_GET['ListOfStudent'])){
				$start = 0;
				if (isset($_GET['start'])) {
				  $start = $_GET['start'];
				}
				$startRow = intval($start) * 10;
				$query="";
				$allquery1="";
				if(isset($_POST['dpm']) && !empty($_POST['dpm'])){
				$string = $_POST['dpm'];
				$exp = explode(',',$string);
				$dpm = $exp[1];
				$sch = $exp[0];
				if(isset($_GET['txtsearch']) && !empty($_GET['txtsearch'])){
					$query = $data->pagefilter_search_Student($_GET['txtsearch'],$dpm,$sch);
					$allquery1 = $data->pageSearch_Student($_GET['txtsearch'],$dpm,$sch);
				}else{
					$query = $data->pagefilter_Student($startRow,$dpm,$sch);
					$allquery1 =$data->pageStudentList($dpm,$sch);
				}
				}else{
					if(isset($_GET['txtsearch']) && !empty($_GET['txtsearch'])){
						$query = $data->pagefilter_search_StudentAll($_GET['txtsearch']);
						$allquery1 = $data->pageSearch_StudentAll($_GET['txtsearch']);
					}else{
						$query = $data->pagefilter_StudentAll($startRow);
						$allquery1 =$data->pageStudentListAll();
					}
				}
				
				 if (isset($_GET['totalRows'])) {
					  $totalRows = $_GET['totalRows'];
					} else {
					  $all = $data->query($allquery1);
					  $totalRows = $data->no_rows($all);
					}
					$sql = $data->query($query);
					$totalPages= ceil($totalRows/10)-1;
					if($data->no_rows($sql)==0){
						?>
    <div class="alert alert-error alert1" >No student found
     <button class="close" onClick="$('.alert1').hide(1000)" style="color:#FFF"><i class="icon-remove"></i></button>
                                </div>
                        <?php
						exit();
						}
					?>
                    <li class="label label-info" style="color:#FFF;">
                         <div class="row">
                             <div class="span2 news-item-title">STUDENT ID</div>
                             <div class="span3 news-item-title">SCHOOL</div>
                             <div class="span2 news-item-title">DEPARTMENT</div>
                             <div class="span3 news-item-title">SUPERVISOR</div>
                             <div class="span5 news-item-title">APPROVED PROJECT TOPIC</div>
                         </div>
                     </li>
                    <?php
				 while($row=$data->fetch_array($sql)){
	?>
     						
                            <li>
                                <div class="row">
                                	<div class="span2 news-item-title"><?php echo $row['studentid'] ?></div>
                                    <div class="span3 news-item-title"><?php echo $data->SchoolName($row['school']) ?></div>
                              <div class="span2 news-item-title"><?php echo $data->DpmName($row['department'],$row['school']) ?></div>
                                    <div class="span3 news-item-title"><?php 
									if($row['isAssigned']==0){
										echo '<span class="label label-warning">Not assign</span>';
									}else{
										echo $data->getSupervisorName($data->Stud_ScheduleDetail($row['id'],4));
									}
									 ?></div>
                                    <div class="span5 news-item-title"><?php 
										echo $data->getApprovedTopic($row['id']);
									 ?></div>
                                </div>
                            </li>
                           
    <?php
	}
	?>	<li>
    <ul class="pager">
                        <?php if ($start > 0) { // Show if not first page ?>
        <li class="blue"><a href="javascript:void(0)" name="<?php echo 0 ?>" lang="<?php echo $totalRows ?>" onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-fast-backward" ></i>&nbsp;First</a></li>
        <?php } // Show if not first page ?>
    <?php if ($start > 0) { // Show if not first page ?>
        <li class="blue"><a href="javascript:void(0)" name="<?php echo max(0, $start - 1) ?>" lang="<?php echo $totalRows ?>"   onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-backward"></i>&nbsp;Back</a></li>
      <?php } // Show if not first page ?>
    <?php if ($start < $totalPages) { // Show if not last page ?>
       <li class="blue"> <a href="javascript:void(0)" name="<?php echo min($totalPages, $start + 1) ?>" lang="<?php echo $totalRows?>"  onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-forward"></i>&nbsp;Next</a></li>
      <?php } // Show if not last page ?>
   <?php if ($start < $totalPages) { // Show if not last page ?>
       <li class="blue"> <a href="javascript:void(0)" name="<?php echo $totalPages ?>" lang="<?php echo $totalRows ?>"  onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-fast-forward"></i>&nbsp;Last</a></li>
      <?php } // Show if not last page
?>
                    
                        </ul>
    </li>
    <?php
}
if(isset($_GET['ListOfSupervisors'])){
				$start = 0;
				if (isset($_GET['start'])) {
				  $start = $_GET['start'];
				}
				$startRow = intval($start) * 10;
				$query="";
				$allquery1="";
				if(isset($_POST['dpm']) && !empty($_POST['dpm'])){
				$string = $_POST['dpm'];
				$exp = explode(',',$string);
				$dpm = $exp[1];
				$sch = $exp[0];
				if(isset($_GET['txtsearch']) && !empty($_GET['txtsearch'])){
					$query = $data->pagefilter_search_Supervisor($_GET['txtsearch'],$dpm,$sch);
					$allquery1 = $data->pageSearch_Supervisor($_GET['txtsearch'],$dpm,$sch);
				}else{
					$query = $data->pagefilter_Supervisor($startRow,$dpm,$sch);
					$allquery1 =$data->pageSupervisorList($dpm,$sch);
				}
				}else{
					if(isset($_GET['txtsearch']) && !empty($_GET['txtsearch'])){
						$query = $data->pagefilter_search_SupervisorAll($_GET['txtsearch']);
						$allquery1 = $data->pageSearch_SupervisorAll($_GET['txtsearch']);
					}else{
						$query = $data->pagefilter_SupervisorAll($startRow);
						$allquery1 =$data->pageSupervisorListAll();
					}
				}
				
				 if (isset($_GET['totalRows'])) {
					  $totalRows = $_GET['totalRows'];
					} else {
					  $all = $data->query($allquery1);
					  $totalRows = $data->no_rows($all);
					}
					$sql = $data->query($query);
					$totalPages= ceil($totalRows/10)-1;
					if($data->no_rows($sql)==0){
						?>
    <div class="alert alert-error alert1" >No Supervisor found
     <button class="close" onClick="$('.alert1').hide(1000)" style="color:#FFF"><i class="icon-remove"></i></button>
                                </div>
                        <?php
						exit();
						}
					?>
                    <li class="label label-info" style="color:#FFF;">
                         <div class="row">
                             <div class="span2 news-item-title">SUPERVISOR'S. ID</div>
                              <div class="span3 news-item-title">SUPERVISOR'S NAME</div>
                             <div class="span3 news-item-title">SCHOOL</div>
                             <div class="span3 news-item-title">DEPARTMENT</div>
                             <div class="span2 news-item-title">NO. OF STUDENTS</div>
                              <div class="span2 news-item-title">STATUS</div>
                         </div>
                     </li>
                    <?php
				 while($row=$data->fetch_array($sql)){
	?>
     						
                            <li>
                                <div class="row">
                                	<div class="span2 news-item-title"><?php echo $row['staffid'] ?></div>
                                    <div class="span3 news-item-title"><?php echo $row['fullname'] ?></div>
                                    <div class="span3 news-item-title"><?php echo $data->SchoolName($row['school']) ?></div>
                             		 <div class="span3 news-item-title"><?php echo $data->DpmName($row['department'],$row['school']) ?></div>
                                    
                                    <div class="span2 news-item-title"><?php 
										echo $data->getSupAssignedStudents($row['id']);
									 ?></div>
                                     <div class="span2 news-item-title"><?php echo $data->supStatus($row['status']) ?></div>
                                </div>
                            </li>
                           
    <?php
	}
	?>	<li>
    <ul class="pager">
                        <?php if ($start > 0) { // Show if not first page ?>
        <li class="blue"><a href="javascript:void(0)" name="<?php echo 0 ?>" lang="<?php echo $totalRows ?>" onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-fast-backward" ></i>&nbsp;First</a></li>
        <?php } // Show if not first page ?>
    <?php if ($start > 0) { // Show if not first page ?>
        <li class="blue"><a href="javascript:void(0)" name="<?php echo max(0, $start - 1) ?>" lang="<?php echo $totalRows ?>"   onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-backward"></i>&nbsp;Back</a></li>
      <?php } // Show if not first page ?>
    <?php if ($start < $totalPages) { // Show if not last page ?>
       <li class="blue"> <a href="javascript:void(0)" name="<?php echo min($totalPages, $start + 1) ?>" lang="<?php echo $totalRows?>"  onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-forward"></i>&nbsp;Next</a></li>
      <?php } // Show if not last page ?>
   <?php if ($start < $totalPages) { // Show if not last page ?>
       <li class="blue"> <a href="javascript:void(0)" name="<?php echo $totalPages ?>" lang="<?php echo $totalRows ?>"  onclick="return paggingcontrol(this.name,this.lang);"><i class="icon-fast-forward"></i>&nbsp;Last</a></li>
      <?php } // Show if not last page
?>
                    
                        </ul>
    </li>
    <?php
}
if(isset($_GET['Login'])){
			$name = $_POST['username'];
			$password = $_POST['password'];
			$report = $data->AdminLogin($name,$password);
			die(json_encode($report));
			exit;
}
?>