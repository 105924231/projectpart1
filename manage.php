<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("settings.php");

include 'header.inc';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Sophie Kroezen & Akhila Sripriyadarshini Gollamudi">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css?v=1.2">
    <title>Manager Homepage</title>
</head>
<body>
    <div class="manage-wrapper">

        <form method="POST" class="search_form">
            <label for="search_field">Search by:</label>
            <select name="search_field" id="search_field" required>
                <option value="">Please select</option>
                <option value="JobReferenceNumber" <?= isset($_POST['search_field']) && $_POST['search_field'] === 'JobReferenceNumber' ? 'selected' : '' ?>>Reference Number</option>
                <option value="FirstName" <?= isset($_POST['search_field']) && $_POST['search_field'] === 'FirstName' ? 'selected' : '' ?>>First Name</option>
                <option value="LastName" <?= isset($_POST['search_field']) && $_POST['search_field'] === 'LastName' ? 'selected' : '' ?>>Last Name</option>
                <option value="EmailAddress" <?= isset($_POST['search_field']) && $_POST['search_field'] === 'EmailAddress' ? 'selected' : '' ?>>Email</option>
            </select>

            <input type="text" name="search_value" placeholder="Enter value..." value="<?= isset($_POST['search_value']) ? htmlspecialchars($_POST['search_value']) : '' ?>" required>

            <button type="submit" name="search">Search</button>

            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete all matching expressions of interest?')">Delete</button>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])): ?>
                <button type="button" onclick="window.location.href='manage.php'">Reset</button>
            <?php endif; ?>
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
        echo "<table class='search-table'>";

        // Table headers
        if ($is_search) {
            echo "<tr>
                <th>EOI Number</th><th>Reference No.</th><th>First Name</th><th>Surname</th>
                <th>Address</th><th>Suburb</th><th>State</th><th>Postcode</th>
                <th>Email</th><th>Phone No.</th>
                <th>Skill 1</th><th>Skill 2</th><th>Skill 3</th><th>Skill 4</th><th>Skill 5</th>
                <th>Other Skills</th>
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

    } else {
        echo "<p>No applications found.</p>";
    }
    ?>

    <div class="pagination">
        Pages:
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            $class = ($i == $page) ? "active-page" : "";
            echo "<a class='pagination-link $class' href='?page=$i'>$i</a> ";
        }
        ?>
    </div>

</div>
</body>

<?php include 'footer.inc'; ?>
</html>


