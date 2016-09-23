<?php

function complicated_legacy_check_func($string, $type = 'string', $length = 5)
{
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
        if (empty($_POST['first_name']) == false && complicated_legacy_check_func($_POST['first_name'], 'string', 25) != false) {
            $firstname = ucwords($_POST['first_name']);
        } else {
            $error_msg .= "* first name is not set.<br />";
        }
        // check the POST variable lastname is sane, and is not empty
        if (empty($_POST['last_name']) == false && complicated_legacy_check_func($_POST['last_name'], 'string', 25) != false) {
            $lastname = ucwords($_POST['last_name']);
        } else {
            $error_msg .= "* last name is not set.<br />";
        }
        // check for valid email address
        if (complicated_legacy_check_func($_POST['email'], 'string', 50) != false) {
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
        if (!(complicated_legacy_check_func($zip) != false && strlen($zip) == 5)) {
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
?>
<form method="POST" enctype="multipart/form-data">
    <div class="heading">FC Bike Co-op Volunteer Application</div>

    <table width="550">
        <tr>
            <td align=left colspan="2">This application will let us know of your intent to volunteer and we'll get you
                plugged into the co-op via email. After you're tied in and get some volunteer hours under your belt you
                will be eligible for volunteer privileges. <b>Fields marked with ** are required.</b>
        </tr>
        <tr>
            <td align=right width="25%">First Name:</td>
            <td align=left><input name="first_name" type="text" id="firstname" size="35" maxlength="25"
                                  value="<?php echo $first_name ?>"> <b>**</b>
        </tr>
        <tr>
            <td align=right width="25%">Last Name:</td>
            <td align=left><input name="last_name" type="text" id="lastname" size="35" maxlength="25"
                                  value="<?php echo $last_name ?>"> <b>**</b>
        </tr>
        <tr>
            <td align=right width="25%">Phone:</td>
            <td align=left><input name="phone" type="text" id="phone" size="35" maxlength="15"
                                  value="<?php echo $phone ?>">
        </tr>
        <tr>
            <td align=right width="25%">Email Address:</td>
            <td align=left><input name="email" type="text" id="email" size="35" maxlength="50"
                                  value="<?php echo $email ?>"> <b>**</b>
        </tr>
        <tr>
            <td align=right width="25%">Date of Birth:</td>
            <td align=left><input name="dob" type="text" id="dob" size="10" maxlength="10"
                                  value="<?php echo $dob ?>"> (MM/DD/YYYY) <b>**</b>
        </tr>
        <tr>
            <td align=right width="25%">Address:</td>
            <td align=left><input name="address" type="text" id="address" size="35" maxlength="100"
                                  value="<?php echo $address ?>">
        </tr>
        <tr>
            <td align=right width="25%">City:</td>
            <td align=left><input name="city" type="text" id="city" size="35" maxlength="25"
                                  value="<?php echo $city ?>">
        </tr>
        <tr>
            <td align=right width="25%">State:</td>
            <td align=left><select name="state" id="state">
                    <option value="<?php echo $state ?>" selected="selected"><?php echo $state ?></option>
                    <option value="CO">Colorado</option>
                    <option value="WY">Wyoming</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CT">Connecticut</option>
                    <option value="DC">District of Columbia</option>
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                </select>
        </tr>
        <tr>
            <td align=right width="25%">Zip Code:</td>
            <td align=left><input name="zip" type="text" id="zip" size="6" maxlength="5" value="<?php echo $zip ?>">
        </tr>
        <tr>
            <td align=left colspan="2"><h2>Emergency Contact</h2></td>
        </tr>
        <tr>
            <td align=right width="25%">Name:</td>
            <td align=left><input name="emergency_contact" type="text" id="emergency_contact" size="35" maxlength="50"
                                  value="<?php echo $emergency_contact ?>">
        </tr>
        <tr>
            <td align=right width="25%">Phone:</td>
            <td align=left><input name="emergency_phone" type="text" id="emergency_phone" size="35" maxlength="15"
                                  value="<?php echo $emergency_phone ?>">
        </tr>
        <tr>
            <td align=right width="25%">Relationship:</td>
            <td align=left><input name="relationship" type="text" id="relationship" size="35" maxlength="25"
                                  value="<?php echo $relationship ?>">
        </tr>
        <tr>
            <td align=left colspan="2"><h2>Experience</h2></td>
        </tr>
        <tr>
            <td align=left colspan="2">How did you learn about the Co-op?</td>
        </tr>
        <td align=left colspan="2"><input type=hidden name="how_learn" value="NULL">
            <textarea name="how_learn"
                      rows="5"><?php echo $how_learn ?></textarea></tr>
            <tr>
                <td align=left colspan="2">Do you have any prior experience fixing bikes? Explain...</td>
            </tr>
        </td>
        <td align=left colspan="2">
            <input type=hidden name="experience" value="NULL">
            <textarea name="experience"
                      rows="5" cols="65"
                      wrap="virtual"><?php echo $experience ?></textarea>
            </tr>
            <tr>
                <td align=left colspan="2">Do you have any other skills that may help the Co-op?</td>
            </tr>
        </td>
        <td align=left colspan="2">
            <input type=hidden name="other_skills" value="NULL">
            <textarea name="other_skills"
                      rows="5" cols="65"
                      wrap="virtual"><?php echo $other_skills ?></textarea>
            </tr>
            <tr>
                <td align=left colspan="2">How skilled are you with tools?</td>
            </tr>
            <tr>
                <td align=left colspan="2"><select name="skill_level">
                        <option value="<?php echo $skill_level ?>"
                                selected="selected"><?php echo $skill_level ?></option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select></td>
            </tr>
        </td>
    </table>

    <table width="550">
        <tr>
            <td colspan="2"><h2>Interests as a volunteer.</h2>(Move your mouse over an item to see a description.)
        </tr>
        <tr>
            <td width="50% align="right">

            <input type=hidden name="greeter" value="0">
            <input type=checkbox name="greeter"
                   value="1"<?php if ($greeter == "1") {
                echo 'checked';
            } ?>><strong
                title="Assist during open shop and retail hours at the co-op.  Greet people, answer questions, sell items and help run the show!">Front
                Desk / Retail / Representative</strong>
            <td width="50% align=" right
            ">
            <input type=hidden name="mechanic" value="0">
            <input type=checkbox name="mechanic"
                   value="1"<?php if ($mechanic == "1") {
                echo 'checked';
            } ?>><strong
                title="Our bike mechanics work on sorting donations, building/fixing bikes and teaching people during open shop. You will need to have demonstrable bike mechanic skills to do this work.">Bike
                Mechanic</strong>
        </tr>
        <tr>
            <td align="left"><input type=hidden name="recycling" value="0">
                <input type=checkbox name="recycling"
                       value="1"<?php if ($recycling == "1") {
                    echo 'checked';
                } ?>><strong
                    title="With all of the bikes and parts that come through the Co-op, there are a lot of parts that are broken or junk. Somebody has to go through it all.">Recycling</strong>
            <td width="50% align=" right">

            <input type=hidden name="bars" value="0">
            <input type=checkbox name="bars"
                   value="1"<?php if ($bars == "1") {
                echo 'checked';
            } ?>>
            <strong
                title="Respond to public reports of lost and abandoned bikes to coordinate retrieval; work with Police Services in tracking found bikes and returning them to their owners.">Bike
                Retrieval</strong>
        </tr>
        <tr>
            <td align="left"><input type=hidden name="cleaning" value="0"><input type=checkbox
                                                                                 name="cleaning" <?php if ($cleaning) {
                    echo 'checked';
                } ?>>Cleaning/Organizing the Shop
            <td width="50% align=" right
            ">

            <input type=hidden name="handyman" value="0">
            <input type=checkbox name="handyman"
                   value="1"<?php if ($handyman == "1") {
                echo 'checked';
            } ?>><strong
                title="Projects range from installing sinks, running low voltage and 110vac wiring, replacing a staircase, building partition walls etc.  Will work with construction leader to complete a variety of projects.">Handyman/Construction</strong>
        </tr>
        <tr>
            <td align="left">
                <input type=hidden name="newsletter" value="0">
                <input type=checkbox name="newsletter"
                       value="1"<?php if ($newsletter == "1") {
                    echo 'checked';
                } ?>>Newsletter Drafting/PR
            <td align="left">
                <input type=hidden name="art" value="0">
                <input type=checkbox name="art"
                       value="1"<?php if ($art == "1") {
                    echo 'checked';
                } ?>>Art Contributions / Graphic Design
        </tr>
        <tr>
            <td align="left"><input type=hidden name="fundraising" value="0">
                <input type=checkbox name="fundraising"
                       value="1"<?php if ($fundraising == "1") {
                    echo 'checked';
                } ?>>Fundraising / Grant Writing
            <td width="50% align=" right
            ">
            <input type=hidden name="community" value="0">
            <input type=checkbox name="community"
                   value="1"<?php if ($community == "1") {
                echo 'checked';
            } ?>>Helping with Community Outreach
        </tr>
        <tr>
            <td align="left"><input type=hidden name="local_events" value="0"><input type=checkbox name="local_events"
                                                                                     value="1"<?php if ($local_events == "1") {
                    echo 'checked';
                } ?>>Assist With Local Bike Events
            <td width="50% align=" right
            ">
            <input type=hidden name="kidtrips" value="0"><input type=checkbox name="kidtrips"
                                                                value="1"<?php if ($kidtrips == "1") {
                echo 'checked';
            } ?>><strong
                title="Trips for Kids a program that takes underprivileged kids aged 10-15 out on mountain bike rides on Saturday mornings. We need mechanics and ride volunteers.">Trips
                for Kids</strong>
        </tr>
        <tr>
            <td width="50% align=" right">
            <input type=hidden name="safety" value="0"><input type=checkbox name="safety"
                                                              value="1"<?php if ($safety == "1") {
                echo 'checked';
            } ?>><strong href="#"
                         title="Help educate our community on bicycle safety and smart cycling based on the vehicular cycling principles of the League of American Bicyclists.  Work with the Co-op’s Smart Cycling coordinator to teach classes to kids and adults, including bike skills workshops (also called “bike rodeos”).  We hope to eventually lead smart cycling rides in town to demonstrate the principles that we teach.">Bike
                Safety Education</strong>

        </tr>
        <tr>
            <td>
                <hr>
        </tr>
        <tr>
            <td align=left colspan="2">What are your expectations out of volunteering for the Co-op?</td>
        </tr>
        <tr>
            <td align=left colspan="2"><input type=hidden name="expectations" value="NULL">
                <textarea name="expectations"
                          rows="5" cols="65"
                          wrap="virtual"><?php echo $expectations ?></textarea>
        </tr>
        <tr>
            <td align=left colspan="2">Any other questions, comments, or concerns?</td>
        </tr>
        <tr>
            <td align=left colspan="2"><input type=hidden name="concerns" value="NULL">
                <textarea name="concerns"
                          rows="5" cols="65"
                          wrap="virtual"><?php echo $concerns ?></textarea>
        </tr>
    </table>

    <h3>This is not an application for the Earn-a-Bike program. Stop by during <a
            href="http://fcbikecoop.org/calendar.php">public hours</a> to start the Earn-a-Bike Program.</h3>

    <h3>You do not need this form for community service. Stop by during <a href="http://fcbikecoop.org/calendar.php">public
            hours</a> to learn about serving community service at the Bike Co-op.</h3>

    <input type="submit">
</form>