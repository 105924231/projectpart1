<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("settings.php");

?>
  <form method="POST">
    <label>What would you like to do?</label>
    <select name="querytable" id="querytable">
        <option value="" selected="selected">Please select</option>
        <option value="all">View all EOIs</option>
        <option value="position">See a particular position's EOIs</option>
        <option value="specific_applicant">Search for a specific applicant</option>
    </select>
    <input type="submit" value="Go">
    </form> 
    <form>
    <label>Choose a job reference number:</label>
    <select name="applicant" id="applicant">
        <option value="" selected="selected">Please select</option>
        <option value="data_analyst">(59242) Data Analyst</option>
        <option value="software_developer">(31972) Software Developer</option>
        <option value="it_support">(60505) IT Support</option>
    </select>
    <label>Search for an applicant:</label>
    <input type="text" name="refnum" placeholder="Search here..."required>
    <input type="submit" value="Search">
  </form>

<?php

$sql = "SELECT EOInumber, JobReferenceNumber, FirstName, LastName, StreetAddress, SuburbTown, State, Postcode, EmailAddress, PhoneNumber, Skill1, Skill2, Skill3, Skill4, Skill5, OtherSkills, Status FROM eoi";
$result = $conn->query($sql);

if($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>EOI Number</th><th>Reference No.</th><th>First Name</th><th>Surname</th><th>Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>Phone No.</th><th>Skill 1</th><th>Skill 2</th><th>Skill 3</th><th>Skill 4</th><th>Skill 5</th><th>Other skills</th><th>Application Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["EOInumber"] . "</td>";
        echo "<td>" . $row["JobReferenceNumber"] . "</td>";
        echo "<td>" . $row["FirstName"] . "</td>";
        echo "<td>" . $row["LastName"] . "</td>";
        echo "<td>" . $row["StreetAddress"] . "</td>";
        echo "<td>" . $row["SuburbTown"] . "</td>";
        echo "<td>" . $row["State"] . "</td>";
        echo "<td>" . $row["Postcode"] . "</td>";
        echo "<td>" . $row["EmailAddress"] . "</td>";
        echo "<td>" . $row["PhoneNumber"] . "</td>";
        echo "<td>" . $row["Skill1"] . "</td>";
        echo "<td>" . $row["Skill2"] . "</td>";
        echo "<td>" . $row["Skill3"] . "</td>";
        echo "<td>" . $row["Skill4"] . "</td>";
        echo "<td>" . $row["Skill5"] . "</td>";
        echo "<td>" . $row["OtherSkills"] . "</td>";
        echo "<td>" . $row["Status"] . "</td>";
        echo "</tr>";
    } 
    echo "</table>";
} else {
    echo "Query failed. <br>Error: " . $conn->error;
    if ($conn->error) {
        echo "<br>Error: " . $conn->error;
    }
}


if (isset($_POST['refnum'])) {

    $refnum = mysqli_real_escape_string($conn, $_POST['refnum']);
    $sql = "SELECT * FROM eoi WHERE JobReferenceNumber LIKE '%$refnum%'";
    $result = mysqli_query($conn, $sql);

    if($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>EOI Number</th><th>Reference No.</th><th>First Name</th><th>Surname</th><th>Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>Phone No.</th><th>Skill 1</th><th>Skill 2</th><th>Skill 3</th><th>Skill 4</th><th>Skill 5</th><th>Other skills</th><th>Application Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["EOInumber"] . "</td>";
        echo "<td>" . $row["JobReferenceNumber"] . "</td>";
        echo "<td>" . $row["FirstName"] . "</td>";
        echo "<td>" . $row["LastName"] . "</td>";
        echo "<td>" . $row["StreetAddress"] . "</td>";
        echo "<td>" . $row["SuburbTown"] . "</td>";
        echo "<td>" . $row["State"] . "</td>";
        echo "<td>" . $row["Postcode"] . "</td>";
        echo "<td>" . $row["EmailAddress"] . "</td>";
        echo "<td>" . $row["PhoneNumber"] . "</td>";
        echo "<td>" . $row["Skill1"] . "</td>";
        echo "<td>" . $row["Skill2"] . "</td>";
        echo "<td>" . $row["Skill3"] . "</td>";
        echo "<td>" . $row["Skill4"] . "</td>";
        echo "<td>" . $row["Skill5"] . "</td>";
        echo "<td>" . $row["OtherSkills"] . "</td>";
        echo "<td>" . $row["Status"] . "</td>";
        echo "</tr>";
    } 
    echo "</table>";
    } else {
        echo "All expressions of interest cleared or no matching applications found.";
    }
} 

?>


