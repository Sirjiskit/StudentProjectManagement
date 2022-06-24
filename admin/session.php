<?php
session_start();
if(!isset($_SESSION['admin_id'])){
	header('location:login');
}
$LogerName = $_SESSION['fullname'];
?>