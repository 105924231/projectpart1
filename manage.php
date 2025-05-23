<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("settings.php"); // assumes $conn is your mysqli connection
?>

<form method="POST">
    <label for="search_field">Search by:</label>
    <select name="search_field" id="search_field" required>
        <option value="">Please select</option>
        <option value="JobReferenceNumber">Reference Number</option>
        <option value="FirstName">First Name</option>
        <option value="LastName">Last Name</option>
        <option value="EmailAddress">Email</option>
    </select>

    <input type="text" name="search_value" placeholder="Enter value..." required>
    <button type="submit" name="search">Search</button>
    <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete all matching expressions of interest?')">Delete</button>
</form>

<br>

<?php
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$filter = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_field']) && isset($_POST['search_value'])) {
    $field = $conn->real_escape_string($_POST['search_field']);
    $value = $conn->real_escape_string($_POST['search_value']);
    $filter = " WHERE $field LIKE '%$value%'";
}

// COUNT total rows for pagination
$count_sql = "SELECT COUNT(*) AS total FROM eoi" . $filter;
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// UPDATE status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $eoi_number = intval($_POST['eoi_number']);
    $new_status = $conn->real_escape_string($_POST['new_status']);

    $update_sql = "UPDATE eoi SET Status = '$new_status' WHERE EOInumber = $eoi_number";
    if ($conn->query($update_sql) === TRUE) {
        echo "<p>Status updated successfully.</p>";
    } else {
        echo "<p>Error updating status: " . $conn->error . "</p>";
    }
}

// DELETE matching EOIs
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $field = $conn->real_escape_string($_POST['search_field']);
    $value = $conn->real_escape_string($_POST['search_value']);
    $delete_sql = "DELETE FROM eoi WHERE $field LIKE '%$value%'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p>All EOIs matching '$value' in '$field' have been deleted.</p>";
    } else {
        echo "<p>Error deleting records: " . $conn->error . "</p>";
    }
}

// Build main SELECT query
$sql = "SELECT * FROM eoi" . $filter . " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$is_search = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search']));

if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    
    // Table headers
    if ($is_search) {
        echo "<tr>
            <th>EOI Number</th><th>Reference No.</th><th>First Name</th><th>Surname</th>
            <th>Address</th><th>Suburb</th><th>State</th><th>Postcode</th>
            <th>Email</th><th>Phone No.</th>
            <th>Skill 1</th><th>Skill 2</th><th>Skill 3</th><th>Skill 4</th><th>Skill 5</th>
            <th>Other Skills</th><th>Application Status</th>
        </tr>";
    } else {
        echo "<tr>
            <th>EOI Number</th><th>Reference No.</th><th>First Name</th><th>Surname</th><th>Application Status</th><th>Update Status</th>
        </tr>";
    }

    // Table rows
    while ($row = $result->fetch_assoc()) {
        if ($is_search) {
            echo "<tr>
                <td>{$row['EOInumber']}</td>
                <td>{$row['JobReferenceNumber']}</td>
                <td>{$row['FirstName']}</td>
                <td>{$row['LastName']}</td>
                <td>{$row['StreetAddress']}</td>
                <td>{$row['SuburbTown']}</td>
                <td>{$row['State']}</td>
                <td>{$row['Postcode']}</td>
                <td>{$row['EmailAddress']}</td>
                <td>{$row['PhoneNumber']}</td>
                <td>{$row['Skill1']}</td>
                <td>{$row['Skill2']}</td>
                <td>{$row['Skill3']}</td>
                <td>{$row['Skill4']}</td>
                <td>{$row['Skill5']}</td>
                <td>{$row['OtherSkills']}</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='eoi_number' value='{$row['EOInumber']}'>
                        <select name='new_status'>
                            <option value='new' " . ($row['Status'] == 'new' ? 'selected' : '') . ">new</option>
                            <option value='current' " . ($row['Status'] == 'current' ? 'selected' : '') . ">current</option>
                            <option value='final' " . ($row['Status'] == 'final' ? 'selected' : '') . ">final</option>
                        </select>
                        <button type='submit' name='update_status'>Update</button>
                    </form>
                </td>
            </tr>";
        } else {
            echo "<tr>
                <td>{$row['EOInumber']}</td>
                <td>{$row['JobReferenceNumber']}</td>
                <td>{$row['FirstName']}</td>
                <td>{$row['LastName']}</td>
                <td>{$row['Status']}</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='eoi_number' value='{$row['EOInumber']}'>
                        <select name='new_status'>
                            <option value='new' " . ($row['Status'] == 'new' ? 'selected' : '') . ">new</option>
                            <option value='current' " . ($row['Status'] == 'current' ? 'selected' : '') . ">current</option>
                            <option value='final' " . ($row['Status'] == 'final' ? 'selected' : '') . ">final</option>
                        </select>
                        <button type='submit' name='update_status'>Update</button>
                    </form>
                </td>
            </tr>";
        }
    }

    echo "</table>";
    
    if (!$is_search) {
        echo "Pages: ";
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                $active = "style='font-weight:bold;'";
            } else {
    $active = "";
}

            echo "<a href='?page=$i' $active>$i</a> ";
        }
        echo "</div>";
    }

} else {
    echo "<p>No applications found.</p>";
}
?>

