<?php

function is_valid_email($field) {
	//filter_var() sanitizes the e-mail
	//address using FILTER_SANITIZE_EMAIL
	$field = filter_var($field, FILTER_SANITIZE_EMAIL);
	//filter_var() validates the e-mail
	//address using FILTER_VALIDATE_EMAIL
	return filter_var($field, FILTER_VALIDATE_EMAIL);
}

if (isset($_POST['email'])) {//if "email" is filled out, proceed
	if (!is_valid_email($_POST['email'])) {
		echo "Invalid input";
		$note = "Invalid Email Address";
	} else {//send email
		$email = $_POST['email'] ;
		wp_mail("news-join@fcbikecoop.org", "Subject: Subscribe", 'Subscribe', "From: $email" );
		echo "Thank you!  A confirmation email will be sent.  Please follow the instructions to get signed up.";
		$note = "Thank You!!";
	}
}

echo '<form method="post">
		<input name="email" placeholder="Your email" type="text">
		<input type="submit" value="Join">
	</form>';
