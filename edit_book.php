<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$librarian_password = "admin";

if(isset($_POST['delete'])){

    $book_name = $_POST['book_name'];
    $password = $_POST['password'];

    if($password != $librarian_password){
        echo "<script>alert('Wrong Librarian Password ❌');</script>";
    } else {

        $conn->query("DELETE FROM novelbooks WHERE book_name='$book_name'");
        $conn->query("DELETE FROM educationbooks WHERE book_name='$book_name'");
        $conn->query("DELETE FROM litbooks WHERE book_name='$book_name'");

        echo "<script>alert('Book Deleted Successfully ✅');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Delete Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="bg-white p-6 rounded shadow w-96 mx-auto">

<h2 class="text-xl font-bold mb-4 text-center text-red-600">
Delete Book
</h2>

<form method="POST">

    <input type="text" 
           name="book_name"
           placeholder="Enter Book Name"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="password" 
           name="password"
           placeholder="Librarian Password"
           class="w-full p-2 border mb-3 rounded"
           required>

    <button type="submit" 
            name="delete"
            class="bg-red-600 text-white p-2 w-full rounded hover:bg-red-700">
        Delete Book
    </button>

    <button type="button"
    onclick="window.location='main.php'"
    class="mt-4 bg-indigo-500 text-white p-2 w-full rounded">
    Back
    </button>

</form>

</div>

</body>
</html>
