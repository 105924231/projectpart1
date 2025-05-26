<?php
 include 'header.inc';
?>
<html>
    <div class="enhancements-container">
        <h1>Enhancements</h1>
        <p>For this project, we worked on a few of the suggested enhancements as well as added an additional one that was not listed. We also worked on improving our program based on Project Part 1 Feedback we received. The enhancements we did were:</p>
        <ul>
            <li>Creating a login page</li>
            <ul>
                <li>We created a login page that redirects users to manage.php</li>
            </ul>
            <li>Restricting access to manage.php</li>
            <ul>
                <li>Tying into creating a login page, we created a system that locks a user out for five minutes if they fail to login after three attempts.</li>
            </ul>
            <li>Pagination</li>
            <ul>
                <li>We added pagination, i.e the manage.php page now limits how many table results appear on the screen at a time. If there are more than 10 entries in the database table, the option to move on to a new page appears that users can click to see more of the data.</li>
            </ul>
            <li>Sorting table information</li>
            <ul>
                <li>The final enhancement we worked on was the ability to sort the table data. Users have the option to select how they want to sort the data in the table, and then furthermore if they would like it ascending or descending.</li>
            </ul>
        </ul>
    </div>
</html>
<?php
 include 'footer.inc';
?>