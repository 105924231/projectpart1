<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A home page for the company, containing all neccesary details.">
    <meta name="keywords" content="title, description, skills, email, phone, number, company, name">
    <meta name="author" content="Sophie Kroezen & Akhila Sripriyadarshini Gollamudi">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles/styles.css"> <!-- Link to the CSS file for styling -->
    <link rel="websiteicon" href="images/sa_coders_logo.png" type="image/png"> <!-- Link to the favicon for the website -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body class="index-body">
    <header class="header-container">
        <!-- Logo and Title Section. Logo is sourced from GenAI: create a simple logo with the words "S.A Coders" in relation to HTML.-->
        <a href="index.html"><img src="images/sa_coders_logo.png" alt="S.A Coders Logo" class="logo" width="120" height="75"></a>

       
        <!--Nav bar-->

        <div class="main-menu">
            <main>   <!-- Unordered List for the different pages in this project. They will open in a different tab.-->
                <nav>
                    <a href="index.html" target="_self" title="Home">Home</a>
                    <a href="jobs.html" target="_self" title="Jobs">Jobs</a>
                    <a href="about.html" target="_self" title="About">About Us</a>
                    <a href="#start" target="_self" title="Apply">Apply</a>
                </nav>
            </main>
        </div>
    <!-- Main content of the page. This section contains the main information about the company, including its tagline, description, mission, and industry partners. -->
    
   <section>
        <h2>S.A Coders Tagline</h2>
            <p>We code with precision, passion, and purpose - delivering cutting-edge solutions and creating job opportunities for experts in Data Analytics, Project Management, and Software Development.</p>
        
        <h2>Description</h2>
            <p>At S.A Coders, we are a passionate community of developers, problem-solvers, and innovators dedicated to creating cutting-edge software solutions. Specialising in HTML, web development, and programming, we harness the power of modern technology to build user-friendly, and efficient digital experiences. We have numerous talented employees from differnet IT backgrounds, having various expertise and skills. We have been established as a company since 2006, building our company from the ground up to achieve our dream of providing reliable, efficient software solutions.</p>
    
        <h2>Our Mission</h2>
            <p>Our mission is to empower individuals and businesses through technology, providing them with the tools they need to succeed in a rapidly evovling digital landscape. We strive to foster a culture of collaboration and creativity, ensuring that our team remains at the forefront of industry trends and advancements.</p>
        
        <h2>Industry Partners</h2>
        <div class="logos"></div>
        <p>
            <a href="index.html"><img src="images/google_logo.png" alt="Google Logo" width="150" height="75"></a> &nbsp; &nbsp; &nbsp; &nbsp; <!-- Sourced from google -->
            <a href="index.html"><img src="images/microsoft_logo.png" alt="Microsoft Logo" width="150" height="75"></a> &nbsp; &nbsp; &nbsp; &nbsp; <!-- Sourced from microsoft -->
            <a href="index.html"><img src="images/amazon_logo.png" alt="Amazon Logo" width="150" height="75"></a> &nbsp; &nbsp; &nbsp; &nbsp; <!-- Sourced from amazon -->
            <a href="index.html"><img src="images/ibm_logo.png" alt="IBM Logo" width="150" height="75"></a> &nbsp; &nbsp; <!-- Sourced from ibm -->
        </p>
   </section>

    <br><br><br><br><br><br><br> <!-- Spacing for the footer-->
<hr>
<?php include 'footer.inc'; ?>
</body>   
</html>