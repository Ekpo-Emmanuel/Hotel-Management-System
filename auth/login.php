<?php 
require "../components/header.php";
require "../config/config.php";


$get_email = "email";
$get_pass = "password";

$get_email_Error = "";
$get_pass_Error = "";
$db_error = "";

$tb_name = "users";

if(isset($_SESSION['username'])) {
	// echo '<script> window.location.href = '.$appUrl.'</script>';
	echo '<script> window.location.href = "http://localhost/projects/project1/Hotel MS"</script>';
}

if(isset($_POST["submit"])) {
	$email = trim($_POST[$get_email]);
	$Npass = trim($_POST[$get_pass]);

	//validate email
	if (empty($email)) {
		$get_email_Error = "Please enter an email";
	} 

	//validate password
	if(empty($Npass)) {
		$get_pass_Error = "Please Enter a password";
	} 


	//send to db
	if (empty($get_email_Error) AND empty($get_pass_Error)) {
		$login = $conn->query("SELECT * FROM $tb_name WHERE email='$email'");
		$login->execute();
	
		$fetch = $login->fetch(PDO::FETCH_ASSOC);
		if ($login->rowCount() > 0) {
			if (password_verify($Npass, $fetch['mypassword'])) {
				// $db_error = "Logged in";
				// header("location: register.php");
				$_SESSION['username'] = $fetch['username'];
				$_SESSION['id'] = $fetch['id'];

				echo '<script> window.location = "../index.php" </script>';
			} else {$db_error = "Email or Password is incorrect";}
		} else {$db_error = "Email or Password is incorrect";}
	}
}


?>

    <div class="hero-wrap js-fullheight" style="background-image: url('<?php echo $appUrl ?>/images/image_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<!-- <h2 class="subheading">Welcome to Vacation Rental</h2>
          	<h1 class="mb-4">Rent an appartment for your vacation</h1>
            <p><a href="#" class="btn btn-primary">Learn more</a> <a href="#" class="btn btn-white">Contact us</a></p> -->
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-middle" style="margin-left: 397px;">
	    		<div class="col-md-6 mt-5">
						<form action="login.php" method="POST" class="appointment-form" style="margin-top: -568px;">
						<span style="color:red; font-size: 10px"><?php echo $db_error ?></span>
							<h3 class="mb-3">Login</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<span style="color:red; font-size: 10px"><?php echo $get_email_Error ?></span>
			    					    <input type="text" class="form-control" placeholder="Email" name="<?php echo $get_email ?>"  value="<?php if(isset($email)) {echo $email;} ?>">
			    				    </div>
								</div>
                                <div class="col-md-12">
									<div class="form-group">
										<span style="color:red; font-size: 10px"><?php echo $get_pass_Error ?></span>
			    					    <input type="password" class="form-control" placeholder="Password" name="<?php echo $get_pass ?>">
			    				    </div>
								</div>
								<div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" value="Login" class="btn btn-primary py-3 px-4" name="submit">
                                    </div>
								</div>
							</div>
	    			</form>
	    		</div>
	    	</div>
	    </div>
    </section>
    <?php require "../components/footer.php"  ?>
