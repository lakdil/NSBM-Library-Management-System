<?php
session_start();
include("db.php");

if($_SESSION['role'] != "librarian"){
    header("Location: main.php");
    exit();
}

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $StudentId = $_POST['StudentId'];

    $sql = "INSERT INTO members (name, email, phone, StudentId) 
            VALUES ('$name','$email','$phone','$StudentId')";

    if($conn->query($sql)){
        echo "<script>alert('Member Added Successfully');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<!-- Background Image Added Here -->
<body class="bg-cover bg-center min-h-screen flex items-center justify-center"
      style="background-image: url('background.jpg');">

    <!-- Transparent Card -->
    <div class="bg-white bg-opacity-90 p-8 rounded-2xl shadow-2xl w-96">

        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">
            Add Member
        </h2>

        <form method="POST">

            <input type="text" 
                   name="name" 
                   placeholder="Full Name"
                   class="w-full p-2 border mb-3 rounded"
                   required>

            <input type="email" 
                   name="email" 
                   placeholder="Email"
                   class="w-full p-2 border mb-3 rounded"
                   required>

            <input type="text" 
                   name="phone" 
                   placeholder="Phone"
                   class="w-full p-2 border mb-3 rounded"
                   required>

            <input type="text" 
                   name="StudentId" 
                   placeholder="Student ID"
                   class="w-full p-2 border mb-4 rounded"
                   required>

            <button type="submit" 
                    name="add"
                    class="bg-blue-600 text-white p-2 w-full rounded-lg hover:bg-blue-700 transition mb-3">
                Add Member
            </button>

            <button type="button" 
                    onclick="back()"
                    class="bg-indigo-500 text-white p-2 w-full rounded-lg hover:bg-indigo-700 transition">
                Back
            </button>

        </form>
    </div>

<script>
function back(){
    window.location.href="main.php";
}
</script>

</body>
</html>