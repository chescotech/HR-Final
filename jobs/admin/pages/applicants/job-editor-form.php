<?php
if (isset($_GET['id'])) {
    $from_jobs_id = $_GET['id'];

    $user_q = mysql_query("SELECT * FROM jobs_postings WHERE id=$from_jobs_id ") or die(mysql_error());
    while ($row = mysql_fetch_array($user_q)) {
        $edit_title = $row["title"];
        $edit_dep_id = $row["dep_id"];
        $edit_type = $row["type"];
        $edit_vacancies = $row["vacancies"];
        $edit_salary_min = $row["salary_min"];
        $edit_salary_max = $row["salary_max"];
        $edit_experience = $row["experience"];
        $edit_date = $row["date"];
        $edit_expires = $row["expires"];
        $edit_salary_period = $row["salary_period"];
        $edit_qualifications = $row["qualifications"];
        $edit_currency = $row["currency"];
        $edit_country = $row["country"];
        $edit_region = $row["region"];
        $edit_city = $row["city"];
        $edit_description = mysql_real_escape_string($row["description"]);
        $edit_requirements = mysql_real_escape_string($row["requirements"]);
    }
}

if (isset($_POST["updated_posting"])) {
    // return var_dump($link);
    $title = $_POST["title"];
    $dep_id = $_POST["dep_id"];
    $type = $_POST["type"];
    $vacancies = $_POST["vacancies"];
    $salary_min = $_POST["salary_min"];
    $salary_max = $_POST["salary_max"];
    $experience = $_POST["experience"];
    $date = $_POST["date"];
    $expires = $_POST["expires"];
    $salary_period = $_POST["salary_period"];
    $qualifications = $_POST["qualifications"];
    $currency = $_POST["currency"];
    $country = $_POST["country"];
    $region = $_POST["region"];
    $city = $_POST["city"];
    $description = $_POST["description"];
    $requirements = $_POST["requirements"];

    mysql_query("UPDATE jobs_postings SET title='$title', dep_id='$dep_id', type='$type', vacancies='$vacancies', salary_min='$salary_min', salary_max='$salary_max', experience='$experience', date='$date', expires='$expires', salary_period='$salary_period', qualifications='$qualifications', currency='$currency', country='$country', region='$region', city='$city', description='$description', requirements='$requirements' WHERE id='$from_jobs_id'")
        or die("Err11 " . mysql_error());

    echo "<script>document.location='job-list'</script>";
}

?>

