<?php
//Erase the cache before loading the page
header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv='cache-control' content='no-
cache'>
<meta http-equiv='expires' content='-1'>
<meta http-equiv='pragma' content='no-cache'>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta charset="utf-8"/><meta name="X-UA-Compatible" content="IE=edge"/>

<meta name="theme-color" content="#ffffff"/>

<!--Google font-->
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/assets/css/font-awesome.min.css"/>
<link href="/assets/css/styles.css" rel="stylesheet"/>
<link rel="stylesheet" href="/assets/css/aos.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
<!-- <link rel="stylesheet" href="/assets/css/sweetalert2.min.css"> -->


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="/assets/js/aos.js"></script>
<script src="/assets/js/sweetalert2.all.min.js"></script>
<?php
$title = (isset($title)) ? $title : SITE_NAME;
?>
<title> <?php echo $title; ?> </title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/"><b>WassappViews</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item my-2 my-lg-0">
        <a class="nav-link" href="/downloads">Download</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/home/installation">How to install the VCF file</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/account/tos">Terms of Service</a>
      </li>
    </ul>
  </div>
</nav>