<?php

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
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2216 ;'
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
    'web' => 0,
    'art' => '',
    'handyman' => '',
    'expectations' => '',
    'comments' => '',
    'newsletter' => '',
    'recruit' => 0,
    'events' => '',
    'bike_safety' => '',
    'representative' => 0,
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
        if (strlen($_POST['first_name']) > 2) {
            $firstname = ucwords($_POST['first_name']);
        } else {
            $error_msg .= "* Please enter a full first name<br />";
        }
        // check the POST variable lastname is sane, and is not empty
        if (strlen($_POST['last_name']) > 2) {
            $lastname = ucwords($_POST['last_name']);
        } else {
            $error_msg .= "* Please enter a full last name<br />";
        }
        // check for valid email address
        if (strlen($_POST['email']) > 2) {
            if (is_email_valid($_POST['email']) != false) {
                $email = $_POST['email'];
            } else {
                $error_msg .= "* Please enter a valid email address<br />";
            }
        } else {
            $error_msg .= "* Please provide an email address so we can contact you<br />";
        }
        // check the sanity of the zipcode and that it is greater than zero and 5 digits long - it can be left blank
        $zip = substr($_POST['zip'], 0, 5);
        if (!($zip > 0 && strlen($zip) == 5)) {
            $zip = '';
        }
        //check the date of birth
        if (strpos($_POST['dob'], '/') !== false) {
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
            $error_msg .= "* Please enter a valid date of birth<br />";
        }
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
        $greeter = isset($_POST['greeter']) ? 1 : 0;
        $mechanic = isset($_POST['mechanic']) ? 1 : 0;
        $recycling = isset($_POST['recycling']) ? 1 : 0;
        $bars = isset($_POST['bars']) ? 1 : 0;
        $cleaning = isset($_POST['cleaning']) ? 1 : 0;
        $handyman = isset($_POST['handyman']) ? 1 : 0;
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;
        $art = isset($_POST['art']) ? 1 : 0;
        $fundraising = isset($_POST['fundraising']) ? 1 : 0;
        $community = isset($_POST['community']) ? 1 : 0;
        $local_events = isset($_POST['local_events']) ? 1 : 0;
        $teach = isset($_POST['teach']) ? 1 : 0;
        $expectations = $_POST['expectations'];
        $concerns = $_POST['concerns'];
    }
}

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
        'mechanic' => $mechanic,
        'recycling' => $recycling,
        'bike_retrieval' => $bars,
        'organize_shop' => $cleaning,
        'handyman' => $handyman,
        'web' => $web, // YO, DOUBLE USED!
        'newsletter' => $newsletter,
        'recruit' => $recruit, // YO, DOUBLE USED!
        'art' => $art,
        'teach' => $teach,
        'grant_writing' => $fundraising,
        'web' => $web,
        'outreach' => $community,
        'representative' => $representative,
        'events' => $local_events,
        'kid_trips' => $kidtrips,
        'bike_safety' => $teach,
        'expectations' => $expectations,
        'comments' => $concerns,
        'app_date' => date('Y-m-d'),
    ];
    $wpdb->insert('volunteers', $data);

    echo 'Thanks for sending us you data. We\'ll be in touch soon!';
    die;
}

if ($error_msg !== '') {
    echo '<div style="color: red; font-weight:bold; font-style: italic;">The following problems were detected:<br>' . $error_msg . "</div><br>";
}