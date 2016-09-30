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

function create_table_with_wpdb($wpdb)
{
    $wpdb->query('CREATE TABLE IF NOT EXISTS `volunteers` (
          `vol_id` int(10) NOT NULL AUTO_INCREMENT,
          `status` int(1) NOT NULL,
          `first_name` longtext,
          `last_name` longtext,
          `address` longtext,
          `city` longtext,
          `state` longtext,
          `zip` longtext,
          `email` longtext,
          `phone` longtext,
          `dob` date DEFAULT NULL,
          `emergency_contact` longtext,
          `emergency_phone` longtext,
          `relationship` longtext,
          `how_learn` longtext,
          `experience` longtext,
          `other_skills` longtext,
          `skill_level` decimal(2,0) DEFAULT NULL,
          `mechanic` varchar(1) DEFAULT NULL,
          `recycling` varchar(1) DEFAULT NULL,
          `bike_retrieval` varchar(1) DEFAULT NULL,
          `teach` varchar(1) DEFAULT NULL,
          `organize_shop` varchar(1) DEFAULT NULL,
          `outreach` varchar(1) DEFAULT NULL,
          `grant_writing` varchar(1) DEFAULT NULL,
          `web` varchar(1) DEFAULT NULL,
          `art` varchar(1) DEFAULT NULL,
          `handyman` varchar(1) DEFAULT NULL,
          `expectations` longtext,
          `comments` longtext,
          `newsletter` varchar(1) DEFAULT NULL,
          `recruit` varchar(1) DEFAULT NULL,
          `events` varchar(1) DEFAULT NULL,
          `bike_safety` varchar(1) DEFAULT NULL,
          `representative` varchar(1) DEFAULT NULL,
          `kid_trips` varchar(1) DEFAULT NULL,
          `app_date` date DEFAULT NULL,
          PRIMARY KEY (`vol_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2216 ;'
    );
}

function insert_data_give_wpdb_and_data($wpdb, $data)
{
    $wpdb->insert('volunteers',
        $data
    );
}

$error_msg = '';

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
if ($error_msg == '' && isset($_POST['first_name'])) {
    $birth = strftime("%Y-%m-%d", strtotime($dob));
	$birth = str_replace("-","",$birth);

    global $wpdb;
    create_table_with_wpdb($wpdb);
    $data = [
        'first_name' => $firstname,
        'last_name' => $lastname,
        'address' => $address,
        'city' => $city,
        'state' => $state,
        'zip' => $zip,
        'email' => $email,
        'phone' => $phone,
        'dob' => $birth,
        'emergency_contact' => $emergency_contact,
        'emergency_phone' => $emergency_phone,
        'relationship' => $relationship,
        'how_learn' => $how_learn,
        'experience' => $experience,
        'other_skills' => $other_skills,
        'skill_level' => $skill_level,
        // 'greeter' => $greeter,
        'mechanic' => $mechanic,
        'recycling' => $recycling,
        // 'bars' => $bars,
        // 'cleaning' => $cleaning,
        'handyman' => $handyman,
        'newsletter' => $newsletter,
        'art' => $art,
        // 'fundraising' => $fundraising,
        // 'community' => $community,
        'events' => $local_events,
        'kid_trips' => $kidtrips,
        'bike_safety' => $safety,
        'expectations' => $expectations,
        // 'concerns' => $concerns,
        'app_date' => date('Y-m-d'),
    ];
    insert_data_give_wpdb_and_data($wpdb, $data);

    // No errors were detected.
    // $volid = mysql_insert_id();
    // Redirect to confirmation page.
    echo 'Form saved!';
    die;
}

if ($error_msg !== '') {
    echo '<div style="color: red; font-weight:bold; font-style: italic;">The following problems were detected:' . $error_msg . "</div><br>";
}