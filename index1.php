<?php
session_start();
include("db.php");

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: main.php");
    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Library Login</title>


<script src="https://cdn.tailwindcss.com"></script>
<style>
body {
    background-image: url('library.webp'); 
    background-size: cover;    
    background-repeat: no-repeat;
    background-position: center;
}
</style>


</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-4 text-center">Library Login</h2>

    <form method="POST">

        <input type="text" name="username" placeholder="Username"
        class="w-full p-2 border rounded mb-3" required>

        <input type="password" name="password" placeholder="Password"
        class="w-full p-2 border rounded mb-3" required>

       
        <select name="role" class="w-full p-2 border rounded mb-3">
            <option value="librarian">Librarian</option>
            <option value="student">Student</option>
        </select>

        <button type="submit" name="login"
        class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
        Login
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="signup.php" class="text-blue-500">Sign Up</a>
    </div>
</div>

</body>
</html>
