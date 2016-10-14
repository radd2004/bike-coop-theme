<?php
// This script is on the public side of the website and is for people to report an abandoned bike.
include_once('/var/www/fcbikecoop.org/root/header.php');
// check ALL the POST variables
function checkSet(){
	return isset($_POST['contact'], $_POST['address'], $_POST['phone']);
}
/**
 * This function can be used to check the sanity of variables
 *
 * @access private
 *
 * @param string $type  The type of variable can be bool, float, numeric, string, array, or object
 * @param string $string The variable name you would like to check
 * @param string $length The maximum length of the variable
 *
 * return bool
*/
function sanityCheck($string, $type, $length){
  // assign the type
  $type = 'is_'.$type;

  if(!$type($string))
    {
    return FALSE;
    }
  // now we see if there is anything in the string
  elseif(empty($string))
    {
    return FALSE;
    }
  // then we check how long the string is
  elseif(strlen($string) > $length)
    {
    return FALSE;
    }
  else
    {
    // if all is well, we return TRUE
    return TRUE;
		}
}

// Checks to see if the form has been submitted.
// If it hasn't, PHP ignores heaps of this code and display the form.
// If the form was submitted, it will create variables based on
// form field names and users answers.

// this will be the default message if the form accessed without POSTing
$error_msg="Please fill in the form.<br />";

if (isset ($_POST['submit']))
	{
	foreach($_POST as $key=>$value)
		{
		$$key = $value;
		}

	// Create an empty error_msg
	$error_msg='';
	require_once('/var/www/fcbikecoop.org/root/recaptcha/recaptchalib.php');
	$privatekey = "6LcljgQAAAAAAPouSflWvq1dlfio5lRYJ4RvEsGt";
	$publickey = "6LcljgQAAAAAAL1T9O8K4Rv0n3at7RUhFQBsLnoG";
	$resp = recaptcha_check_answer ($privatekey,
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]);
	if (!$resp->is_valid)
		{
		$error = $resp->error;
		$error_msg.="* incorrect Captcha response<br />";
		}
	if(checkSet() != FALSE)
		{
		// check the POST variable contact is sane, and is not empty
		if(empty($_POST['contact'])==FALSE && sanityCheck($_POST['contact'], 'string', 25) != FALSE)
			{
			$contact = ucwords($_POST['contact']);
			}
		else
			{
			$error_msg.="* contact name is not set<br />";
			}
		// check the POST variable address is sane, and is not empty
		if(empty($_POST['address'])==FALSE && sanityCheck($_POST['address'], 'string', 50) != FALSE)
			{
			$address = ucwords($_POST['address']);
			}
		else
			{
			$error_msg.="* address is not set<br />";
			}
		// check the POST variable phone is sane, and is not empty
		if(empty($_POST['phone'])==FALSE && sanityCheck($_POST['phone'], 'string', 13) != FALSE)
			{
			$phone = $_POST['phone'];
			}
		else
			{
			$error_msg.="* please provide a phone number so we can contact you<br />";
			}
		// Remove the escape characters from the info text.
		$info = stripslashes($_POST['info']);
		}
	}

// END BASIC ERROR CHECKING
// You need to create your own code to validate the information
// and allowed values - never send "unclean" user responses
// to a database without cleaning them up and
// checking for allowed answers.
// Google for "SQL injection" and "insecure contact form"

