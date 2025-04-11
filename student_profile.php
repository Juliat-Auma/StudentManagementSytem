<?php

session_start();

// Check if the user is logged in and if the user type is student
if (!isset($_SESSION['username'])) {
    header("location:login.php");
} elseif ($_SESSION['usertype'] == 'admin') {
    header("location:login.php"); // Redirect admin to admin dashboard
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";
$data = mysqli_connect($host, $user, $password, $db);

// Get the logged-in student's username (use session variable if necessary)
$name = $_SESSION['username'];

// Query to fetch student info
$sql = "SELECT * FROM user WHERE username ='$name' ";
$result = mysqli_query($data, $sql);
$info = mysqli_fetch_assoc($result);

// Query to fetch the enrolled courses for the student
$sql_courses = "SELECT courses.name FROM enrollment
                JOIN courses ON enrollment.id = courses.id 
                WHERE enrollment.student_id = (SELECT id FROM user WHERE username = '$name')";

$result_courses = mysqli_query($data, $sql_courses);

if (isset($_POST['update_profile'])) {
    $s_email = $_POST['email'];
    $s_phone = $_POST['phone'];
    $s_password = $_POST['password'];

    // Update the student's profile information
    $sql2 = "UPDATE user SET email ='$s_email', phone='$s_phone', password='$s_password' WHERE username='$name' ";
    $result2 = mysqli_query($data, $sql2);

    if ($result2) {
        header('location:student_profile.php');
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Profile</title>

    <?php include 'student_css.php' ?>

    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg {
            background-color: skyblue;
            width: 500px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
        
    </style>

</head>

<body>

    <?php include 'student_sidebar.php' ?>

    <div class="content">
        <center>
            <h1>Update Profile</h1>
            <br><br>

            <div class="div_deg">

                <form action="#" method="POST">

                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo "{$info['email']}"; ?>">
                    </div>

                    <div>
                        <label>Phone</label>
                        <input type="number" name="phone" value="<?php echo "{$info['phone']}"; ?>">
                    </div>

                    <div>
                        <label>Password</label>
                        <input type="password" name="password" value="<?php echo "{$info['password']}"; ?>">
                    </div>

                    <h3>Enrolled Courses:</h3>
                    <ul>
                        <?php
                        if (mysqli_num_rows($result_courses) > 0) {
                            while ($course = mysqli_fetch_assoc($result_courses)) {
                                echo "<li>" . $course['name'] . "</li>";
                            }
                        } else {
                            echo "<li style='background-color: #003366; color: white; padding: 10px; margin: 5px 0; border-radius: 5px; font-size: 16px;'>No courses enrolled.</li>";
                        }
                        ?>
                    </ul>
                    <br><br>

                    <div>
                        <input type="submit" class="btn btn-primary" name="update_profile" value="Update">
                    </div>

                </form>

            </div>
        </center>
    </div>

</body>

</html>
