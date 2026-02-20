<?php
session_start();
include("db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "student" || !isset($_SESSION['username'])){
    header("Location: main.php");
    exit();
}
$username = $_SESSION['username'];

if(isset($_POST['borrow'])){
    $book = $_POST['book'];

    $stmt_check = $conn->prepare("SELECT quantity FROM books WHERE book_name = ? AND quantity > 0");
    $stmt_check->bind_param("s", $book);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if($result_check->num_rows > 0){
       
        $stmt_update = $conn->prepare("UPDATE books SET quantity = quantity - 1 WHERE book_name = ?");
        $stmt_update->bind_param("s", $book);
        $stmt_update->execute();

        $stmt_insert = $conn->prepare("INSERT INTO borrowed_books (username, book_name, borrow_date) VALUES (?, ?, CURDATE())");
        $stmt_insert->bind_param("ss", $username, $book);
        $stmt_insert->execute();

        echo "<script>alert('Book Borrowed Successfully'); window.location='borrow_book.php';</script>";
    } else {
        echo "<script>alert('Book Not Available'); window.location='borrow_book.php';</script>";
    }
}

$books_result = $conn->query("SELECT book_name FROM books WHERE quantity > 0");
$books = [];
if($books_result->num_rows > 0){
    while($row = $books_result->fetch_assoc()){
        $books[] = $row['book_name'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Borrow Book</title>

</head>
<body class="bg-gray-100 p-8">


<nav class="bg-white shadow p-4 flex space-x-4 mb-6">
    <a href="search_book.php" class="text-blue-600 hover:text-gray-800">Search Book</a>
    <a href="borrow_book.php" class="text-blue-600 hover:text-gray-800 font-bold">Borrow Book</a>
    <a href="fine_calculator.php" class="text-blue-600 hover:text-gray-800">Fine Calculator</a>
    <a href="logout.php" class="text-red-600 hover:text-gray-800">Logout</a>
</nav>


<div class="bg-white p-6 rounded shadow w-96 mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-center">Borrow Book</h2>

    <form method="POST">
        <label class="block mb-2 font-semibold">Select Book:</label>
        <select name="book" class="w-full p-2 border mb-4 rounded" required>
            <option value="">-- Choose a book --</option>
            <?php foreach($books as $book_name): ?>
                <option value="<?= htmlspecialchars($book_name) ?>"><?= htmlspecialchars($book_name) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="borrow" class="bg-purple-600 hover:bg-purple-700 text-white p-2 w-full rounded">
            Borrow Book
        </button>

        <button type="button" onclick="back()" class="mt-3 bg-indigo-500 hover:bg-indigo-700 text-white p-2 w-full rounded">
            Back
        </button>
    </form>
</div>

<script>
function back(){
    window.location.href = "main.php";
}
</script>

</body>
</html>
