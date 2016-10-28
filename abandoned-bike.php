<?php
// set defaults for form
// CONTACT
$contact = '';
$address = '';
$phone = '';
$location = '';
// BIKE DESC
$brand = '';
$model = '';
$color = '';
$locked = false;
$lock = false;
$howlong = '';
$info = '';

$error_msg = "Please fill in the form.<br />";

if (isset ($_POST['submit'])) {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    // Create an empty error_msg
    $error_msg = '';
    $necessaryFieldsSet = isset($_POST['contact'], $_POST['address'], $_POST['phone']);
    if ($necessaryFieldsSet != FALSE) {
        // check the POST variable contact is sane, and is not empty
        $contact = ucwords($_POST['contact']);
        if (strlen($contact) < 1 && strlen($contact) > 50) {
            $error_msg .= "* Please make sure you enter your name<br />";
        }
        $address = ucwords($_POST['address']);
        if (strlen($address) < 1 && strlen($address) > 50) {
            $error_msg .= "* Please include an address<br />";
        }
        $phone = $_POST['phone'];
        if (strlen($address) < 7 && strlen($address) > 13) {
            $error_msg .= "* Please provide a phone number so we can contact you<br />";
        }
        // Remove the escape characters from the info text.
        $info = stripslashes($_POST['info']);
    }
}

// Do this if no errors were detected AND form has been submitted
if ($error_msg == '' && isset($_POST['submit'])) {
    // Send the request.
    // get the radio button selection
    $locked = $_POST['locked'];
    // Build the link for logging the bike
    $parms = "brand=" . urlencode($brand) . "&model=" . urlencode($model) . "&color=" . urlencode($color) . "&contact=" . urlencode($contact) . "&location=" . urlencode($address) . "&phone=" . urlencode($phone);
    // This version is for production and should the commented out when in test.
    $mail_to = 'bars@fcbikecoop.org';
    // This version is for testing and should the commented out when in production.
    $mail_to = 'test@davidbhayes.com';

    wp_mail($mail_to, "Abandoned Bike - $address",
        "Abandoned Bike Report Form
	An abandoned bike has been reported via the website.  Please contact $contact at $phone within 24 hours of receiving this email.

	CONTACT INFORMATION
		Contact Name:  $contact
		Address: $address
		Phone: $phone
	BIKE INFORMATION
		Brand: $brand
		Model: $model
		Color: $color
		Locked? $locked
		Lock Type: $lock
		Location: $location
		How many days at location? $howlong
		Other Info: $info

	Once you have recovered the bike, click on this link to log it in the database:
	http://fcbikecoop.org/volunteer_db/bars/GotBike.php?$parms

	",
        "From: bars@fcbikecoop.org");

    global $wpdb;
    $wpdb->query('CREATE TABLE IF NOT EXISTS `abandoned_bike` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
	    	`contact` text,
	    	`address` text,
	    	`phone` varchar(255),

	    	`brand` varchar(255),
	    	`model` varchar(255),
	    	`color` varchar(255),
	    	`is_locked` boolean,
	    	`lock` varchar(255),
	    	`location` text,
	    	`how_long` text,
	    	`info` text,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2216 ;'
    );
    $wpdb->insert('abandoned_bike', [
        'contact' => $contact,
        'address' => $address,
        'phone' => $phone,

        'brand' => $brand,
        'model' => $model,
        'color' => $color,
        'is_locked' => $locked,
        'lock' => $lock,
        'location' => $location,
        'how_long' => $howlong,
        'info' => $info,
    ]);
    // end of email to staff
    // Redirect to confirmation page.
    echo 'Report accepted. Thanks!';
    die;
}

// If the form has been submitted,
// display the error messages above the form.
if (isset($_POST['submit'])) {
    echo '<div data-alert class="alert-box alert">'.$error_msg.'</div>';
}
?>

<form method="POST" enctype="multipart/form-data">
<div class="row">
	<h4>Contact Information</h4>
	<div class="row">
		<div class="large-12 columns">
			<label>Name
				<input name="contact" type="text" id="contact" value="<?php echo $contact; ?>"> 
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Address
				<input name="address" type="text" id="address"
					value="<?php echo $address; ?>"> 
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Phone
				<input name="phone" type="text" id="phone" value="<?php echo $phone; ?>">
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Location of bike at the above address:
				<input name="location" type="text" id="location"
					value="<?php echo $location; ?>">
			</label>
	    </div>
	</div>
</div> 
<div class="row">
	<h4>BIKE DESCRIPTION</h4>
	<div class="row">
		<div class="large-12 columns">
			<label>Brand
				<input name="brand" type="text" id="brand"
					value="<?php echo $brand; ?>">
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Model
				<input name="model" type="text" id="model"
					value="<?php echo $model; ?>">
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Color
				<input name="color" type="text" id="color" 
					value="<?php echo $color; ?>">
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Is it locked?
				<input type='radio' name='locked'
                   value='yes' <?php echo isset($_POST['locked']) && $_POST['locked'] == 'yes' ? ' checked' : ''; ?>>Yes
            <input type='radio' name='locked'
                   value='no' <?php echo isset($_POST['locked']) && $_POST['locked'] == 'no' ? ' checked' : ''; ?>>No
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>If locked, what type of lock?
				<select name="lock" id="lock">
					<option value="<?php echo $lock; ?>" selected="selected"><?php echo $lock; ?></option>
					<option value="Ulock">U-lock</option>
					<option value="cable">cable</option>
					<option value="chain">chain</option>
				</select>
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>How many days has the bike been in it's current location?
				<input name="howlong" type="number" id="howlong" 
					value="<?php echo $howlong; ?>">
			</label>
	    </div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Any special instructions or extra information you'd like us to know
				<textarea name="info" cols=80 rows=3><?php echo $info; ?></textarea>
			</label>
	    </div>
	</div>
    <p>Questions should be emailed to the Bike Retrieval Squad (BARS) Coordinator at
        <a href="mailto:bars@fcbikecoop.org">bars@fcbikecoop.org</a>.
    </p>
    <div class="row">
		<div class="large-12 columns">
			<input class="button" type="submit" value="Send" name="submit">
	    </div>
	</div>
</div>   
</form>
