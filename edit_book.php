<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$librarian_password = "admin123";

if(isset($_POST['update'])){

    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];
    $password = $_POST['password'];

    if($password != $librarian_password){
        echo "<script>alert('Wrong Librarian Password ❌');</script>";
    } else {

       
        $conn->query("UPDATE novelbooks 
                      SET author='$author', quantity='$quantity', image='$image' 
                      WHERE book_name='$book_name'");

        $conn->query("UPDATE educationbooks 
                      SET author='$author', quantity='$quantity', image='$image' 
                      WHERE book_name='$book_name'");

        $conn->query("UPDATE litbooks 
                      SET author='$author', quantity='$quantity', image='$image' 
                      WHERE book_name='$book_name'");

        echo "<script>alert('Book Updated Successfully ✅');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="bg-white p-6 rounded shadow w-96 mx-auto">

<h2 class="text-xl font-bold mb-4 text-center text-blue-600">
Edit Book Details
</h2>

<form method="POST">

    <input type="text" 
           name="book_name"
           placeholder="Enter Book Name"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="text" 
           name="author"
           placeholder="New Author"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="number" 
           name="quantity"
           placeholder="New Quantity"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="text" 
           name="image"
           placeholder="New Image URL"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="password" 
           name="password"
           placeholder="Librarian Password"
           class="w-full p-2 border mb-3 rounded"
           required>

    <button type="submit" 
            name="update"
            class="bg-blue-600 text-white p-2 w-full rounded hover:bg-blue-700">
        Update Book
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
