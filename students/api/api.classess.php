<?php

//mysql_select_db('db_projectmanagement', mysql_connect('localhost', 'root', ''))or die(mysql_error());

class api_classes {

    public $sqlErr;
    public $conn = null;

    function __construct() {
        $this->conn =  mysqli_connect('localhost', 'root', '',"proj_2019_pms")or die(mysqli_connect_errno());
    }

    function Error() {
        return $this->Error();
    }

    function query($string) {
        $result = mysqli_query($this->conn,$string) or $this->sqlErr = mysqli_error($this->conn);
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

    //End of the attempts
    function StudentList($id) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE id=$id";
    }

    function getStudentID($stuid) {
        $sql = $this->query("SELECT studentid FROM `tb_students` WHERE id=$stuid");
        $row = $this->fetch_array($sql);
        return $row['studentid'];
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

    function Post_Notification($type, $sn, $rv, $da) {
        $sql = $this->query("INSERT INTO `notifications`(`data`, `sender`, `receiverid`,type) VALUES ('$da','$sn',$rv,$type)");
        return $sql;
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

    function getSupervisor($id) {
        $sql = $this->query("SELECT * FROM `tb_supervisor` WHERE id=$id");
        $row = $this->fetch_array($sql);
        return $row['firstname'] . ' ' . $row['othernames'];
    }

    function getSupAssignedStudents($id) {
        $sql = $this->query("SELECT * FROM `tb_schedulled` where studid=$id");
        if ($this->no_rows($sql) > 0) {
            $row = $this->fetch_array($sql);
            return $row['supid'];
        } else {
            return '<span class="label label-warning">Not Assign</span>';
        }
    }

    function Notification($id) {
        $sql = $this->query("UPDATE `notifications` SET `status`=1 WHERE `id`=$id");
        return $sql;
    }

    function submitTopic($id, $topic) {
        $chck = $this->query("select * from topic where stuid=$id and status=0");
        if ($this->no_rows($chck) >= 3) {
            $msg['s'] = 2;
            $msg['m'] = "You have already submitted 3 topics!";
            $msg['t'] = 'Attention';
            $msg['ico'] = 'icon-exclamation-sign';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        }
        $sql = $this->query("INSERT INTO `topic`( `stuid`, `topic`) VALUES ($id,'$topic')");
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later!";
            $msg['t'] = 'Error';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        }$this->Post_Notification(1, $this->getStudentID($id), $this->getSupAssignedStudents($id), ' Your student have submitted his/her 
		Project Topic');
        $msg['s'] = 1;
        $msg['m'] = "Topic successfully submitted!";
        $msg['t'] = 'Success';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

    function Send_Message($t, $sid, $s, $m, $r) {
        $sql = $this->query("INSERT INTO `inbox`(`type`,`senderid`,`sender`,`message`,`receiverid`) VALUES ($t,$sid,'$s','$m',$r)");
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later!";
            $msg['t'] = 'Error';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        }$this->Post_Notification(1, $this->getStudentID($sid), $r, ' Your student have sent you a message');
        $msg['s'] = 1;
        $msg['m'] = "Message successfully sent!";
        $msg['t'] = 'Success';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

    function uploadwork($stid, $work, $workfile, $sup) {
        $sql = $this->query("INSERT INTO `projectwork`(`studid`, `work`, `workfile`) VALUES ($stid,'$work','$workfile')");
        if (!$sql) {
            $msg['s'] = 2;
            $msg['m'] = "An error occured please try again later!";
            return $msg;
            exit();
        }$this->Post_Notification(1, $this->getStudentID($stid), $sup, ' Your student ' . $this->getStudentID($stid) . ' have success upload
		 his/her project work');
        $msg['s'] = 1;
        $msg['m'] = "Project work successfully upload!";
        return $msg;
        exit();
    }

    function StudentLogin($name, $staffid) {
        $sql = $this->query("SELECT * FROM `tb_students` WHERE firstname='$name' and studentid='$staffid'");
        if ($this->no_rows($sql) == 0) {
            $msg['s'] = 2;
            $msg['m'] = "Invalid students login deteils!";
            $msg['t'] = 'Access denied';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        }
        $row = $this->fetch_assoc($sql);
        session_start();
        $_SESSION['student_id'] = $row['id'];
        $_SESSION['dpm'] = $row['department'];
        $_SESSION['sch'] = $row['school'];
        $_SESSION['fullname'] = $row['firstname'] . ' ' . $row['othernames'];
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