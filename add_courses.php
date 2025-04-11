<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if (isset($_POST['add_course'])) {
    // Get and sanitize form inputs
    $code = trim($_POST['course_code']);
    $name = trim($_POST['course_name']);
    $description = trim($_POST['course_description']);

    // Check if course already exists
    $check = "SELECT * FROM courses WHERE code = '$code'";
    $result = mysqli_query($data, $check);
    $row_count = mysqli_num_rows($result);

    if ($row_count > 0) {
        echo "<script>alert('Course already exists');</script>";
    } else {
        $insert = "INSERT INTO courses (code, name, description) 
                   VALUES ('$code', '$name', '$description')";

        $query = mysqli_query($data, $insert);

        if ($query) {
            echo "<script>alert('Course added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add course');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link rel="stylesheet" type="text/css" href="admin.css">

    <style>
        label {
            display: inline-block;
            width: 140px;
            padding: 10px;
        }

        .form-box {
            background-color: skyblue;
            width: 450px;
            padding: 30px;
            border-radius: 10px;
        }
    </style>

    <?php include 'admin_css.php'; ?>
</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<div class="content">
    <center>
        <h1>Add New Course</h1>
        <div class="form-box">
            <form method="POST" action="#">
                <div>
                    <label>Course Code</label>
                    <input type="text" name="course_code" required>
                </div>
                <div>
                    <label>Course Name</label>
                    <input type="text" name="course_name" required>
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="course_description"></textarea>
                </div>
                <div>
                    <input type="submit" name="add_course" class="btn btn-primary" value="Add Course">
                </div>
            </form>
        </div>
    </center>
</div>

</body>
</html>
