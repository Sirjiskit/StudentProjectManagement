<?php
session_start();
if(!isset($_SESSION['student_id'])){
	header('location:../');
}
$dpm = $_SESSION['dpm'];
$sch = $_SESSION['sch'];
$id = $_SESSION['student_id'];
$LogerName = $_SESSION['fullname'];
?>