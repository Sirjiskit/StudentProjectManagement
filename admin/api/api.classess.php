<?php

//mysqli_select_db('proj_2019_pms',mysqli_connect('localhost','root',''))or die(mysqli_error($con));
$con = mysqli_connect("localhost", "root", "", "proj_2019_pms") or die(mysqli_error($con));

class api_classes {
    public $sqlErr;
    public $conn = null;
    public function __construct(){
       $this->conn = mysqli_connect("localhost", "root", "", "proj_2019_pms");
    }

    function Error() {
        return $this->Error();
    }

    function query($string) {
        $result = mysqli_query($this->conn, $string) or $this->sqlErr = mysqli_error($this->conn);
        return $result;
    }

    function fetch_array($result) {
        return $list = mysqli_fetch_array($result);
    }

    function fetch_assoc($result) {
        return mysqli_fetch_assoc($result);
    }

    function no_rows($result) {
        return mysqli_num_rows($result);
    }

    function insert_id() {
        return mysqli_insert_id($this->conn);
    }

    function AddSupervisor($id, $fn, $on, $sch, $dpm, $st) {
        $msg = array();
        $chk = $this->query("SELECT * FROM `tb_supervisor` WHERE staffid='$id'");
        if ($this->no_rows($chk) > 0) {
            $msg['s'] = 2;
            $msg['m'] = "Staff ID already exists!";
            $msg['t'] = 'Attention';
            $msg['ico'] = 'icon-exclamation-sign';
            $msg['tp'] = 'orange';
            return $msg;
            exit();
        }
        if ($st == 1) {
            $chk1 = $this->query("SELECT * FROM `tb_supervisor` WHERE department=$dpm and status=1");
            if ($this->no_rows($chk1) > 0) {
                $msg['s'] = 2;
                $msg['m'] = "Another staff have already been choosen as Project coordinator!";
                $msg['t'] = 'Attention';
                $msg['ico'] = 'icon-exclamation-sign';
                $msg['tp'] = 'orange';
                return $msg;
                exit();
            }
        }
        $sql = $this->query("INSERT INTO `tb_supervisor`(`staffid`, `firstname`, `othernames`, `school`, `department`, `status`)
		 VALUES ('$id','$fn','$on',$sch,$dpm,$st)");
        $id = $this->insert_id();
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later!";
            $msg['t'] = 'Error';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        } $this->Post_Notification(1, "System Admin", $id, "Welcome to Student project management and allocation system");
        $msg['s'] = 1;
        $msg['m'] = "Supervisor successfully added!";
        $msg['t'] = 'Success';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

    function AddStudent($id, $fn, $on, $sch, $dpm, $st) {
        $msg = array();
        $chk = $this->query("SELECT * FROM `tb_students` WHERE studentid='$id'");
        if ($this->no_rows($chk) > 0) {
            $msg['s'] = 2;
            $msg['m'] = "Student ID already exists!";
            $msg['t'] = 'Attention';
            $msg['ico'] = 'icon-exclamation-sign';
            $msg['tp'] = 'orange';
            return $msg;
            exit();
        }
        $sql = $this->query("INSERT INTO `tb_students`(`studentid`, `firstname`, `othernames`, `school`, `department`, `status`)
		 VALUES ('$id','$fn','$on',$sch,$dpm,$st)");
        $id = $this->insert_id();
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later!";
            $msg['t'] = 'Error';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        } $this->Post_Notification(2, "System Admin", $id, "Welcome to Student project management and allocation system");
        $msg['s'] = 1;
        $msg['m'] = "Student successfully added!";
        $msg['t'] = 'Success';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

    function AssignStudent($id, $sch, $dpm, $type, $sup) {
        $msg = array();
        $query = "";
        $data = "";
        if ($type == 'Assign') {
            $query = "INSERT INTO `tb_schedulled`(`schid`, `dpmid`, `studid`, `supid`) VALUES($sch,$dpm,$id,$sup)";
            $msg['m'] = "Student successfully assigned!";
            $data = 'This is to notify you that you have been assign to ' . $this->getSupervisorName($sup);
            $data1 = 'This is to notify you that ' . $this->getStudentID($id) . ' have been assign to you';
        } else {
            $query = "UPDATE `tb_schedulled` SET `schid`=$sch,`dpmid`=$dpm,`supid`=$sup WHERE `studid`=$id";
            $data = 'This is to notify you that you have been re-assign to ' . $this->getSupervisorName($sup);
            $data1 = 'This is to notify you that ' . $this->getStudentID($id) . ' have been re-assign to you';
            $msg['m'] = "Student successfully re-assigned!";
        }
        $sql = $this->query($query);
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later!" . $this->sqlErr;
            $msg['t'] = 'Error';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        } $this->query("update tb_students set isAssigned =1 WHERE id=$id");
        $this->Post_Notification(2, "System Admin", $id, $data);
        $this->Post_Notification(1, "System Admin", $sup, $data1);
        $msg['s'] = 1;
        $msg['t'] = 'Success';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

    /*
      The following block of code is an attempt to automatically assigned all students in all departments

     */

    function AutomaticAssignAllStudentInAlldpm() {
        $all_list = $this->query("select * from tb_students s,tb_supervisor p where s.department=p.department  and s.school=p.school
		 and isAssigned=0");
        $report = '<ol>';
        if ($this->no_rows($all_list) == 0) {
            $report .= '<li>No supervisor found in some department or all students are been assigned';
        }
        while ($row = $this->fetch_array($all_list)) {
            $Stud_list1 = $this->query("select * from tb_students where `department`=" . $row['department'] . " and 
			`school`=" . $row['school'] . " and isAssigned=0  GROUP BY school,department");
            $totalStud = $this->no_rows($Stud_list1);

            $supervisor = $this->query("select * from tb_supervisor where `department`=" . $row['department'] . " and 
			`school`=" . $row['school']);
            $end = $this->no_rows($supervisor);
            $divider = ceil($totalStud / $end);
            $start = 0;
            if ($totalStud > 0) {
                for ($i = 0; $i < $divider; $i++) {
                    $start = $i * $divider;
                    $sql1 = $this->query("select * from tb_students where `department`=" . $row['department'] . " and 
						`school`=" . $row['school'] . " and isAssigned=0 LIMIT $start,$divider");
                    $sql2 = $this->query("select * from tb_supervisor where `department`=" . $row['department'] . " and 
						`school`=" . $row['school'] . " LIMIT $i,1");
                    $dd = $this->fetch_array($sql2);
                    $sup_id = $dd['id'];
                    $sup_name = $dd['firstname'] . ' ' . $dd['firstname'];
                    while ($td = $this->fetch_array($sql1)) {
                        $dpm_id = $td['department'];
                        $sch_id = $td['school'];
                        $stu_id = $td['id'];
                        $stu_name = $td['studentid'];
                        $query = "INSERT INTO `tb_schedulled`(`schid`, `dpmid`, `studid`, `supid`) VALUES($sch_id,$dpm_id,$stu_id,$sup_id)";
                        $data = 'This is to notify you that you have been assign to ' . $sup_name;
                        $data1 = 'This is to notify you that ' . $stu_name . ' have been assign to you';
                        $cmd = $this->query($query);
                        if ($cmd) {
                            $this->query("update tb_students set isAssigned =1 WHERE id=$stu_id");
                            $this->Post_Notification(2, "System Admin", $stu_id, $data);
                            $this->Post_Notification(1, "System Admin", $sup_id, $data1);
                            $report .= '<li>' . $stu_name . ' successfully assigned';
                        }
                    }
                }
            }
        }
        $msg['s'] = 1;
        $msg['m'] = $report;
        $msg['t'] = 'Response';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
        //Here the result
    }

    function AutomaticAssignAllStudentInSelecteddpm($ssch, $sdpm) {
        $all_list = $this->query("select * from tb_students s,tb_supervisor p where s.department=p.department and s.isAssigned=0 and 
		s.school=p.school and (s.school=$ssch and s.department=$sdpm) GROUP BY s.school,s.department");
        $report = '<ol>';
        if ($this->no_rows($all_list) == 0) {
            $report .= '<li>No supervisor found in ' . $this->DpmName($sdpm, $ssch) . ' department';
        }
        while ($row = $this->fetch_array($all_list)) {
            $Stud_list = $this->query("select * from tb_students where `department`=" . $row['department'] . " and 
			`school`=" . $row['school'] . " and isAssigned=0");
            $totalStud = $this->no_rows($Stud_list);

            $supervisor = $this->query("select * from tb_supervisor where `department`=" . $row['department'] . " and 
			`school`=" . $row['school']);
            $end = $this->no_rows($supervisor);
            $divider = ceil($totalStud / $end);
            $start = 0;
            $stmt = array();
            if ($totalStud > 0) {
                for ($i = 0; $i < $divider; $i++) {
                    $start = $i * $divider;
                    $sql1 = $this->query("select * from tb_students where `department`=" . $row['department'] . " and 
						`school`=" . $row['school'] . " and isAssigned=0 LIMIT $start,$divider");
                    $sql2 = $this->query("select * from tb_supervisor where `department`=" . $row['department'] . " and 
						`school`=" . $row['school'] . " LIMIT $i,1");
                    $dd = $this->fetch_array($sql2);
                    $sup_id = $dd['id'];
                    $sup_name = $dd['firstname'] . ' ' . $dd['firstname'];
                    $dpm_id = 0;
                    $sch_id = 0;
                    $stu_id = 0;
                    $stu_name = '';
                    while ($td = $this->fetch_array($sql1)) {
                        $dpm_id = $td['department'];
                        $sch_id = $td['school'];
                        $stu_id = $td['id'];
                        $stu_name = $td['studentid'];
                        $this->query("INSERT INTO `tb_schedulled`(`schid`, `dpmid`, `studid`, `supid`) 
							VALUES($sch_id,$dpm_id,$stu_id,$sup_id)");
                        $data = 'This is to notify you that you have been assign to ' . $sup_name;
                        $data1 = 'This is to notify you that ' . $stu_name . ' have been assign to you';
                        $this->query("update tb_students set isAssigned =1 WHERE id=$stu_id");
                        $this->Post_Notification(2, "System Admin", $stu_id, $data);
                        $this->Post_Notification(1, "System Admin", $sup_id, $data1);
                        $report .= "<li>" . $stu_name . " successfully assigned";
                    }
                }
            }
        }

        $msg['s'] = 1;
        $msg['m'] = $report;
        $msg['t'] = 'Response';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
        //Here the result
    }

    //End of the attempts
    function StudentList($dpm, $sch) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE `department`=$dpm and `school`=$sch";
    }

    function filter_Student($start, $dpm, $sch) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE `department`=$dpm and `school`=$sch LIMIT $start,5";
    }

    function filter_search_Student($txtSearch, $dpm, $sch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') AND `department`=$dpm and `school`=$sch LIMIT 0,5";
    }

    function Search_Student($txtSearch, $dpm, $sch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') 
		  AND `department`=$dpm and `school`=$sch";
    }

    //All
    function StudentListAll() {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students`";
    }

    function filter_StudentAll($start) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` LIMIT $start,5";
    }

    function filter_search_StudentAll($txtSearch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') LIMIT 0,5";
    }

    function Search_StudentAll($txtSearch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%')";
    }

    function supervisors_list() {
        return "SELECT *, CONCAT(firstname,' ',othernames) fullname FROM tb_supervisor";
    }

    function Stud_ScheduleDetail($str, $no) {
        $sql = $this->query("SELECT * FROM `tb_schedulled` WHERE studid=$str");
        $row = $this->fetch_array($sql);
        return $row[$no];
    }

    function getSupervisorName($supid) {
        $sql = $this->query("SELECT CONCAT(firstname,' ',othernames) fullname FROM `tb_supervisor` WHERE id=$supid");
        $row = $this->fetch_array($sql);
        return $row['fullname'];
    }

    function getStudentID($stuid) {
        $sql = $this->query("SELECT studentid FROM `tb_students` WHERE id=$stuid");
        $row = $this->fetch_array($sql);
        return $row['studentid'];
    }

    function Post_Notification($type, $sn, $rv, $da) {
        $sql = $this->query("INSERT INTO `notifications`(`data`, `sender`, `receiverid`,type) VALUES ('$da','$sn',$rv,$type)");
        return $sql;
    }

    function SchoolName($str) {
        $name = '';
        switch ($str) {
            case 1:$name = 'Science and Technology';
                break;
            case 2:$name = 'Management and Technology';
                break;
            case 3:$name = 'Agriculture and Technology';
                break;
        }
        return $name;
    }

    function getsupervisors($sch, $dpm) {
        return "SELECT *, CONCAT(firstname,' ',othernames) fullname FROM tb_supervisor WHERE school=$sch and department=$dpm";
    }

    function getStudents($id) {
        $sql = $this->query("SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, 
		`status`, `isAssigned` FROM `tb_students` WHERE id=" . intval($id));
        $list = $this->fetch_array($sql);
        return $list;
    }

    function DpmName($dpm, $sch) {
        $name = '';
        $school = array();
        $school[1][1] = "Computer Science";
        $school[1][2] = "Science Lab. Tech.";
        $school[1][3] = "Statistics";
        $school[2][1] = "Accounting";
        $school[2][2] = "Office Tech. and management";
        $school[3][1] = "Agricultural Technology";
        return $school[$sch][$dpm];
    }

    function getApprovedTopic($id) {
        $sql = $this->query("SELECT `topic`, `status` FROM `topic` WHERE `stuid`=$id and status=1");
        if ($this->no_rows($sql) == 0) {
            return '<span class="label label-warning">Not Approved</span>';
        } else {
            $row = $this->fetch_array($sql);
            return $row['topic'];
        }
    }

    //Student List
    function pageStudentList($dpm, $sch) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE `department`=$dpm and `school`=$sch";
    }

    function pagefilter_Student($start, $dpm, $sch) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE `department`=$dpm and `school`=$sch LIMIT $start,10";
    }

    function pagefilter_search_Student($txtSearch, $dpm, $sch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') AND `department`=$dpm and `school`=$sch LIMIT 0,10";
    }

    function pageSearch_Student($txtSearch, $dpm, $sch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') 
		  AND `department`=$dpm and `school`=$sch";
    }

    //All
    function pageStudentListAll() {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students`";
    }

    function pagefilter_StudentAll($start) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` LIMIT $start,10";
    }

    function pagefilter_search_StudentAll($txtSearch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') LIMIT 0,10";
    }

    function pageSearch_StudentAll($txtSearch) {
        return "SELECT `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%')";
    }

    //Supervisor List
    function pageSupervisorList($dpm, $sch) {
        return "select `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		 FROM `tb_supervisor` WHERE `department`=$dpm and `school`=$sch";
    }

    function pagefilter_Supervisor($start, $dpm, $sch) {
        return "select `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor` WHERE `department`=$dpm and `school`=$sch LIMIT $start,10";
    }

    function pagefilter_search_Supervisor($txtSearch, $dpm, $sch) {
        return "SELECT `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') AND `department`=$dpm and `school`=$sch LIMIT 0,10";
    }

    function pageSearch_Supervisor($txtSearch, $dpm, $sch) {
        return "SELECT `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') 
		  AND `department`=$dpm and `school`=$sch";
    }

    //All
    function pageSupervisorListAll() {
        return "select `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor`";
    }

    function pagefilter_SupervisorAll($start) {
        return "select `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor` LIMIT $start,10";
    }

    function pagefilter_search_SupervisorAll($txtSearch) {
        return "SELECT `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%') LIMIT 0,10";
    }

    function pageSearch_SupervisorAll($txtSearch) {
        return "SELECT `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status` 
		 FROM `tb_supervisor` WHERE (firstname LIKE '%$txtSearch%' OR othernames LIKE '%$txtSearch%' OR studentid LIKE 
		 '%$txtSearch%')";
    }

    function getSupAssignedStudents($id) {
        $sql = $this->query("SELECT * FROM `tb_schedulled` where supid=$id");
        if ($this->no_rows($sql) > 0) {
            return $this->no_rows($sql);
        } else {
            return '<span class="label label-warning">Not Assign</span>';
        }
    }

    function supStatus($id) {
        switch ($id) {
            case 1:return 'Coordinator';
                break;
            case 2:return 'Supervisor';
                break;
        }
    }

    function topicStatus($id) {
        switch ($id) {
            case 0: return '<span class="label label-warning">Pending</span>';
                break;
            case 1: return '<span class="label label-info">Approved</span>';
                break;
            case 2: return '<span class="label label-danger">Reject</span>';
                break;
        }
    }

    function reStructure($stuid, $id, $topic) {
        $chk = $this->query("select id from topic WHERE stuid=$stuid and status=1");
        $msg = array();
        $query = "";
        if ($this->no_rows($chk) > 0) {
            $row = $this->fetch_assoc($chk);
            if ($row['id'] = $id) {
                $msg['s'] = 2;
                $msg['m'] = "Topic re-structuring failed because another topic has already approved";
            } else {
                $query = "UPDATE `topic` SET `topic`='$topic',`status`=1 WHERE `id`=$id";
            }
        } else {
            $query = "UPDATE `topic` SET `topic`='$topic',`status`=1 WHERE `id`=$id";
        }
        $sql = $this->query($query);
        if (!empty($query)) {
            if (!$sql) {
                $msg['s'] = 2;
                $msg['m'] = "An error occured please try again later";
            } else {
                $this->Post_Notification(2, "supervisor", $stuid, "Your project topic is been restructured and approved");
                $msg['s'] = 1;
                $msg['m'] = "Topic re-structuring succeed!";
            }
        }
        return $msg;
    }

    function UpdateTopic($stuid, $id, $status) {
        $chk = $this->query("select id from topic WHERE stuid=$stuid and status=1");
        $msg = array();
        $query = "";
        if ($this->no_rows($chk) > 0 && $status == 1) {
            $msg['s'] = 2;
            $msg['m'] = "Operation failed because another topic has already approved";
            return $msg;
            exit();
        }
        $query = "UPDATE `topic` SET `status`=$status WHERE `id`=$id";
        $sql = $this->query($query);
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later";
        } else {
            $this->Post_Notification(2, "supervisor", $stuid, "Your project topic is been " . $this->topicStatus($status));
            $msg['s'] = 1;
            $msg['m'] = "Operation succeed!";
        }
        return $msg;
    }

    function UpdateWork($id, $studid, $workfile, $status, $comment) {
        $sql = $this->query("UPDATE `projectwork` SET`reworkfile`='$workfile',`status`=$status,`comment`='$comment',`redate`=NOW() 
			WHERE `id`=$id");
        $this->Post_Notification(2, 'Supervisor', $studid, $this->workData($status));
        if (!$sql) {
            return 'fail';
        } else {
            return 'success';
        }
    }

    function workData($id) {
        switch ($id) {
            case 1:return "Your work have been approved";
                break;
            case 2:return "Your work have been disapproved";
                break;
        }
    }

    function AdminLogin($name, $staffid) {
        $sql = $this->query("SELECT * FROM `users` WHERE username='$name' and password='$staffid'");
        if ($this->no_rows($sql) == 0) {
            $msg['s'] = 2;
            $msg['m'] = "Invalid admin login deteils!";
            $msg['t'] = 'Access denied';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        }
        $row = $this->fetch_assoc($sql);
        session_start();
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['fullname'] = $row['Fullname'];
        $msg['s'] = 1;
        $msg['m'] = "Access granted!";
        $msg['t'] = 'Granted';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

}

?>