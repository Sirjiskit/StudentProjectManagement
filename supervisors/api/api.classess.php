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
        return "select s.`id`, s.`studentid`, CONCAT(s.`firstname`,' ',s.`othernames`) fullname, s.`school`, s.`department`,
		 s.`status` FROM `tb_students` s,tb_schedulled c WHERE (s.id=c.studid and s.school=c.schid and s.department=c.dpmid) 
		 and c.supid=$id";
    }

    function getStaffID($stuid) {
        $sql = $this->query("SELECT staffid FROM `tb_supervisor` WHERE id=$stuid");
        $row = $this->fetch_array($sql);
        return $row['staffid'];
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
        return "select `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`
		  FROM `tb_supervisor` WHERE id=$id";
    }

    function Notification($id) {
        $sql = $this->query("UPDATE `notifications` SET `status`=1 WHERE `id`=$id");
        return $sql;
    }

    function getSupAssignedNo($id) {
        $sql = $this->query("SELECT * FROM `tb_schedulled` where supid=$id");
        if ($this->no_rows($sql) > 0) {
            return $this->no_rows($sql);
        } else {
            return '<span class="label label-warning">Not Assign</span>';
        }
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
        } $this->Post_Notification(2, 'Supervisor', $r, 'Your supervisor have sent you a message');
        $msg['s'] = 1;
        $msg['m'] = "Message successfully sent!";
        $msg['t'] = 'Success';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
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
        $sql = $this->query("UPDATE `projectwork` SET `reworkfile`='$workfile',`status`=$status,`comment`='$comment',`redate`=NOW() WHERE `id`=$id");
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

    function SupervisorLogin($name, $staffid) {
        $sql = $this->query("SELECT * FROM `tb_supervisor` WHERE firstname='$name' and staffid='$staffid'");
        if ($this->no_rows($sql) == 0) {
            $msg['s'] = 2;
            $msg['m'] = "Invalid supervisors login deteils!";
            $msg['t'] = 'Access denied';
            $msg['ico'] = 'icon-remove-circle';
            $msg['tp'] = 'red';
            return $msg;
            exit();
        }
        $row = $this->fetch_assoc($sql);
        session_start();
        $_SESSION['supervisor_id'] = $row['id'];
        $_SESSION['dpm'] = $row['department'];
        $_SESSION['sch'] = $row['school'];
        $_SESSION['status'] = $row['status'];
        $_SESSION['fullname'] = $row['firstname'] . ' ' . $row['othernames'];
        $msg['s'] = 1;
        $msg['m'] = "Access granted!";
        $msg['t'] = 'Granted';
        $msg['ico'] = 'icon-info-sign';
        $msg['tp'] = 'green';
        return $msg;
        exit();
    }

    function StudentList1($dpm, $sch) {
        return "select `id`, `studentid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, `department`, `status`,
		 `isAssigned` FROM `tb_students` WHERE `department`=$dpm and `school`=$sch";
    }

}

?>