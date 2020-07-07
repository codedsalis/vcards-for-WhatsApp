<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta charset="utf-8"/><meta name="X-UA-Compatible" content="IE=edge"/>

<meta name="theme-color" content="#263238"/>

<link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/assets/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/assets/css/style.css"/>
<script src="/assets/js/jquery-1.11.2.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<?php
$title = (isset($title)) ? $title : SITE_NAME;
?>
<title> <?php echo $title; ?> </title>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" style="background:#000;"> 
<div class="container">

 <!-- Brand and toggle get grouped for better mobile display -->
<style>
.headlogo {
color:#ffffff; font-family: "Arial Black", Gadget, sans-serif; font-size:35px; font-weight:250px;
}
</style>


 <div class="navbar-header">
    <a
class="navbar-brand" style="margin-top: -10px;height:55px;"
href="/717/"><div class="headlogo">AfriAdverts</div></a>
</div>

<!-- Collect the nav links, forms, and other content for toggling --> <div class="collapse navbar-collapse" id="navbar-collapse"> <ul class="nav navbar-nav pull-right">
<?php
?>
</ul>
</div><!-- /.navbar-collapse --> </div><!-- /.container-fluid --> </nav>


<div class="container">
<div class="row">
<?php
//GET USER INFO
$user = $this->UserInfo->getUserInfo(LOGGED_ID);

?>
<span class="hidden-xs"><br/><br/><br/><br/></span>
<?php
if(LOGGED_IN) {
	echo'<span class="visible-xs"><br/><br/><br/><br/></span>';
}
else {
	echo'<span class="visible-xs"><br/><br/><br/><br/></span>';
}
?>