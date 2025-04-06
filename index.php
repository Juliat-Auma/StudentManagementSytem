
<?php

error_reporting(0);

session_start();

session_destroy();

if ($_SESSION['message']) {

$message = $_SESSION['message'];

echo "<script type='text/javascript'>

alert('$message');

 </script>";

}

$host = "localhost";

$user = "root";

$password = "";

$db = "schoolproject";

$data = mysqli_connect($host,$user,$password,$db);

$sql = "SELECT * FROM teacher";

$result = mysqli_query($data,$sql);



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STUDENT EXAMINATION RESULTS MANAGEMENT SYSTEM</title>

    <link rel="stylesheet" type="text/css" href="style.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
<body>
<nav>

<label class="logo">MMU - School</label>

<ul>
    
    <li><a href="">Home</a></li>

    <li><a href="">Contact</a></li>

    <li><a href="">Admission</a></li>

    <li><a href="login.php" class="btn btn-primary">Login</a></li>

</ul>

</nav>
<div class="section1">

    <label class="img_text">Riding On Technology</label>
    <img class=main_img src="desks.PNG">
    
</div>

<center>
    
    <div>
        <h1>Our Teachers</h1>

        <div class="container">
            
            <div class="row">

                <?php

                while($info=$result->fetch_assoc())
                    
                    {

                ?>
                
                <div class="col-md-4">

                    <img class="teacher" src="<?php echo "{$info['image']}"  ?>">

                    <h3><?php echo "{$info['name']}"  ?></h3>

                    <h5><?php echo "{$info['description']}"  ?></h5>


                </div>

                <?php

            }

            ?>

            </div>

        </div>

    </div>

</center>

<center>
    <h1 class="adm">Admission Form</h1>
</center>
<div align="center" class="admission_form" >

    <form action="data_check.php" method="POST">
        <div class="adm_int">
            <label class="label_text">Name</label>
           <input class="input_deg" type="" name="name" placeholder="Enter your Name">

        </div>

        <div class="adm_int">
            <label class="label_text">Email</label>
            <input class="input_deg" type="" name="email" placeholder="Enter your Email">
        </div>

        <div class="adm_int">
            <label class="label_text">Phone</label>
            <input class="input_deg" type="" name="phone" placeholder="Enter your Phone Number">

        </div>

        <div class="adm_int">
            <label class="label_text">Message</label>
            <textarea class="input_txt" name="message" placeholder="Type here"></textarea>
        </div>

        <div class="adm_int">
            <input class="btn btn-primary"  id= "submit" type="submit" value="Apply" name="apply">
        </div>


    </form>
    
</div>

<footer>
    
    <h3 class="footer_txt">All @Copyright Reserved by Web Technology</h3>
</footer>

</body>
</html>