<div class="content-wrapper" style="overflow:auto; height:80vh">
    <div>
        <ol class="breadcrumb">
            <li><a href="job-list">Jobs</a></li>
            <li class="active">Edit</li>
        </ol>
    </div>

    <div style="padding-right:20px; padding-left:20px">

        <form method="POST">

            <div class="panel panel-default">

                <div style="background-color:#fff; border-radius:5px; padding:10px; margin-bottom:20px;">
                    <label>
                        Edit out required information and publish your job.
                    </label>

                    <div>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="title">Job Title:</label>
                                <input value="<?php echo $edit_title; ?>" type="text" class="form-control" name="title" required>
                            </div>

                            <div class="col-md-6">
                                <label>Department:</label>
                                <select name="dep_id" class="form-control" required>
                                    <option>--Select Department--</option>
                                    <?php
                                    $departmentquery = mysql_query("SELECT * FROM department ");
                                    while ($row = mysql_fetch_array($departmentquery)) {
                                    ?>
                                        <option value="<?php echo $row['dep_id']; ?>"> <?php echo $row['department']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="pwd">Job Type:</label>
                                <select name="type" class="form-control" required>
                                    <option value="Contract">Contract</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Full Time">Full Time</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="pwd">Number Of Vacancies:</label>
                                <input value="<?php echo $edit_vacancies; ?>" type="number" class="form-control" name="vacancies" required>
                            </div>

                            <div class="col-md-6">
                                <label for="pwd">Required Qualifications:</label>
                                <input value="<?php echo $edit_qualifications; ?>" type="text" class="form-control" name="qualifications" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pwd">Required Years Of Experience:</label>
                                <input value="<?php echo $edit_experience; ?>" type="text" class="form-control" name="experience" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pwd">Date Posted:</label>
                                <input value="<?php echo $edit_date; ?>" type="date" class="form-control" name="date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pwd">Last Date to Apply:</label>
                                <input value="<?php echo $edit_expires; ?>" type="date" class="form-control" name="expires" required>
                            </div>


                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-default">
                <div style="background-color:#fff; border-radius:5px; padding:10px; margin-top:20px;">
                    <label>
                        Job Salary
                    </label>
                    <div>
                        <div action="#save" class="row g-3">
                            <div class="col-md-2">
                                <label for="pwd">Min:</label>
                                <input value="<?php echo $edit_salary_min; ?>" type="number" class="form-control" name="salary_min" required>
                            </div>
                            <div class="col-md-2">
                                <label for="pwd">Max:</label>
                                <input value="<?php echo $edit_salary_max; ?>" type="number" class="form-control" name="salary_max" required>
                            </div>
                            <div class="col-md-2">
                                <label for="pwd">Select Period:</label>
                                <select name="salary_period" class="form-control" required>
                                    <option value="none">None</option>
                                    <option value="hourly">Hourly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="pwd">Select Currency:</label>
                                <select name="currency" class="form-control" required>
                                    <option value="kwacha">Zambian kwacha</option>
                                    <option value="dollar">US Dollar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div style="background-color:#fff; border-radius:5px; padding:10px; margin-top:20px;">
                    <h5>
                        <label for="Job location">Job location</label>
                    </h5>
                    <div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="pwd">Country:</label>
                                <select id="country" name="country" class="form-control">
                                    <option value="Afganistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bonaire">Bonaire</option>
                                    <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Canary Islands">Canary Islands</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Channel Islands">Channel Islands</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos Island">Cocos Island</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote DIvoire">Cote DIvoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curaco">Curacao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="East Timor">East Timor</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands">Falkland Islands</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Ter">French Southern Ter</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Great Britain">Great Britain</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Hawaii">Hawaii</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="India">India</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea North">Korea North</option>
                                    <option value="Korea Sout">Korea South</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macau">Macau</option>
                                    <option value="Macedonia">Macedonia</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Midway Islands">Midway Islands</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Nambia">Nambia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherland Antilles">Netherland Antilles</option>
                                    <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                    <option value="Nevis">Nevis</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau Island">Palau Island</option>
                                    <option value="Palestine">Palestine</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Phillipines">Philippines</option>
                                    <option value="Pitcairn Island">Pitcairn Island</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Republic of Montenegro">Republic of Montenegro</option>
                                    <option value="Republic of Serbia">Republic of Serbia</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="St Barthelemy">St Barthelemy</option>
                                    <option value="St Eustatius">St Eustatius</option>
                                    <option value="St Helena">St Helena</option>
                                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                    <option value="St Lucia">St Lucia</option>
                                    <option value="St Maarten">St Maarten</option>
                                    <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                    <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                    <option value="Saipan">Saipan</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="Samoa American">Samoa American</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Tahiti">Tahiti</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Erimates">United Arab Emirates</option>
                                    <option value="United States of America">United States of America</option>
                                    <option value="Uraguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City State">Vatican City State</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                    <option value="Wake Island">Wake Island</option>
                                    <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zaire">Zaire</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="pwd">State/Region:</label>
                                <input value="<?php echo $edit_region; ?>" type="text" class="form-control" name="region">
                            </div>
                            <div class="col-md-4">
                                <label for="pwd">City:</label>
                                <input value="<?php echo $edit_city; ?>" type="text" class="form-control" name="city">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">

                <div style="background-color:#fff; border-radius:5px; padding:10px; margin-top:20px;">

                    <div>
                        <div action="#save" class="row g-3">

                            <div class="col-md-12">
                                <label for="pwd">Job description:</label>
                                <textarea name="description" class="form-control" rows="9" required><?php echo $edit_description; ?></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="pwd">Job requirements:</label>
                                <textarea name="requirements" class="form-control" rows="9" required><?php echo $edit_requirements; ?></textarea>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="panel panel-default">

                <div style="padding:10px; margin-top:20px;">
                    <div>
                        <div action="#save" class="row g-3">
                            <div class="col-md-6">
                                <button name="updated_posting" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>