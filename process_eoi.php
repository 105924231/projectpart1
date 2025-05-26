<?php
/*-------
 *  process_eoi.php   –  handles the Application (EOI) submission
 *  Works with the form in apply.php
--------*/

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();         

require_once("settings.php");
include 'header.inc';

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
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/*-------
  3. Create EOI table if it doesn’t exist
--------*/
$createTableSQL = "
CREATE TABLE IF NOT EXISTS eoi (
    EOInumber      INT AUTO_INCREMENT PRIMARY KEY,
    jobreferencenumber      VARCHAR(20),
    firstname      VARCHAR(20),
    lastname       VARCHAR(20),
    streetaddress        VARCHAR(40),
    suburbtown         VARCHAR(40),
    state          CHAR(3),
    postcode       CHAR(4),
    emailaddress          VARCHAR(100),
    phonenumber       VARCHAR(15),
    skill1         VARCHAR(50),
    skill2         VARCHAR(50),
    skill3         VARCHAR(50),
    skill4         VARCHAR(50),
    skill5         VARCHAR(50),
    otherskills    TEXT,
    status         ENUM('new','current','final') NOT NULL DEFAULT 'new',
    lodged         TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
$conn->query($createTableSQL);

/*-------
  4. Helper – clean & escape
--------*/
function clean($str, $conn) {
    if (!is_string($str)) {
        $str = '';
    }
    return htmlspecialchars(trim($conn->real_escape_string($str)));
}


/*-------
  5. Collect, sanitise & validate input
--------*/
$errors = [];

// Job reference (required, simple digits check)
$jobrefnum = clean($_POST['jobrefnum'] ?? '', $conn);
if (!preg_match('/^\d{5}$/', $jobrefnum)) {
    $errors[] = 'Job reference must be a 5-digit number.';
}

// First name (required)
$firstname = clean($_POST['firstname'] ?? '', $conn);
if (!preg_match('/^[A-Za-z]{1,20}$/', $firstname)) {
    $errors[] = 'First name must be alphabetic and ≤ 20 chars.';
}

// Middle name (optional) - you can store or ignore as needed (not in table)
$middlename = clean($_POST['middlename'] ?? '', $conn);
if ($middlename !== '' && !preg_match('/^[A-Za-z]{1,20}$/', $middlename)) {
    $errors[] = 'Middle name must be alphabetic and ≤ 20 chars.';
}

// Last name (required)
$lastname = clean($_POST['lastname'] ?? '', $conn);
if (!preg_match('/^[A-Za-z]{1,20}$/', $lastname)) {
    $errors[] = 'Last name must be alphabetic and ≤ 20 chars.';
}

// Date of birth (optional, dd/mm/yyyy) - not stored in table here
$dobRaw = $_POST['dob'] ?? '';
if ($dobRaw !== '') {
    if (!preg_match('#^\d{1,2}/\d{1,2}/\d{4}$#', $dobRaw)) {
        $errors[] = 'Date of Birth must be dd/mm/yyyy.';
    } else {
        [$d, $m, $y] = explode('/', $dobRaw);
        if (!checkdate($m, $d, $y)) {
            $errors[] = 'Date of Birth is not a valid calendar date.';
        }
        // Not storing dobSQL as not in table
    }
}

// Gender (required) - not stored in table, but you can add if needed
$gender = clean($_POST['gender'] ?? '', $conn);
if (!in_array($gender, ['male', 'female'])) {
    $errors[] = 'Please select a gender.';
}

// Address + suburb (required)
$streetaddress = clean($_POST['address'] ?? '', $conn);
$suburbtown  = clean($_POST['suburb'] ?? '', $conn);
if ($streetaddress === '' || $suburbtown === '') {
    $errors[] = 'Street address and suburb are required.';
}

// State (required – matches select list values)
$state = clean($_POST['state'] ?? '', $conn);
$validStates = ['vic', 'nsw', 'qld', 'wa', 'sa', 'nt', 'tas', 'act'];
if (!in_array($state, $validStates)) {
    $errors[] = 'Please choose a valid state.';
}

// Postcode (required, 4 digits)
$postcode = clean($_POST['postcode'] ?? '', $conn);
if (!preg_match('/^\d{4}$/', $postcode)) {
    $errors[] = 'Postcode must be 4 digits.';
}

// Email (required, RFC-valid)
$emailaddress = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
if ($emailaddress === false) {
    $errors[] = 'Invalid email format.';
}

// Phone (required, 1234-567-890)
$phonenum = trim($_POST['phonenum'] ?? '');
$phonenum = clean($phonenum, $conn);

if (!preg_match("/^\d{4}-\d{3}-\d{3}$/", $phonenum)) {
    $errors[] = 'Phone number must be in format 1234-567-890.';
}

// Preferred contact (required) - not stored in table, can be stored if needed
$contact = clean($_POST['contact'] ?? '', $conn);
if (!in_array($contact, ['email', 'phone'])) {
    $errors[] = 'Select a preferred contact method.';
}

// Skills (checkbox array) - split into 5 skill columns
$skillsArr = $_POST['lang'] ?? [];

$skill1 = clean($skillsArr[0] ?? null, $conn);
$skill2 = clean($skillsArr[1] ?? null, $conn);
$skill3 = clean($skillsArr[2] ?? null, $conn);
$skill4 = clean($skillsArr[3] ?? null, $conn);
$skill5 = clean($skillsArr[4] ?? null, $conn);

// Other skills + experience
$otherskills = clean($_POST['skills'] ?? '', $conn);

// Status default
$status = 'new';

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
$stmt = $conn->prepare("
    INSERT INTO eoi
    (jobreferencenumber, firstname, lastname, streetaddress, suburbtown, state, postcode, emailaddress, phonenumber, skill1, skill2, skill3, skill4, skill5, otherskills, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    'ssssssssssssssss',
    $jobrefnum, $firstname, $lastname,
    $streetaddress, $suburbtown, $state, $postcode,
    $emailaddress, $phonenum,
    $skill1, $skill2, $skill3, $skill4, $skill5,
    $otherskills, $status
);

if (!$stmt->execute()) {
    die('Database insert failed: ' . $stmt->error);
}

$EOInumber = $stmt->insert_id;
$stmt->close();
$conn->close();

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
<body class="processed-form">
    <h1>Thank you for your application!</h1>
    <p>Your Expression of Interest has been received successfully.</p>
    <p><strong>Your EOI Number:</strong> <?php echo $EOInumber; ?></p>
    <p>Keep this number for your records – we’ll use it if we need to contact you.</p>
    <p><a href="apply.php">Submit another application</a></p>
</body>
</html>
<?php
include 'footer.inc';
?>