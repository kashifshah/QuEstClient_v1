<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?= $title; ?></title>
	<link rel="stylesheet" type="text/css" href="/infrastructure/common.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
	<div id="content">
		<div id="title">
			<img src="http://www.sheffield.ac.uk/img/sheffield/crest-l.gif"  alt="[QTLaunchPad]" style="float:left;margin-right:20px;" />
			<h1>QuEst - Quality Estimation  <?= $title; ?></h1>
		</div>
		<div id="clearer" style="clear:both; padding-top:12px;"></div>
<!-- Start content here -->