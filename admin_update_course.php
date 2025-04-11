<?php

session_start();


// Ensure the user is logged in and has admin privileges
if (!isset($_SESSION['username'])) {
    header("location:login.php");
} elseif ($_SESSION['usertype'] == 'student') {
    header("location:login.php");
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

// Get the course id from the URL
$id = $_GET['course_id']; // Using 'id' instead of 'course_id'

// SQL query to get the course data
$sql = "SELECT * FROM courses WHERE id='$id'"; // Changed 'course_id' to 'id'
$result = mysqli_query($data, $sql);
$info = $result->fetch_assoc();

// Handle form submission to update course data
if (isset($_POST['update'])) {

    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];

    // SQL query to update the course information
    $query = "UPDATE courses SET code='$course_code', name='$course_name', 
              description='$course_description' WHERE id='$id'"; // Changed 'course_id' to 'id'

    $result2 = mysqli_query($data, $query);

    if ($result2) {
        $_SESSION['message'] = 'Course updated successfully';
        header("location:admin_view_courses.php");  // Redirect after successful update
    } else {
        $_SESSION['message'] = 'Error updating course: ' . mysqli_error($data);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <?php include 'admin_css.php'; ?>

    <style type="text/css">
        label {
            display: inline-block;
            width: 100px;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .div_deg {
            background-color: skyblue;
            width: 400px;
            padding-bottom: 70px;
            padding-top: 70px;
        }
    </style>
</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<div class="content">

<center>
    <h1>Update Course</h1>

    <div class="div_deg">

        <form action="#" method="POST">

            <div>
                <label>Course Code</label>
                <input type="text" name="course_code" value="<?php echo $info['code']; ?>">
            </div>

            <div>
                <label>Course Name</label>
                <input type="text" name="course_name" value="<?php echo $info['name']; ?>">
            </div>

            <div>
                <label>Description</label>
                <textarea name="course_description"><?php echo $info['description']; ?></textarea>
            </div>

            <div>
                <input class="btn btn-success" type="submit" name="update" value="Update">
            </div>

        </form>

    </div>
</center>

</div>

</body>
</html>
