<?php 
	require "../components/header.php";
	require "../config/config.php";


	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$room = $conn->query("SELECT * FROM rooms WHERE status = 1 AND id='$id'");
		$room -> execute();

		$singleRoom = $room->fetch(PDO::FETCH_OBJ);

		//grabbing utilities
		$utility = $conn->query("SELECT * FROM utilities WHERE room_id='$id'");
		$utility -> execute();

		$allUtilities = $utility->fetchAll(PDO::FETCH_OBJ);
	}

	function validatePhoneNumber($phoneNumber) {
		$cleanedPhoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);	
		if (strlen($cleanedPhoneNumber) !== 10) {
			return false;
		}	
		return true;
	}

	$get_email = "email";
	$get_name = "fullname";
	$get_phone = "phone_number";
	$get_check_in = "check_in";
	$get_check_out = "check_out";


	$get_name_Error = "";
	$get_email_Error = "";
	$get_phone_Error = "";
	$get_date_error = "";

	$db_gen_Error = "";

	if(isset($_POST["submit"])) {
		$email = trim($_POST[$get_email]);
		$name = trim($_POST[$get_name]);
		$phone = $_POST[$get_phone];
		$checkIn = $_POST[$get_check_in];
		$checkOut = $_POST[$get_check_out];
		$hotel_name = $singleRoom->hotel_name;
		$room_name = $singleRoom->name;

		//validate name
		if(empty($name)) {
			$get_name_Error = "Please Enter Full Name";
		} else if (strlen($name) < 3) {
			$get_name_Error = "Username should be longer than 2 characters";
		}

		//validate email
		if (empty($email)) {
			$get_email_Error = "Please enter an email";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$get_email_Error = "Please enter a valid email";
		}
		
		//phone validation
		if(empty($phone)) {
			$get_phone_Error = "Please Enter your Phone Number";
		} else if (!validatePhoneNumber($phone)) {
			$get_phone_Error = "Please Enter a valid Phone Number";
		} else {
			$phone = $phone;
		}

		//date validation
		if(empty($checkIn) OR empty($checkOut)){
			$get_date_error = "Enter checkIn and checkOut dates";
		} else if (date("Y/m/d") > $checkIn OR date("Y/m/d") > $checkOut) {
			$get_date_error = "Pick a date that is not in the past";
		} else if ($checkIn > $checkOut OR $checkIn == date("Y/m/d")) {
			$get_date_error = "You cannot Pick today's date";
		} 


		if(empty($get_name_Error) AND empty($get_email_Error) AND empty($get_phone_Error) AND empty($get_date_error)) {
			$user_id = $_SESSION['id'];

			$booking = $conn->prepare("INSERT INTO bookings (check_in, check_out, email, phone_number, full_name, hotel_name, room_name, user_Id) VALUES (:check_in, :check_out, :email, :phone_number, :full_name, :hotel_name, :room_name, :user_Id)");

			$booking -> execute([
				":check_in" => $checkIn, 
				":check_out" => $checkOut, 
				":email" => $email, 
				":phone_number" => $phone, 
				":full_name" => $name, 
				":hotel_name" => $hotel_name, 
				":room_name" => $room_name, 
				":user_Id" => $user_id,
			]);

		}
	}

?>

