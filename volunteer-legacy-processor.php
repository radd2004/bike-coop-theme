<?php

function legacy_check_function(
    $string, 
    $type = 'string', 
    $length = 5
) {
    $type_checking_function = 'is_' . $type;
    $type_matches_expectations = $type_checking_function($string);

    $has_value = !empty($string);
    $is_longer_than_expectation = strlen($string) > $length;

    if ($type_matches_expectations
        && $has_value
        && !$is_longer_than_expectation) {
        return true;
    }
    return false;
}

function is_email_valid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$error_msg = '';
$error_msg .= "Please fill in the form.<br />";
// check to see if the form has already been successfully submitted
if (isset ($_POST['volid'])) {
    $error_msg = "You've already successfully submitted your application - thank you<br />";
}

$defaults = [
    'first_name' => '',
    'last_name' => '',
    'address' => '',
    'city' => '',
    'state' => '',
    'zip' => '',
    'email' => '',
    'phone' => '',
    'dob' => '',
    'emergency_contact' => '',
    'emergency_phone' => '',
    'relationship' => '',
    'how_learn' => '',
    'experience' => '',
    'other_skills' => '',
    'skill_level' => '',
    'mechanic' => '',
    'recycling' => '',
    'bike_retrieval' => '',
    'teach' => '',
    'organize_shop' => '',
    'outreach' => '',
    'grant_writing' => '',
    'web' => '',
    'art' => '',
    'handyman' => '',
    'expectations' => '',
    'comments' => '',
    'newsletter' => '',
    'recruit' => '',
    'events' => '',
    'bike_safety' => '',
    'representative' => '',
    'kid_trips' => '',
    'concerns' => '',

    'bars' => 0,
    'cleaning' => 0,
    'fundraising' => 0,
    'community' => 0,
    'local_events' => 0,
    'kidtrips' => 0,
    'safety' => 0,
    'greeter' => 0,
];
foreach ($defaults as $key => $value) {
    $$key = $value;
}

if (isset ($_POST['first_name'])) {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    // Create an empty error_msg
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $_POST['address'])) {
        // check the POST variable firstname is sane, and is not empty
        if (empty($_POST['first_name']) == false && legacy_check_function($_POST['first_name'], 'string', 25) != false) {
            $firstname = ucwords($_POST['first_name']);
        } else {
            $error_msg .= "* first name is not set.<br />";
        }
        // check the POST variable lastname is sane, and is not empty
        if (empty($_POST['last_name']) == false && legacy_check_function($_POST['last_name'], 'string', 25) != false) {
            $lastname = ucwords($_POST['last_name']);
        } else {
            $error_msg .= "* last name is not set.<br />";
        }
        // check for valid email address
        if (legacy_check_function($_POST['email'], 'string', 50) != false) {
            if (is_email_valid($_POST['email']) != false) {
                $email = $_POST['email'];
            } else {
                $error_msg .= "* invalid Email address<br />";
            }
        } else {
            $error_msg .= "* please provide an email address so we can contact you<br />";
        }
        // check the sanity of the zipcode and that it is greater than zero and 5 digits long - it can be left blank
        $zip = substr($_POST['zip'], 0, 5);
        if (!(legacy_check_function($zip) != false && strlen($zip) == 5)) {
            $zip = '';
        }
        //check the date of birth
        if (empty($_POST['dob']) == false) {
            $dt = $_POST['dob'];
            $arr = preg_split("/[\/]/", $dt); // splitting the array
            $mm = str_pad($arr[0], 2, "0", STR_PAD_LEFT); // first element of the array is month
            $dd = str_pad($arr[1], 2, "0", STR_PAD_LEFT); // second element is date
            $yy = str_pad($arr[2], 4, "19", STR_PAD_LEFT); // third element is year
            if (!checkdate(intval($mm), intval($dd), intval($yy))) {
                $error_msg .= "* invalid date of birth; please use mm/dd/yyyy format<br />";
            } else {
                $dob = $mm . "/" . $dd . "/" . $yy;
            }
        } else {
            $error_msg .= "* please provide your date of birth<br />";
        }
        // convert stuff to initial caps
        $address = ucwords(strtolower($_POST['address']));
        $city = ucwords(strtolower($_POST['city']));
        $emergency_contact = ucwords(strtolower($_POST['emergency_contact']));
        $state = ucwords(strtolower($_POST['state']));
        $phone = $_POST['phone'];
        $emergency_phone = $_POST['emergency_phone'];
        $relationship = $_POST['relationship'];
        $how_learn = $_POST['how_learn'];
        $experience = $_POST['experience'];
        $other_skills = $_POST['other_skills'];
        $skill_level = $_POST['skill_level'];
        $greeter = $_POST['greeter'];
        $mechanic = $_POST['mechanic'];
        $recycling = $_POST['recycling'];
        $bars = $_POST['bars'];
        $cleaning = $_POST['cleaning'];
        $handyman = $_POST['handyman'];
        $newsletter = $_POST['newsletter'];
        $art = $_POST['art'];
        $fundraising = $_POST['fundraising'];
        $community = $_POST['community'];
        $local_events = $_POST['local_events'];
        $safety = $_POST['safety'];
        $expectations = $_POST['expectations'];
        $concerns = $_POST['concerns'];
    }
}

