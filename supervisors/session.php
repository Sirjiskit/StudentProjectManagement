<?php
session_start();
if(!isset($_SESSION['supervisor_id'])){
	header('location:../');
}
$dpm = $_SESSION['dpm'];
$sch = $_SESSION['sch'];
$id = $_SESSION['supervisor_id'];
$LogerName = $_SESSION['fullname'];
$legerStatus = $_SESSION['status'];
?>