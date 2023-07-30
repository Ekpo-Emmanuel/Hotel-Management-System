
<?php 
	session_start();
	
	$appUrl = "http://localhost/projects/project1/Hotel MS";
	$footerLinks = array (
		// array(
		// 	"name"=>"Home", 
		// 	"page" => 'index.php',
		// ),
		array(
			"name"=>"About", 
			"page" => $appUrl.'/about.php',
		),
		array(
			"name"=>"Services", 
			"page" => $appUrl.'/services.php',
		),
		array(
			"name"=>"Apartment Room", 
			"page" => $appUrl.'/rooms.php',
		),
		array(
			"name"=>"contact", 
			"page" => $appUrl.'/contact.php',
		),
		array(
			"name"=>"Login", 
			"page" => $appUrl.'/auth/login.php',
		),
		array(
			"name"=>"Register", 
			"page" => $appUrl.'/auth/register.php',
		),
	);



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Vacation Rental</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/animate.css">
    
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/magnific-popup.css">

    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/jquery.timepicker.css">

    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/css/style.css">
  </head>
  <body>
		<div class="wrap">
			<div class="container">
				<div class="row justify-content-between">
						<div class="col d-flex align-items-center">
							<p class="mb-0 phone"><span class="mailus">Phone no:</span> <a href="#">+00 1234 567</a> or <span class="mailus">email us:</span> <a href="#">emailsample@email.com</a></p>
						</div>
						<div class="col d-flex justify-content-end">
							<div class="social-media">
				    		<p class="mb-0 d-flex">
				    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
				    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
				    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
				    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
				    		</p>
			        </div>
						</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	    	<a class="navbar-brand" href="index.html">Vacation<span>Rental</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto" id="link_capture">
				<li class="nav-item"><a href="<?php echo $appUrl ?>/index.php" class="nav-link">Home</a></li>
				<?php if(!isset($_SESSION['username'])) { 
					 	foreach ($footerLinks as $item) { ?>
						<li class="nav-item	">
							<a href="<?php echo $item['page'] ?>" class="nav-link"><?php echo $item['name']; ?></a>
						</li>
					<?php }} else { 
						$modifiedArray = array_slice($footerLinks, 0, -2);
						foreach($modifiedArray as $item2) {
					?>
					<li class="nav-item	">
						<a href="<?php echo $item2['page'] ?>" class="nav-link"><?php echo $item2['name']; ?></a>
					</li>
				<?php }};?>
				<?php if(isset($_SESSION['username'])) : ?>
				<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo $_SESSION['username']; ?>
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="#">Action</a></li>
							<li><a class="dropdown-item" href="#">Another action</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?php echo $appUrl; ?>/auth/logout.php">Logout</a></li>
						</ul>
				</li>
				<?php endif; ?>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->