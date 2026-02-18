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
    $StudentId=$_POST['StudentId'];

    $sql = "INSERT INTO members (name, email, phone,StudentId) VALUES ('$name','$email','$phone','$StudentId')";

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
<body class="bg-gray-100 p-8">

<nav class="bg-white shadow p-4 flex space-x-4">


<a href="search_book.php" class="text-blue-600 hover:text-gray-800">Search Book</a>
<a href="borrow_book.php" class="text-blue-600 hover:text-gray-800">Borrow Book</a>
<a href="fine_calculator.php" class="text-blue-600 hover:text-gray-800">Fine Calculator</a>
<a href="logout.php" class="text-red-600 hover:text-gray-800">Logout</a>

</nav>

<div class="bg-white p-6 rounded shadow w-96 mx-auto">
    <h2 class="text-xl font-bold mb-4">Add Member</h2>

    <form method="POST">

        <input type="text" name="name" placeholder="Full Name"
        class="w-full p-2 border mb-3" required>

        <input type="email" name="email" placeholder="Email"
        class="w-full p-2 border mb-3" required>

        <input type="text" name="phone" placeholder="Phone"
        class="w-full p-2 border mb-3" required>

        <input type="text" name="StudentId" placeholder="StudentId"
        class="w-full p-2 border mb-3" required>

        <button name="add"
        class="bg-blue-600 text-white p-2 w-full rounded mb-2">
        Add Member
</button>

<button type="button" onclick="back()"
        class="px-3 py-1.5 text-white bg-indigo-500 rounded-lg hover:bg-indigo-700 active:shadow-lg w-full mt-2">
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