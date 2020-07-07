<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta charset="utf-8"/><meta name="X-UA-Compatible" content="IE=edge"/>

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

<?php
$cats = $this->CatModelAuto->listAllCats();
?>


<nav class="navbar navbar-inverse navbar-fixed-top"> <div class="container"> <!-- Brand and toggle get grouped for better mobile display --> <div class="navbar-header"> 
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button></div>

<!-- Collect the nav links, forms, and other content for toggling --> <div class="collapse navbar-collapse" id="navbar-collapse"> <ul class="nav navbar-nav">
<?php
foreach($cats as $cat) {
	echo'<li><a href="' . site_url('/main/cat/' . $cat['link']) . '">' . $cat['name'] . '</a></li>';
}

?>
</ul>
</div><!-- /.navbar-collapse --> </div><!-- /.container-fluid --> </nav>

<div class="container" style="background: #fff; padding: 7px;">
<div class="row">
<div class="col-xs-12 col-sm-4 col-md-4">

<span class="hidden-xs"><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></span>
<span class="visible-xs"><br/><br/><br/><br/></span>