<link rel="stylesheet" href="<?php echo $appUrl ?>/css/intlTelInput.css" />

    <div class="hero-wrap js-fullheight" style="background-image: url('<?php echo $appUrl ?>/images/<?php echo $singleRoom->image ?>');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<h2 class="subheading">Welcome to Vacation Rental</h2>
          	<h1 class="mb-4"><?php echo  $singleRoom->name ?></h1>
            <!-- <p><a href="#" class="btn btn-primary">Learn more</a> <a href="#" class="btn btn-white">Contact us</a></p> -->
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-end">
	    		<div class="col-lg-4">
					<form action="room-single.php?id=<?php echo $id ?>" method="POST" class="appointment-form" style="margin-top: -568px;">
						<h3 class="mb-3">Book this room</h3>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<span style="color:red; font-size: 10px"><?php echo $get_email_Error ?></span>
									<input type="text" class="form-control" placeholder="Email" name="<?php echo $get_email ?>" value="<?php if(isset($email)) {echo $email;} ?>">
								</div>
							</div>
						   
							<div class="col-md-12">
								<div class="form-group">
									<span style="color:red; font-size: 10px"><?php echo $get_name_Error ?></span>
									<input type="text" class="form-control" placeholder="Full Name" name="<?php echo $get_name ?>" value="<?php if(isset($name)) {echo $name;} ?>">
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<span style="color:red; font-size: 10px"><?php echo $get_phone_Error ?></span>
									<input type="tel" class="form-control" id="phon"  name="<?php echo $get_phone ?>" value="<?php if(isset($phone)) {echo $phone;} ?>" placeholder="phone number">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
								<div class="input-wrap">
									<div class="icon"><span class="ion-md-calendar"></span></div>
										<input type="text" class="form-control appointment_date-check-in" name="<?php echo $get_check_in ?>" placeholder="Check-In" value="<?php if(isset($checkIn)) {echo $checkIn;} ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="icon"><span class="ion-md-calendar"></span></div>
									<input type="text" class="form-control appointment_date-check-out" name="<?php echo $get_check_out ?>" placeholder="Check-Out" value="<?php if(isset($checkOut)) {echo $checkOut;} ?>">
								</div>
							</div>
							<span style="color:red; font-size: 10px"><?php echo $get_date_error ?></span>
							
						
						
							<div class="col-md-12">
								<div class="form-group">
									<input type="submit" value="Book and Pay Now" class="btn btn-primary py-3 px-4" name="submit">
								</div>
							</div>
						</div>
				</form>
	    		</div>
	    	</div>
	    </div>
    </section>
   
    <section class="ftco-section bg-light">
		<div class="container">
			<div class="row no-gutters">
				<div class="col-md-6 wrap-about">
					<div class="img img-2 mb-4" style="background-image: url('<?php echo $appUrl?>/images/image_2.jpg');">
					</div>
					<h2>The most recommended vacation rental</h2>
					<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
				</div>
				<div class="col-md-6 wrap-about ftco-animate">
					<div class="heading-section">
					<div class="pl-md-5">
						<h2 class="mb-2">What we offer</h2>
					</div>
				</div>
				<div class="pl-md-5">
					<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
					<div class="row">
						<?php foreach($allUtilities as $i) : ?>
							<div class="services-2 col-lg-6 d-flex w-100">
								<div class="icon d-flex justify-content-center align-items-center">
										<span class="<?php echo $i->icon ?>"></span>
								</div>
								<div class="media-body pl-3">
									<h3 class="heading"><?php echo $i->name ?></h3>
									<p><?php echo $i->description ?></p>
								</div>
							</div> 
						<?php endforeach; ?>
					</div>  
				</div>
			</div>
		</div>
	</section>
		
	<section class="ftco-intro" style="background-image: url('<?php echo $appUrl?>/images/image_2.jpg');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-9 text-center">
					<h2>Ready to get started</h2>
					<p class="mb-4">It’s safe to book online with us! Get your dream stay in clicks or drop us a line with your questions.</p>
					<p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Learn More</a> <a href="#" class="btn btn-white px-4 py-3">Contact us</a></p>
				</div>
			</div>
		</div>
	</section>

	<script src="<?php echo $appUrl ?>/js/intlTelInput.js"></script>
    <script>
      var input = document.querySelector("#phone");
      window.intlTelInput(input, {
        initialCountry: "ca",
		onlyCountries: ['ca', 'us'],
        // preferredCountries: ['ca', 'us'],
        separateDialCode: true,
        showFlags: true,
        utilsScript: "<?php echo $appUrl ?>/js/utils.js"
      });
    </script>

<?php require "../components/footer.php"  ?>