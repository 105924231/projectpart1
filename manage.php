<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("settings.php");

include 'header.inc';

//Sorting tutorial/inspiration came from the following: https://www.youtube.com/watch?v=ft-B4DFWUUc

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$allowed_fields = ['EOInumber', 'JobReferenceNumber', 'FirstName', 'LastName'];
$allowed_orders = ['ASC', 'DESC'];

$filter = "";
$sort_field = 'EOInumber'; // default sort field
$sort_order = 'ASC';       // default sort order

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search_field'], $_POST['search_value'])) {
        $field = $conn->real_escape_string($_POST['search_field']);
        $value = $conn->real_escape_string($_POST['search_value']);
        $filter = " WHERE $field LIKE '%$value%'";
    }

    if (isset($_POST['sort_field']) && in_array($_POST['sort_field'], $allowed_fields)) {
        $sort_field = $_POST['sort_field'];
    }
    if (isset($_POST['sort_order']) && in_array($_POST['sort_order'], $allowed_orders)) {
        $sort_order = $_POST['sort_order'];
    }
}

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

$count_sql = "SELECT COUNT(*) AS total FROM eoi" . $filter;
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM eoi" . $filter . " ORDER BY $sort_field $sort_order LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$is_search = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search']));

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

        <button class="manage-buttons" type="submit" name="search">Search</button>

        <button class="manage-buttons" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete all matching expressions of interest?')">Delete</button>
    </form>

    <br>

<!--The ? : parts of the following code are shorthand for if-else statements, which I learned from W3Schools.-->
    <form method="POST" class="sort_form">
        <label for="sort_field">Sort by:</label>
        <select name="sort_field" id="sort_field">
            <option value="EOInumber" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'EOInumber') ? 'selected' : '' ?>>EOI Number</option>
            <option value="JobReferenceNumber" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'JobReferenceNumber') ? 'selected' : '' ?>>Reference Number</option>
            <option value="FirstName" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'FirstName') ? 'selected' : '' ?>>First Name</option>
            <option value="LastName" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'LastName') ? 'selected' : '' ?>>Last Name</option>
        </select>

        <select name="sort_order" id="sort_order">
            <option value="ASC" <?= (isset($_POST['sort_order']) && $_POST['sort_order'] == 'ASC') ? 'selected' : '' ?>>Ascending</option>
            <option value="DESC" <?= (isset($_POST['sort_order']) && $_POST['sort_order'] == 'DESC') ? 'selected' : '' ?>>Descending</option>
        </select>

        <button class="manage-buttons" type="submit" name="sort">Sort</button>
    </form>

    <br>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table class='search-table'>";

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
                //In the option value statements, the code is checking if the row's status data is selected as either new, current or final. If it is, then it outputs that option.
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
    <!--I used the following W3Schools event page https://www.w3schools.com/jsref/event_onclick.asp to help me get my resset button to work, as I wasn't able to get it to work otherwise.-->
    <div class="reset">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])): ?>
        <button class="manage-buttons" type="button" onclick="window.location.href='manage.php'">Reset</button>
    <?php endif; ?>
    </div>

    <div class="pagination">

    <?php
    //This portion of code builds an array of the sort & search parameters, so that when the page is reloaded or the pagination feature is used, it will maintain the search information or the sort style the user wants.
    $query_params = [];
    if (isset($_POST['search_field'])) $query_params['search_field'] = $_POST['search_field'];
    if (isset($_POST['search_value'])) $query_params['search_value'] = $_POST['search_value'];
    $query_params['sort_field'] = $sort_field;
    $query_params['sort_order'] = $sort_order;

    for ($i = 1; $i <= $total_pages; $i++) {
        $class = ($i == $page) ? "active-page" : "";
        $query_params['page'] = $i;
        $qs = http_build_query($query_params);
        echo "<a class='pagination-link $class' href='manage.php?$qs'>$i</a> ";
    }
    ?>
    </div>

</div>
<?php include 'footer.inc'; ?>
</body>
</html>