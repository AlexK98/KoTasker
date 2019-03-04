<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>KoTasker | <?php if(isset($title)) {echo $title;} ?></title>

	<!-- Bootstrap CSS -->
	<link href="/public/styles/bootstrap.min.css" rel="stylesheet"/>
<!--	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">-->

	<!-- Bootstrap and other JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
	<header>
		<?php if(isset($header)) {echo $header;}?>
	</header>
	<main class="container-fluid">
		<?php if(isset($main)) {echo $main;}?>
	</main>
	<footer>
		<?php if(isset($footer)) {echo $footer;}?>
	</footer>
</body>
</html>