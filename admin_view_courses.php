<?php
error_reporting(0);
session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
} elseif ($_SESSION['usertype'] == 'student') {
    header("location:login.php");
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject"; // Ensure this is the correct database name

$data = mysqli_connect($host, $user, $password, $db);

$sql = "SELECT * FROM courses"; // Replace "courses" with the actual table name for courses
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - View Courses</title>
    <link rel="stylesheet" href="admin.css">
    <?php include 'admin_css.php'; ?>

    <style type="text/css">
        .table-container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .message {
            color: green;
            font-weight: bold;
            margin: 20px 0;
        }

        .content h1 {
            text-align: center;
            margin-top: 50px;
        }
    </style>

</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<div class="content">
    <h1>View Courses</h1>

    <div class="table-container">
        <?php
        if ($_SESSION['message']) {
            echo "<div class='message'>{$_SESSION['message']}</div>";
        }
        unset($_SESSION['message']);
        ?>

        <table border="1px">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Course Description</th>
                     <th>Delete</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($info = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $info['name']; ?></td>
                    <td><?php echo $info['code']; ?></td>
                    <td><?php echo $info['description']; ?></td>
                    <td>
                    	<?php echo 
                        "<a OnClick=\" javascript:return confirm('Are you sure to Delete this Course?')\" class='btn btn-danger'
                           href='delete_course.php?course_id={$info['id']}'>Delete
                        </a>"; ?>
                    </td>
                    <td>
                    	<?php echo 
                        "<a class='btn btn-primary' 
                           href='admin_update_course.php?course_id={$info['id']}'>
                           Update
                        </a>"; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
