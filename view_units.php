<?php
session_start();


// Check if the student is logged in
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'student') {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

// Fetch all courses
$sql_courses = "SELECT * FROM courses";
$result_courses = mysqli_query($data, $sql_courses);

if (isset($_POST['select_course'])) {
    $course_id = $_POST['course_id']; // Get the selected course ID
    
    // Fetch units for the selected course
    $sql_units = "SELECT * FROM units WHERE course_id = '$course_id'";
    $result_units = mysqli_query($data, $sql_units);
    
    $num_units = mysqli_num_rows($result_units);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Units</title>
        <?php include 'student_css.php' ?>

    <link rel="stylesheet" type="text/css" href="student.css">

</head>
<body>
    <?php include 'student_sidebar.php' ?>

    <div class="content">
        <h1>View Units</h1>
        
        <!-- Form to select course -->
        <form method="POST" action="">
            <label for="course_id">Select Course:</label>
            <select name="course_id" id="course_id">
                <?php while ($row_course = mysqli_fetch_assoc($result_courses)): ?>
                    <option value="<?php echo $row_course['id']; ?>"><?php echo $row_course['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="submit" name="select_course" value="View Units">
        </form>

        <?php if (isset($num_units)): ?>
            <?php if ($num_units > 0): ?>
                <h2>Units for the selected course:</h2>
                <ul>
                    <?php while ($row_unit = mysqli_fetch_assoc($result_units)): ?>
                        <li>
                            <strong>Unit Name:</strong> <?php echo $row_unit['unit_name']; ?><br>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No units found for the selected course.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