// END BASIC ERROR CHECKING
// You need to create your own code to validate the information
// and allowed values - never send "unclean" user responses
// to a database without cleaning them up and
// checking for allowed answers.
// Google for "SQL injection" and "insecure contact form"

// Do this if no errors were detected AND form has been submitted
if ($error_msg == '' && isset($_POST['submit'])) {
    //Close the session
    // session_write_close();
    // Connect to the MySQL database
    // Include our login information
    include('db_login.php');
//Connect
    $dsn = "mysql:host=$db_host;dbname=" . $db_database;
    $opt = array(
        // any occurring errors wil be thrown as PDOException
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // an SQL command to execute when connecting
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    );
    $db = new PDO($dsn, $db_username, $db_password, $opt);
    //Connect
//	$db_error='There was a problem accessing our system.  Please try again later.';
//	$connection = @mysql_connect($db_host, $db_username, $db_password) or die($db_error);
//	// Select the database
//	$db_select = @mysql_select_db($db_database) or die($db_error);
    // fix up the date for MySQL
    $birth = strftime("%Y-%m-%d", strtotime($dob));
//	$birth = str_replace("-","",$birth);
    $appdate =
    $query = $db->prepare("INSERT INTO VOLUNTEERS (FirstName, LastName, Address, City, State, 
		Zip, Email, Phone, DOB, EmergencyContact, EmergencyPhone, Relationship, HowLearn, Experience, 
		OtherSkills, Level, Greeter, Mechanic, Recycling, BARS, Clean, Handyman, Newsletter, Art, 
		Fund, Outreach, Events, KidTrips, BikeSafety, Expectations, Comments, AppDate) 
		VALUES (:fname, :lname, :address, :city, :state, :zip, :email, :phone, :dob, :emergency_contact, 
		:ephone, :rel, :howlearn, :experience, :otherskills, :skill, :greeter, :mechanic, :recycling, 
		:bars, :cleaning, :handyman, :newsletter, :art, :fundraising, :community, :events, :kidtrips, 
		:safety, :expectations, :concerns, CURDATE())");
    $query->bindValue(':fname', $firstname, PDO::PARAM_STR);
    $query->bindValue(':lname', $lastname, PDO::PARAM_STR);
    $query->bindValue(':address', $address, PDO::PARAM_STR);
    $query->bindValue(':city', $city, PDO::PARAM_STR);
    $query->bindValue(':state', $state, PDO::PARAM_STR);
    $query->bindValue(':zip', $zip, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':phone', $phone, PDO::PARAM_STR);
    $query->bindValue(':dob', $birth, PDO::PARAM_STR);
    $query->bindValue(':emergency_contact', $emergency_contact, PDO::PARAM_STR);
    $query->bindValue(':ephone', $emergency_phone, PDO::PARAM_STR);
    $query->bindValue(':rel', $relationship, PDO::PARAM_STR);
    $query->bindValue(':howlearn', $how_learn, PDO::PARAM_STR);
    $query->bindValue(':experience', $experience, PDO::PARAM_STR);
    $query->bindValue(':otherskills', $other_skills, PDO::PARAM_STR);
    $query->bindValue(':skill', $skill_level, PDO::PARAM_STR);
    $query->bindValue(':greeter', $greeter, PDO::PARAM_STR);
    $query->bindValue(':mechanic', $mechanic, PDO::PARAM_STR);
    $query->bindValue(':recycling', $recycling, PDO::PARAM_STR);
    $query->bindValue(':bars', $bars, PDO::PARAM_STR);
    $query->bindValue(':cleaning', $cleaning, PDO::PARAM_STR);
    $query->bindValue(':handyman', $handyman, PDO::PARAM_STR);
    $query->bindValue(':newsletter', $newsletter, PDO::PARAM_STR);
    $query->bindValue(':art', $art, PDO::PARAM_STR);
    $query->bindValue(':fundraising', $fundraising, PDO::PARAM_STR);
    $query->bindValue(':community', $community, PDO::PARAM_STR);
    $query->bindValue(':events', $local_events, PDO::PARAM_STR);
    $query->bindValue(':kidtrips', $kidtrips, PDO::PARAM_STR);
    $query->bindValue(':safety', $safety, PDO::PARAM_STR);
    $query->bindValue(':expectations', $expectations, PDO::PARAM_STR);
    $query->bindValue(':concerns', $concerns, PDO::PARAM_STR);
    try {
        // run the query
        $query->execute();
    } catch (PDOException $e) {
        echo "The statement failed.\n";
        echo "getCode: " . $e->getCode() . "\n";
        echo "getMessage: " . $e->getMessage() . "\n";
    }
    // Build our query here and check each variable with mysql_real_escape_string()

    // No errors were detected.
    $volid = mysql_insert_id();
    // Redirect to confirmation page.
    echo 'Form saved!';
    die;
}

if (isset($_POST['submit'])) {
    echo '<div style="color: red; font-weight:bold; font-style: italic;">The following problems were detected:' . $error_msg . "</div><br>";
}