// Do this if no errors were detected AND form has been submitted
if ($error_msg == '' && isset($_POST['submit']))
	{
	//Close the session
	session_write_close();

	// No errors were detected.
	// Send the request.
	// get the radio button selection
	$locked = $_POST['locked'];
	// Build the link for logging the bike
	$parms = "brand=".urlencode($brand)."&model=".urlencode($model)."&color=".urlencode($color)."&contact=".urlencode($contact)."&location=".urlencode($address)."&phone=".urlencode($phone);
  // This version is for production and should the commented out when in test.
	$mail_to = 'bars@fcbikecoop.org';
  // This version is for testing and should the commented out when in production.
//	$mail_to = 'FCBC.Paul@gmail.com';

	mail( $mail_to,"Abandoned Bike - $address",
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
	// end of email to staff
	// Redirect to confirmation page.
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=bike_report_done.php">';   
	exit;
	}

// If PHP is still reading this, it must be the first page visit,
// OR an error was detected.
// Display the HTML page and your signup form.
// include_once('/var/www/fcbikecoop.org/root/header.php');

// If the form has been submitted,
// display the error messages above the form.
if(isset($_POST['submit']))
{
echo "<font color=\"red\" size=\"3\">The following problems were detected:<br><i>" .$error_msg ."</i></font><br>";
}
?>

<form method="POST" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data">
<h1>Abandoned Bike Report</h1>
<FONT SIZE=2 STYLE="font-size: 10pt">
<p>If you come across a bike that you believe has been lost or abandoned, we'll take care of it and get it back to its owner or back on the road. (Note: we don't have the authority to pick up a bike unless it's been in the same location for over 48 hours.)
<ul>
<li>If possible, please bring the bike by the <a href="http://fcbikecoop.org/contact.php">Bike Co-op</a> during <a href="http://fcbikecoop.org/calendar.php/">open retail/shop hours</a>.  If not possible, please fill in the following form to the best of your ability. Click on the Send button when you have completed the form.
<li>You will hear from us within one day of reporting the bike so we can set up a pick up time that works for both of us.
<li>If you'd like us to come and pick up the bike, please ensure that it will still be there when we arrive by pulling the bike as close to your building or residence as possible.
<li>If the bike is locked, please note what type of lock it is, U-Lock or cable, as we need different tools to remove each.
<li>Abandoned bikes are cross checked with police reports of stolen bikes, held for at least 30 days at our shop, advertised on the city's website, then released into one of our programs that help community members attain reliable transportation.
</ul>
<p>Thank you for helping keep bikes out of the landfill and getting them back on the road!
</p>
<h4>CONTACT INFORMATION</h4>
<p>Name: <input name="contact" type="text" id="contact" size="15" maxlength="25" value="<?php echo $contact ?>"> 
Address:  <input name="address" type="text" id="address" size="35" maxlength="50" value="<?php echo $address ?>">
<p>Phone:   <input name="phone" type="text" id="phone" size="13" maxlength="13" value="<?php echo $phone ?>">
<p>Location of bike at the above address:   <input name="location" type="text" id="location" size="25" maxlength="35" value="<?php echo $location ?>">
<h4>BIKE DESCRIPTION</h4>
<p>Brand: <input name="brand" type="text" id="brand" size="15" maxlength="25" value="<?php echo $brand ?>">
Model: <input name="model" type="text" id="model" size="15" maxlength="25" value="<?php echo $model ?>">
Color: <input name="color" type="text" id="color" size="15" maxlength="25" value="<?php echo $color ?>">
<p>Is it locked? <Input type = 'Radio' Name ='locked' value= 'yes' <?php echo isset($_POST['locked']) && $_POST['locked']=='yes'? ' checked' : '';?>>Yes
<Input type = 'Radio' Name ='locked' value= 'no' <?php echo isset($_POST['locked']) && $_POST['locked']=='no'? ' checked' : '';?>>No
<span style="margin-left:45px"> If locked, what type of lock? 
<select name="lock" id="lock">
			<option value="<?php echo $lock ?>" selected="selected"><?php echo $lock ?></option>
			<option value="Ulock">U-lock</option>
			<option value="cable">cable</option>
			<option value="chain">chain</option>
		</select>
</span>
<p>How many days has the bike been in it's current location? <input name="howlong" type="number" id="howlong" size="3" maxlength="3" value="<?php echo $howlong ?>"></p>
<p>Any special instructions or extra information you'd like us to know.</p>
<textarea name="info" cols=80 rows=3><?php echo $info ?></textarea>
<p>Questions should be emailed to the Bike Retrieval Squad (BARS) Coordinator at 
<a href="mailto:bars@fcbikecoop.org">bars@fcbikecoop.org</a>.</p>
<?php
require_once('/var/www/fcbikecoop.org/root/recaptcha/recaptchalib.php');
$publickey = "6LcljgQAAAAAAL1T9O8K4Rv0n3at7RUhFQBsLnoG";
echo recaptcha_get_html($publickey, $error);
?>
<br><br><input type="submit" value="Send" name="submit">
</form>
