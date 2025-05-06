<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A job application page for the company, containing all neccesary details.">
    <meta name="keywords" content="title, description, skills, email, phone, number, company, name">
    <meta name="author" content="Sophie Kroezen & Akhila Sripriyadarshini Gollamudi">
    <title>Job Application Page</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="apply-header">
        <!-- Logo and Title Section. Logo is sourced from GenAI: create a simple logo with the words "S.A Coders" in relation to HTML.-->
        <p><a href="http://127.0.0.1:5500/home.html" target="_blank"><img src= "images/sa_coders_logo.png" alt="S.A Coders Logo" class="logo" width="120" height="75"></a></p>
        
        <nav>
            <a href="index.html" target="_self" title="Home">Home</a>
            <a href="jobs.html" target="_self" title="Jobs">Jobs</a>
            <a href="about.html" target="_self" title="About">About Us</a>
            <a href="#start" target="_self" title="Apply">Apply</a>
        </nav>

        <h1>Applying for a job</h1>
    </header>
    
         <main id="start">
            <!-- Introduction and details for potential registration -->
            <p>Hello! Are you interested in applying for a job at S.A Coders? <strong>Complete the form below and we will contact you soon.</strong></p>
            <p><strong>Working Hours:</strong> 10:00 to 18:00 Monday to Friday.</p>

            <!-- Form for job application -->
            <form method="post" action="https://mercury.swin.edu.au/it000000/formtest.php" id="form">
    
                <!-- Applicants Details Section -->
                
                <div class="form-grid">
                    <fieldset>
                        <legend>Your Details</legend>
            
                        <p><label for="jobrefnum">Job Reference Number:</label>
                            <select name="jobrefnum" id="jobrefnum" required="required">
                                <option value="job1">59242</option>
                                <option value="job2">31972</option>
                                <option value="job3">60505</option>
                            </select>
                        </p>
        
                        <p><label for="firstname">First Name:</label>
                            <input type="text" name="firstname" id="firstname" maxlength= "20" pattern="[A-Za-z]+" required="required">
                               
                            <br> <!--Break between the first name and last name tabs-->
        
                        <p><label for="middlename">Middle Name <small>(Optional):</small></label>
                            <input type="text" name="middlename" id="middlename" maxlength= "20" pattern="[A-Za-z]+">
                               
                            <br><br> <!--Break between the middle name and last name tabs-->
        
                            <label for="lastname">Last Name:</label>
                            <input type="text" name="lastname" id="lastname" maxlength= "20" pattern="[A-Za-z]+" required="required">
                        </p>
        
                        <!--Date of Birth details-->
                        <p><label for="date">Date of Birth:</label>
                            <input type="text" name="data" id="date" placeholder="dd/mm/yyyy" pattern="\d{1,2}/\d{1,2}/\d{4}">
                        </p>
        
                        <!--Radio input for the gender. Only one option can be selected-->
                        <p><label for="gender">Gender:</label><br>
                            <input type="radio" name="gender" id="male" value="male" required="required">Male
                            <input type="radio" name="gender" id="female" value="female" required="required">Female
                        </p>
                    </fieldset>
            
                        <!-- User's home address and likewise details-->
                    <fieldset>
                        <legend>Home Address</legend>
                        <div class="home-details">
                            <p><label for="address">Street Address:</label>
                                <input type="text" name="address" id="address" maxlength= "40" pattern="[a-zA-Z0-9]+" required="required"></p>
                            <p><label for="suburb">Suburb/Town:</label>
                                <input type="text" name="suburb" id="suburb" maxlength= "40" pattern="[A-Za-z]+" required="required"></p>
                            <p><label for="state">State:</label> 
                                <select name="state" id="state" required="required">
                                    <option value="" selected="selected">Please Select</option>
                                    <option value="vic">Victoria</option>
                                    <option value="nsw">New South Wales</option>
                                    <option value="qld">Queensland</option>
                                    <option value="wa">Western Australia</option>
                                    <option value="sa">South Australia</option>
                                    <option value="nt">Northern Territory</option>
                                    <option value="tas">Tasmania</option>
                                    <option value="act">Australian Capital Territory</option>
                                </select></p>
                            <p><label for="postcode">Postcode:</label>
                                <input type="text" name="postcode" id="postcode" size="4" pattern="\d{4}" required="required"></p>
                        </div>
                    </fieldset>
                </div>
    
                <!-- User's Contact details -->
                <fieldset class="contact">
                    <legend>Contact Details</legend>
                    <label for="email">Enter Email:</label>
                        <input type="email" id="email" pattern=".+@example\.com" size="35" required="required" /><br><br>
                    <label for="phonenum">Phone Number:</label>
                        <input type="tel" id="phonenum" pattern="\d{4}-\d{3}-\d{3}" required />
                        <small>Format: 1234-567-890</small>
                        <br><br>
                    <label for="contact">Preferred Contact Method:</label><br>  
                        <input type="radio" name="contact" id="contact-email" value="email" required="required">Email
                        <input type="radio" name="contact" id="contact-phone" value="phone" required="required">Phone
                </fieldset>
        
                <!-- Skills List Section wtih checkboxes-->
                <fieldset>
                    <legend>Skills</legend>
                    <p>
                        <input type="checkbox" name="lang[]" id="programming" value="html" checked="checked">
                        <label for="programming">Programming</label>
    
                        <br>
                        <input type="checkbox" name="lang[]" id="design" value="css">
                        <label for="design">Design</label>
                            
                        <br>
                        <input type="checkbox" name="lang[]" id="database" value="javascript">
                        <label for="database">Database</label>
                            
                        <br>
                        <input type="checkbox" name="lang[]" id="software" value="java">
                        <label for="software">Software Development</label>
    
                        <br>
                        <input type="checkbox" name="lang[]" id="web" value="python">
                        <label for="web">Web Development</label>
    
                        <br>
                        <input type="checkbox" name="lang[]" id="algorithmics" value="c++">
                        <label for="data">Algorithmics</label>
    
                        <br>
                        <input type="checkbox" name="lang[]" id="project" value="php">
                        <label for="project">Project Management</label>
                            
                        <br>
                        <input type="checkbox" name="lang[]" id="data" value="mysql">
                        <label for="data">Data Analysis</label>
    
                        <br>
                        <input type="checkbox" name="lang[]" id="other" value="other">
                        <label for="other">Other</label>
                    </p>

                    <div class="textarea-flex">
                        <!-- Other Skills that the applicant has.  -->
                        <p><label for="skills">Other Skills <small>(Which are not mentioned above)</small><br>
                            <textarea name="skills" id="skills" rows="10" cols="40"
                                placeholder="Write your skills here..."></textarea></label>
                        </p>
    
                    <!-- Experience that the applicant has -->
                        <p><label for="experience">Experience <small>(Mention all the experience you have)</small><br>
                            <textarea name="experience" required="required" id="experience" rows="10" cols="40"
                                placeholder="Write your experience here..."></textarea></label>
                        </p>
                    </div>
                 </fieldset>
                   
                <br> <!-- Spacing for the footer-->
    
    
                <!-- Submit and Reset Buttons -->
                <input type="submit" value="Apply">
                <input type="reset" value="Reset Form">
            </form>

        </main>

        <br>
        <br>
        <br>

        <?php include 'footer.inc'; ?>
    </body>
</html>