<?php
session_start();

// Database connection settings
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

// Connect to the database
$data = mysqli_connect($host, $user, $password, $db);

// Ensure the connection is successful
if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the student details (hardcoded for this case)
$student_id = 13;  // Joe's student ID
$student_name = "Joe";  // Joe's name

// Query to fetch student results along with course name
$sql = "SELECT user.name, courses.name, student_results.marks 
        FROM student_results 
        JOIN user ON student_results.student_id = user.id 
        JOIN courses ON student_results.course_id = courses.course_id 
        WHERE student_results.student_id = '$student_id'";

// Execute the query
$result = mysqli_query($data, $sql);

// Function to calculate grade based on marks
function calculateGrade($marks) {
    if ($marks >= 70) {
        return "A";
    } elseif ($marks >= 60) {
        return "B";
    } elseif ($marks >= 50) {
        return "C";
    } elseif ($marks >= 40) {
        return "D";
    } else {
        return "F";
    }
}

// Check if results exist
if (mysqli_num_rows($result) > 0) {
    // Display student information
    echo "<h2>Results for $student_name (ID: $student_id)</h2>";
    echo "<table border='1'>
            <tr>
                <th>Course</th>
                <th>Marks</th>
                <th>Grade</th>
            </tr>";
    
    // Loop through the results
    while ($row = mysqli_fetch_assoc($result)) {
        $marks = $row['marks'];
        $grade = calculateGrade($marks);
        
        echo "<tr>
                <td>{$row['course_name']}</td>
                <td>$marks</td>
                <td>$grade</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No results found for $student_name (ID: $student_id).</p>";
}

// Close the database connection
mysqli_close($data);
?>
