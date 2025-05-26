<?php
/*-------
 *  process_eoi.php   –  handles the Application (EOI) submission
 *  Works with the form in apply.php
--------*/

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();           

/*-------
  1. Ensure this page is reached via POST
--------*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: apply.php');
    exit();
}
/*-------
  2. Connect to MySQL
--------*/
$mysqli = new mysqli('localhost', 'root', '', 'job_descriptions');
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

/*-------
  3. Create EOI table if it doesn’t exist
--------*/
$createTableSQL = "
CREATE TABLE IF NOT EXISTS eoi (
    EOInumber      INT AUTO_INCREMENT PRIMARY KEY,
    jobrefnum      VARCHAR(20),
    firstname      VARCHAR(20),
    middlename     VARCHAR(20),
    lastname       VARCHAR(20),
    dob            DATE,
    gender         VARCHAR(10),
    address        VARCHAR(40),
    suburb         VARCHAR(40),
    state          CHAR(3),
    postcode       CHAR(4),
    email          VARCHAR(100),
    phonenum       VARCHAR(15),
    contact        VARCHAR(5),
    skills         TEXT,
    otherskills    TEXT,
    experience     TEXT,
    lodged         TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
$mysqli->query($createTableSQL);

/*-------
  4. Helper – clean & escape
--------*/
function clean($str, $mysqli)
{
    return htmlspecialchars(trim($mysqli->real_escape_string($str)));
}

/*-------
  5. Collect, sanitise & validate input
--------*/
$errors = [];

// Job reference (required, simple digits check)
$jobrefnum = clean($_POST['jobrefnum'] ?? '', $mysqli);
if (!preg_match('/^\d{5}$/', $jobrefnum)) {
    $errors[] = 'Job reference must be a 5-digit number.';
}

// First name (required)
$firstname = clean($_POST['firstname'] ?? '', $mysqli);
if (!preg_match('/^[A-Za-z]{1,20}$/', $firstname)) {
    $errors[] = 'First name must be alphabetic and ≤ 20 chars.';
}

// Middle name (optional)
$middlename = clean($_POST['middlename'] ?? '', $mysqli);
if ($middlename !== '' && !preg_match('/^[A-Za-z]{1,20}$/', $middlename)) {
    $errors[] = 'Middle name must be alphabetic and ≤ 20 chars.';
}

// Last name (required)
$lastname = clean($_POST['lastname'] ?? '', $mysqli);
if (!preg_match('/^[A-Za-z]{1,20}$/', $lastname)) {
    $errors[] = 'Last name must be alphabetic and ≤ 20 chars.';
}

// Date of birth (optional, dd/mm/yyyy)
$dobRaw = $_POST['dob'] ?? '';
$dobSQL = null;
if ($dobRaw !== '') {
    if (!preg_match('#^\d{1,2}/\d{1,2}/\d{4}$#', $dobRaw)) {
        $errors[] = 'Date of Birth must be dd/mm/yyyy.';
    } else {
        [$d, $m, $y] = explode('/', $dobRaw);
        if (!checkdate($m, $d, $y)) {
            $errors[] = 'Date of Birth is not a valid calendar date.';
        } else {
            $dobSQL = sprintf('%04d-%02d-%02d', $y, $m, $d); // to MySQL DATE
        }
    }
}

// Gender (required)
$gender = clean($_POST['gender'] ?? '', $mysqli);
if (!in_array($gender, ['male', 'female'])) {
    $errors[] = 'Please select a gender.';
}

// Address + suburb (required)
$address = clean($_POST['address'] ?? '', $mysqli);
$suburb  = clean($_POST['suburb'] ?? '', $mysqli);
if ($address === '' || $suburb === '') {
    $errors[] = 'Street address and suburb are required.';
}

// State (required – matches select list values)
$state = clean($_POST['state'] ?? '', $mysqli);
$validStates = ['vic', 'nsw', 'qld', 'wa', 'sa', 'nt', 'tas', 'act'];
if (!in_array($state, $validStates)) {
    $errors[] = 'Please choose a valid state.';
}

// Postcode (required, 4 digits)
$postcode = clean($_POST['postcode'] ?? '', $mysqli);
if (!preg_match('/^\d{4}$/', $postcode)) {
    $errors[] = 'Postcode must be 4 digits.';
}

// Email (required, RFC-valid)
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
if ($email === false) {
    $errors[] = 'Invalid email format.';
}

// Phone (required, 1234-567-890)
$phonenum = clean($_POST['phonenum'] ?? '', $mysqli);
if (!preg_match('/^\d{4}-\d{3}-\d{3}$/', $phonenum)) {
    $errors[] = 'Phone number must be 1234-567-890.';
}

// Preferred contact (required)
$contact = clean($_POST['contact'] ?? '', $mysqli);
if (!in_array($contact, ['email', 'phone'])) {
    $errors[] = 'Select a preferred contact method.';
}

// Skills (checkbox array)
$skillsArr = $_POST['lang'] ?? [];
$skills    = clean(implode(', ', $skillsArr), $mysqli);

// Other skills + experience
$otherskills = clean($_POST['skills'] ?? '', $mysqli);
$experience  = clean($_POST['experience'] ?? '', $mysqli);

/*-------
  6. If errors, display message
-------*/
if (!empty($errors)) {
    echo "<h2>Submission Error</h2><ul>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul><p><a href='apply.php'>&larr; Go back and fix the form</a></p>";
    exit();
}

/*-------
  7. Insert record using prepared statement
-------*/
$stmt = $mysqli->prepare("
    INSERT INTO eoi
    (jobrefnum, firstname, middlename, lastname, dob, gender, address, suburb,
     state, postcode, email, phonenum, contact, skills, otherskills, experience)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");
$stmt->bind_param(
    'ssssssssssssssss',
    $jobrefnum, $firstname, $middlename, $lastname, $dobSQL,
    $gender, $address, $suburb, $state, $postcode,
    $email, $phonenum, $contact, $skills, $otherskills, $experience
);

if (!$stmt->execute()) {
    die('Database insert failed: ' . $stmt->error);
}

$EOInumber = $stmt->insert_id;
$stmt->close();
$mysqli->close();

/*-------
  8. Confirmation page
-------*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EOI Confirmation</title>
</head>
<body>
    <h1>Thank you for your application!</h1>
    <p>Your Expression of Interest has been received successfully.</p>
    <p><strong>Your EOI Number:</strong> <?php echo $EOInumber; ?></p>
    <p>Keep this number for your records – we’ll use it if we need to contact you.</p>
    <p><a href="apply.php">Submit another application</a></p>
</body>
</html>