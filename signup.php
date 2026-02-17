<?php
include("db.php");

if(isset($_POST['signup'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $special_password = $_POST['special_password'] ?? '';

    
    if($role === 'librarian' && $special_password !== 'admin'){
        echo "<script>alert('Invalid special password for librarian!');</script>";
    } else {

        
        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if($check->num_rows > 0){
            echo "<script>alert('Username already exists!');</script>";
        } else {
            $sql = "INSERT INTO users (username, password, role)
                    VALUES ('$username', '$password', '$role')";
            if($conn->query($sql) === TRUE){
                echo "<script>alert('Signup Successful!'); window.location='index.php';</script>";
            } else {
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
        function toggleSpecialPassword() {
            const role = document.getElementById('role').value;
            const specialDiv = document.getElementById('specialDiv');
            if(role === 'librarian') {
                specialDiv.style.display = 'block';
            } else {
                specialDiv.style.display = 'none';
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
body {
    background-image: url('picture.jpeg'); 
    background-size:cover;     
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

        <input type="password" name="password" placeholder="Password"
        class="w-full p-2 border rounded mb-3" required>

        
        <select name="role" id="role" class="w-full p-2 border rounded mb-3" onchange="toggleSpecialPassword()" required>
            <option value="student">Student</option>
            <option value="librarian">Librarian</option>
        </select>

        
        <div id="specialDiv" style="display:none;">
            <input type="password" name="special_password" placeholder="Enter special password"
            class="w-full p-2 border rounded mb-3">
        </div>

        <button type="submit" name="signup"
        class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
        Sign Up
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="index.php" class="text-blue-500">Back to Login</a>
    </div>
</div>

</body>
</html>