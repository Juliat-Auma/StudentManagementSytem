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

// Fetch courses for the dropdown
$course_result = mysqli_query($data, "SELECT * FROM courses");

if (isset($_POST['add_unit'])) {
    // Get and sanitize form inputs
    $unit_name = trim($_POST['unit_name']);

    // Check if the unit already exists under the same course
    $check = "SELECT * FROM units WHERE unit_name = '$unit_name'";
    $result = mysqli_query($data, $check);
    $row_count = mysqli_num_rows($result);

    if ($row_count > 0) {
        echo "<script>alert('Unit already exists for the selected course');</script>";
    } else {
        $insert = "INSERT INTO units (unit_name) 
                   VALUES ('$unit_name')";

        $query = mysqli_query($data, $insert);

        if ($query) {
            echo "<script>alert('Unit added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add unit');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Unit</title>
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
        <h1>Add New Unit</h1>
        <div class="form-box">
            <form method="POST" action="#">
                <div>
                    <label>Unit Name</label>
                    <input type="text" name="unit_name" required>
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="unit_description"></textarea>
                </div>
                <div>
                    <label>Select Course</label>
                    <select name="course_id" required>
                        <option value="">-- Select Course --</option>
                        <?php
                        while ($course = mysqli_fetch_assoc($course_result)) {
                            echo "<option value='{$course['name']}'>{$course['id']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <input type="submit" name="add_unit" class="btn btn-primary" value="Add Unit">
                </div>
            </form>
        </div>
    </center>
</div>

</body>
</html>
