<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

// Check if course_id is passed in the URL
if (isset($_GET['course_id'])) {

    $courses_id = $_GET['course_id'];  // Get the course_id from URL

    // SQL query to delete the course
    $sql = "DELETE FROM courses WHERE id = '$courses_id'";

    // Execute the query
    $result = mysqli_query($data, $sql);

    // Check if the query was successful
    if ($result) {
        $_SESSION['message'] = 'Course deletion was successful.';
        header("Location: admin_view_courses.php");  // Redirect back to the courses page
    } else {
        $_SESSION['message'] = 'Error deleting course: ' . mysqli_error($data);
        header("Location: admin_view_courses.php");  // Redirect back even if there was an error
    }
    
} else {
    // If course_id is not set, show an error message
    $_SESSION['message'] = 'No course selected for deletion.';
    header("Location: view_courses.php");
}

?>
