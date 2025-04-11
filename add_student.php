<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
} elseif ($_SESSION['usertype'] == 'student') {
    header("location:login.php");
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if (isset($_POST['add_student'])) {

    $username = $_POST['name'];
    $user_email = $_POST['email'];
    $user_phone = $_POST['phone'];
    $user_password = $_POST['password'];
    $usertype = "student";
    $selected_courses = $_POST['courses']; // Get selected course(s) from the dropdown

    // Check if username exists
    $check = "SELECT * FROM user WHERE username = '$username'";
    $check_user = mysqli_query($data, $check);
    $row_count = mysqli_num_rows($check_user);

    if ($row_count == 1) {
        echo "<script type='text/javascript'>
            alert ('Username exists. Try another name');
        </script>";
    } else {
        // Insert student into the `user` table
        $sql = "INSERT INTO user (username, email, phone, usertype, password) VALUES ('$username', '$user_email', '$user_phone', '$usertype', '$user_password')";
        $result = mysqli_query($data, $sql);

        if ($result) {
            $student_id = mysqli_insert_id($data); // Get the ID of the newly added student
            
            // Insert the selected courses into the `enrollments` table
            if (!empty($selected_courses)) {
                foreach ($selected_courses as $course_id) {
                    $enrollment_sql = "INSERT INTO enrollment (student_id,id) VALUES ('$student_id', '$course_id')";
                    mysqli_query($data, $enrollment_sql);
                }
            }

            echo "<script type='text/javascript'>
                alert ('Student added and enrolled successfully');
            </script>";
        } else {
            echo "<script type='text/javascript'>
                alert ('Data Upload Failed');
            </script>";
        }
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

    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg {
            background-color: skyblue; /* Restored skyblue background */
            width: 400px;
            padding-top: 70px;
            padding-bottom: 70px;
            border-radius: 10px; /* Optional: For rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add a light shadow to make it stand out */
        }

        body {
            background-color: #f7f7f7; /* Change the page background to a lighter color */
        }

        .content {
            margin: 0 auto;
            width: 80%;
            padding-top: 50px;
        }

        .btn {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Hide dropdown by default */
        .dropdown-container {
            display: none;
        }
    </style>

    <?php include 'admin_css.php'; ?>
</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<div class="content">
    <center>
        <h1>Add Student</h1>

        <div class="div_deg">

            <form action="#" method="POST">

                <div>
                    <label>Username</label>
                    <input type="text" name="name" required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div>
                    <label>Phone</label>
                    <input type="number" name="phone" required>
                </div>

                <div>
                    <label>Password</label>
                    <input type="text" name="password" required>
                </div>

                <div>
                    <label>Courses</label><br>
                    <!-- The dropdown will be shown after courses are loaded -->
                    <div class="dropdown-container">
                        <select name="courses[]" id="courses" multiple required>
                            <?php
                            // Fetch all courses from the database
                            $course_query = "SELECT * FROM courses";
                            $course_result = mysqli_query($data, $course_query);
                            while ($course = mysqli_fetch_assoc($course_result)) {
                                echo '<option value="' . $course['id'] . '">' . $course['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <small>Select one or more courses</small>
                </div>

                <div>
                    <input type="submit" class="btn btn-primary" name="add_student" value="Add Student">
                </div>

            </form>

        </div>

    </center>
</div>

<script type="text/javascript">
    // Function to display the dropdown once courses are loaded
    window.onload = function() {
        var dropdownContainer = document.querySelector('.dropdown-container');
        dropdownContainer.style.display = 'block'; // Show dropdown
    };
</script>

</body>
</html>
