<?php 
require "../components/header.php";
require "../config/config.php";


$get_name = "username";
$get_email = "email";
$get_pass = "password";

$get_name_Error = "";
$get_email_Error = "";
$get_pass_Error = "";
$db_gen_Error = "";

$tb_name = "users";

if(isset($_SESSION['username'])) {
	// echo '<script> window.location.href ='.$appUrl.'</script>';
	echo '<script> window.location.href = "http://localhost/projects/project1/Hotel MS"</script>';
}

if(isset($_POST["submit"])) {
	$name = trim($_POST[$get_name]);
	$email = trim($_POST[$get_email]);
	$Npass = trim($_POST[$get_pass]);

	//validate name
	if(empty($name)) {
		$get_name_Error = "Please Enter a Username";
	} else if (strlen($name) < 3) {
		$get_name_Error = "Username should be longer than 2 characters";
	}

	//validate email
	if (empty($email)) {
		$get_email_Error = "Please enter an email";
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$get_email_Error = "Please enter a valid email";
	}

	//validate password
	if(empty($Npass)) {
		$get_pass_Error = "Please Enter a password";
	} //else if(strlen($Npass) < 6) {
	// 	$get_pass_Error = "password should be greater than 6 characters";
	// }

	//check if already in database
    $sql = "SELECT COUNT(*) FROM $tb_name WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count > 0) {
		$db_gen_Error = "Email is already in use";
    } 


	//send to db
	if (empty($get_name_Error) AND empty($get_email_Error) AND empty($get_pass_Error)) {
		$hashPass = password_hash($Npass, PASSWORD_DEFAULT);

		$insert = $conn->prepare("INSERT INTO $tb_name (username, email, mypassword) VALUES (:username, :email, :mypassword)");
		$insert -> execute([ ":username" => $name, ":email" => $email, ":mypassword" => $hashPass ]);

		// header("Location: login.php");
		echo '<script> window.location = "register.php" </script>';

	}
}


?>

    <div class="hero-wrap js-fullheight" style="background-image: url('<?php echo $appUrl; ?>/images/image_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-middle" style="margin-left: 397px;">
	    		<div class="col-md-6 mt-5">
						<form action="register.php" method="POST" class="appointment-form" style="margin-top: -568px;">
							<span style="color:red; font-size: 10px"><?php echo $db_gen_Error; ?></span>
							<h3 class="mb-3">Register</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<span style="color:red; font-size: 10px"><?php echo $get_name_Error ?></span>
			    					    <input type="text" name="<?php echo $get_name; ?>" class="form-control" placeholder="Username" value="<?php if(isset($name)) {echo $name;} ?>">
			    				    </div>
								</div>
                                <div class="col-md-12">
									<div class="form-group">
										<span style="color:red; font-size: 10px"><?php echo $get_email_Error ?></span>
			    					    <input type="text" name="<?php echo $get_email; ?>" class="form-control" placeholder="Email" value="<?php if(isset($email)) {echo $email;} ?>">
			    				    </div>
								</div>
                                <div class="col-md-12">
									<div class="form-group">
										<span style="color:red; font-size: 10px"><?php echo $get_pass_Error ?></span>
			    					    <input type="password" name="<?php echo $get_pass; ?>" class="form-control" placeholder="Password" value="<?php if(isset($Npass)) {echo $Npass;} ?>">
			    				    </div>
								</div>
								<div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" value="Register" name="submit" class="btn btn-primary py-3 px-4">
                                    </div>
								</div>
							</div>
	    			</form>
	    		</div>
	    	</div>
	    </div>
    </section>

    <?php require "../components/footer.php"  ?>
