<?php
	include('config.php');
	include('jsmin.php');
	echo JSMin::minify(file_get_contents('plantillas/js/rating/jquery.rater.js'));
?>