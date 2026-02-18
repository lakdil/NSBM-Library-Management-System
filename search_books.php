<?php
session_start();
include("db.php");

$result = "";

if(isset($_POST['search'])){
    $book = $_POST['book_name'];
    $sql = $conn->query("SELECT * FROM books WHERE book_name='$book'");
    
    if($sql->num_rows > 0){
        $result = "Book Available";
    } else {
        $result = "Book Not Available";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<form method="POST" class="bg-white p-6 rounded shadow w-96 mx-auto">
    <input type="text" name="book_name" placeholder="Search Book"
    class="w-full p-2 border mb-3" required>

    <button name="search"
    class="bg-blue-600 text-white p-2 w-full rounded">
    Search
    </button>

    <p class="mt-3 text-center font-bold"><?php echo $result; ?></p>
</form>

</body>
</html>