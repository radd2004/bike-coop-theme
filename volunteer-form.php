<form method="POST" enctype="multipart/form-data">
<div class="row">
    <h1>FC Bike Co-op Volunteer Application</h1>
    <div class="row">
        This application will let us know of your intent to volunteer and we'll get you plugged into the co-op via email. After you're tied in and get some volunteer hours under your belt you will be eligible for volunteer privileges. <b>Fields marked with ** are required.
    </div>
    <div class="row">
        <div class="small-3 columns">
            <label for="first-name" class="right inline">** First Name:</label>
        </div>
        <div class="small-9 columns">
          <input id="first-name" name="first_name" type="text" 
            value="<?php echo $first_name ?>">
        </div>
    </div>
    <div class="row">
        <div class="small-3 columns">
            <label for="last-name" class="right inline">** Last Name:</label>
        </div>
        <div class="small-9 columns">
            <input name="last_name" type="text" id="last-name" 
                value="<?php echo $last_name ?>">
        </div>
    </div>
</div>
    <tr>
        <td align=right width="25%">Phone:</td>
        <td align=left><input name="phone" type="text" id="phone" size="35" maxlength="15"
                              value="<?php echo $phone ?>">
    </tr>
    <tr>
        <td align=right width="25%">Email Address:</td>
        <td align=left><input name="email" type="text" id="email" 
            size="35" maxlength="50" value="<?php echo $email ?>"> <b>**</b>
        </td>
    </tr>
    <tr>
        <td align=right width="25%">Date of Birth:</td>
        <td align=left>
            <input name="dob" type="text" id="dob" size="10" maxlength="10"
                              value="<?php echo $dob ?>"> (MM/DD/YYYY) <b>**</b>
        </td>
    </tr>
    <tr>
        <td align=right width="25%">Address:</td>
        <td align=left>
            <input name="address" type="text" id="address" size="35" maxlength="100"
                      value="<?php echo $address ?>">
        </td>
    </tr>
    <tr>
        <td align=right width="25%">City:</td>
        <td align=left>
            <input name="city" type="text" id="city" size="35" 
                maxlength="25" value="<?php echo $city ?>">
        </td>
    </tr>
    <tr>
        <td align=right width="25%">State:</td>
        <td align=left>
            <select name="state" id="state">
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
        </td>
    </tr>
    <tr>
        <td align=right width="25%">Zip Code:</td>
        <td align=left><input name="zip" type="text" id="zip" size="6" maxlength="5" value="<?php echo $zip ?>"></td>
    </tr>
    <tr>
        <td align=left colspan="2"><h2>Emergency Contact</h2></td>
    </tr>
    <tr>
        <td align=right width="25%">Name:</td>
        <td align=left>
            <input name="emergency_contact" type="text" id="emergency_contact"
                size="35" maxlength="50" value="<?php echo $emergency_contact ?>">
        </td>
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
    <td align=left colspan="2">
        <textarea name="how_learn" 
                rows="5" cols="65"
                 ><?php echo $how_learn; ?></textarea>
        </tr>
        <tr>
            <td align=left colspan="2">Do you have any prior experience fixing bikes? Explain...</td>
        </tr>
    </td>
    <td align=left colspan="2">
        <textarea name="experience"
                  rows="5" cols="65"
                 ><?php echo $experience; ?></textarea>
        </tr>
        <tr>
            <td align=left colspan="2">Do you have any other skills that may help the Co-op?</td>
        </tr>
    </td>
    <td align=left colspan="2">
        <textarea name="other_skills"
                  rows="5" cols="65"
                 ><?php echo $other_skills; ?></textarea>
        </tr>
        <tr>
            <td align=left colspan="2">How skilled are you with tools?</td>
        </tr>
        <tr>
            <td align=left colspan="2"><select name="skill_level">
                    <option value="<?php echo $skill_level; ?>"
                            selected="selected"><?php echo $skill_level; ?></option>
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
        
        <tr>
            <td colspan="2"><h2>Interests as a volunteer</h2><p>(Move your mouse over an item to see a description.)</p>
        </tr>
        <tr>
            <td width="50% align="right">
            <input type=checkbox name="greeter"
                   value="1" <?php if ($greeter): echo 'checked'; endif; ?>>
                   <strong
                title="Assist during open shop and retail hours at the co-op.  Greet people, answer questions, sell items and help run the show!">Front
                Desk / Retail / Representative</strong>
            <td width="50% align=" right
            ">
            <input type=checkbox name="mechanic"
                   value="1" <?php if ($mechanic): echo 'checked'; endif; ?> ><strong
                title="Our bike mechanics work on sorting donations, building/fixing bikes and teaching people during open shop. You will need to have demonstrable bike mechanic skills to do this work.">Bike
                Mechanic</strong>
        </tr>
        <tr>
            <td align="left">
                <input type=checkbox name="recycling"
                       value="1" <?php if ($recycling): echo 'checked'; endif; ?>>
                       <strong
                    title="With all of the bikes and parts that come through the Co-op, there are a lot of parts that are broken or junk. Somebody has to go through it all.">Recycling</strong>
            <td width="50% align=" right">

            <input type=checkbox name="bars"
                   value="1" <?php if ($bars): echo 'checked'; endif; ?>>
            <strong
                title="Respond to public reports of lost and abandoned bikes to coordinate retrieval; work with Police Services in tracking found bikes and returning them to their owners.">Bike Retrieval</strong>
        </tr>
        <tr>
            <td align="left">
            <input type=checkbox
                name="cleaning" <?php if ($cleaning): echo 'checked'; endif; ?>>Cleaning/Organizing the Shop
            <td width="50% align=" right
            ">

            <input type=checkbox name="handyman"
                   value="1" <?php if ($handyman): echo 'checked'; endif; ?>><strong
                title="Projects range from installing sinks, running low voltage and 110vac wiring, replacing a staircase, building partition walls etc.  Will work with construction leader to complete a variety of projects.">Handyman/Construction</strong>
        </tr>
        <tr>
            <td align="left">
                <input type=checkbox name="newsletter"
                       value="1" <?php if ($newsletter): echo 'checked'; endif; ?>>Newsletter Drafting/PR
            <td align="left">
                <input type=checkbox name="art"
                       value="1" <?php if ($art): echo 'checked'; endif; ?>
                       >Art Contributions / Graphic Design
        </tr>
        <tr>
            <td align="left">
                <input type=checkbox name="fundraising"
                       value="1" <?php if ($fundraising): echo 'checked'; endif; ?>>Fundraising / Grant Writing
            <td width="50% align=" right
            ">
            <input type=checkbox name="community"
                   value="1" <?php if ($community): echo 'checked'; endif; ?>>Helping with Community Outreach
        </tr>
        <tr>
            <td align="left"><input type=checkbox name="local_events" value="1" 
                <?php if ($local_events): echo 'checked'; endif; ?>>Assist With Local Bike Events
            </td>
            <td width="50%" align="right">
            <input type=checkbox name="kidtrips"
                    value="1" <?php if ($kidtrips): echo 'checked'; endif; ?>><strong
                title="Trips for Kids a program that takes underprivileged kids aged 10-15 out on mountain bike rides on Saturday mornings. We need mechanics and ride volunteers.">Trips for Kids</strong>
            </td>
        </tr>
        <tr>
            <td width="50%" align="right" style="border-bottom: none;">
            <input type=checkbox name="teach" value="1" <?php if ($teach): echo 'checked'; endif; ?>>
                <strong href="#" title="Help educate our community on bicycle safety and smart cycling based on the vehicular cycling principles of the League of American Bicyclists.  Work with the Co-op’s Smart Cycling coordinator to teach classes to kids and adults, including bike skills workshops (also called “bike rodeos”).  We hope to eventually lead smart cycling rides in town to demonstrate the principles that we teach.">Bike Safety Education</strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td align=left colspan="2"><h2>Final Questions</h2></td>
        </tr>
        <tr>
            <td align=left colspan="2">What are your expectations out of volunteering for the Co-op?</td>
        </tr>
        <tr>
            <td align=left colspan="2">
            <textarea name="expectations" rows="5" cols="65"><?php echo $expectations ?></textarea>
        </tr>
        <tr>
            <td align=left colspan="2">Any other questions, comments, or concerns?</td>
        </tr>
        <tr>
            <td align=left colspan="2">
                <textarea name="concerns" rows="5" cols="65"><?php echo $concerns ?></textarea>
        </tr>
</table>

    <h3>This is not an application for the Earn-a-Bike program. Stop by during <a
            href="http://fcbikecoop.org/calendar.php">public hours</a> to start the Earn-a-Bike Program.</h3>

    <h3>You do not need this form for community service. Stop by during <a href="http://fcbikecoop.org/calendar.php">public
            hours</a> to learn about serving community service at the Bike Co-op.</h3>

    <input type="submit" value="Submit">
</form>