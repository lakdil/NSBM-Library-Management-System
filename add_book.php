<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if(isset($_POST['add'])){

    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $image = $_POST['image'];   

    
    if($category == "Novel"){
        $sql = "INSERT INTO novelbooks (book_name, author, quantity, image) 
                VALUES ('$book_name', '$author', '$quantity', '$image')";
    }
    elseif($category == "Education"){
        $sql = "INSERT INTO educationbooks (book_name, author, quantity, image) 
                VALUES ('$book_name', '$author', '$quantity', '$image')";
    }
    elseif($category == "Literature"){
        $sql = "INSERT INTO litbooks (book_name, author, quantity, image) 
                VALUES ('$book_name', '$author', '$quantity', '$image')";
    }

    if($conn->query($sql)){
        echo "<script>alert('Book Added Successfully ✅');</script>";
    } else {
        echo "<script>alert('Error Adding Book ❌');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8" class="bg-cover bg-center min-h-screen flex items-center justify-center"
      style="background-image: url('book.jpg');">

<div class="bg-white p-6 rounded shadow w-96 mx-auto">

<h2 class="text-xl font-bold mb-4 text-center">Add Book</h2>

<form method="POST">

    <input type="text" 
           name="book_name"
           placeholder="Book Name"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="text" 
           name="author"
           placeholder="Author"
           class="w-full p-2 border mb-3 rounded"
           required>

    <input type="number" 
           name="quantity"
           placeholder="Quantity"
           class="w-full p-2 border mb-3 rounded"
           required>

    
    <select name="category"
            class="w-full p-2 border mb-3 rounded"
            required>
        <option value="">Select Category</option>
        <option value="Novel">Novel</option>
        <option value="Education">Education</option>
        <option value="Literature">Literature</option>
    </select>

    
    <input type="text" 
           name="image"
           placeholder="Enter Image URL (example: https://example.com/book.jpg)"
           class="w-full p-2 border mb-3 rounded"
           required>

    <button type="submit" 
            name="add"
            class="bg-green-600 text-white p-2 w-full rounded hover:bg-green-700">
        Add Book
    </button>

    <button type="button"
    onclick="window.location='main.php'"
    class="mt-4 bg-indigo-500 hover:bg-indigo-700 text-white p-2 w-full rounded">
    Back
    </button>

</form>

</div>

</body>
</html>