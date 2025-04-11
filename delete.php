<?php

session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

// Check if 'id' parameter is passed in the URL
if ($_GET['id']) {

    $course_id = $_GET['id'];  // Using 'id' to get the course ID from the URL

    // SQL query to delete the course from the 'courses' table using the course id
    $sql = "DELETE FROM courses WHERE id = '$course_id'";  // Assuming the table is named 'courses'

    $result = mysqli_query($data, $sql);

    if ($result) {
        // Set a success message in the session and redirect to the view courses page
        $_SESSION['message'] = 'Course deleted successfully';
        header("location:view_courses.php");  // Redirect to the courses list page after deletion
    } else {
        // Set an error message in case the query fails
        $_SESSION['message'] = 'Error deleting course: ' . mysqli_error($data);
    }
}

?>
