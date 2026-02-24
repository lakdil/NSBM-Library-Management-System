<?php
include("db.php");

if(isset($_POST['signup'])){

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 
    $role = $_POST['role'];
    $special_password = $_POST['special_password'] ?? '';
    $student_id = $_POST['student_id'] ?? '';

    
    if(strlen($password) < 8){
        echo "<script>alert('Password must be at least 8 characters long!');</script>";
    }

    
    elseif($password !== $confirm_password){
        echo "<script>alert('Passwords do not match!');</script>";
    }

    
    elseif($role === 'librarian' && $special_password !== 'admin'){
        echo "<script>alert('Invalid special password for librarian!');</script>";
    }

    
    elseif($role === 'student' && empty($student_id)){
        echo "<script>alert('Student ID is required!');</script>";
    }

    else {

        
        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if($check->num_rows > 0){
            echo "<script>alert('Username already exists!');</script>";
        } 
        else {

            
            if($role === 'student'){
                $sql = "INSERT INTO users (username, password, role, student_id)
                        VALUES ('$username', '$password', '$role', '$student_id')";
            } else {
                $sql = "INSERT INTO users (username, password, role, student_id)
                        VALUES ('$username', '$password', '$role', NULL)";
            }

            if($conn->query($sql) === TRUE){
                echo "<script>alert('Signup Successful!'); window.location='index1.php';</script>";
            } 
            else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const specialDiv = document.getElementById('specialDiv');
            const studentDiv = document.getElementById('studentDiv');

            if(role === 'librarian'){
                specialDiv.style.display = 'block';
                studentDiv.style.display = 'none';
            } 
            else if(role === 'student'){
                specialDiv.style.display = 'none';
                studentDiv.style.display = 'block';
            } 
            else {
                specialDiv.style.display = 'none';
                studentDiv.style.display = 'none';
            }
        }
    </script>

    <style>
        body {
            background-image: url('picture.jpeg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-[#c47a1e]/70 p-8 rounded-2xl shadow-2xl w-96">
    <h2 class="text-2xl font-bold mb-4 text-center">Create Account</h2>

    <form method="POST">

        <input type="text" name="username" placeholder="Username"
        class="w-full p-2 border rounded mb-3" required>

        <input type="password" name="password" placeholder="Password (Min 8 characters)"
        class="w-full p-2 border rounded mb-3" minlength="8" required>

        <input type="password" name="confirm_password" placeholder="Confirm Password"
        class="w-full p-2 border rounded mb-3" minlength="8" required>

        <select name="role" id="role"
        class="w-full p-2 border rounded mb-3"
        onchange="toggleFields()" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="librarian">Librarian</option>
        </select>

        
        <div id="studentDiv" style="display:none;">
            <input type="text" name="student_id"
            placeholder="Enter Student ID"
            class="w-full p-2 border rounded mb-3">
        </div>

        
        <div id="specialDiv" style="display:none;">
            <input type="password" name="special_password"
            placeholder="Enter Special Password"
            class="w-full p-2 border rounded mb-3">
        </div>

        <button type="submit" name="signup"
        class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
        Sign Up
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="index1.php" class="text-blue-500">Back to Login</a>
    </div>
</div>

</body>
</html>