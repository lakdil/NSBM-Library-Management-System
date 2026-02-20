<?php
session_start();
include("db.php");


if(!isset($_SESSION['role']) || $_SESSION['role'] != "librarian"){
    header("Location: main.php");
    exit();
}

$message = "";

if(isset($_POST['search_student'])){
    $username = trim($_POST['username']);
    $StudentId = trim($_POST['StudentId']);

    
    $borrowedQuery = $conn->query("
        SELECT id, book_name, category, borrow_date, return_date 
        FROM borrowbooks 
        WHERE username='$username' AND status='Borrowed'
    ");
} 

if(isset($_POST['return_book'])){
    $borrow_id = $_POST['borrow_id'];
    $category = $_POST['category'];
    $book_name = $_POST['book_name'];

 
    $conn->query("UPDATE borrowbooks SET status='Returned' WHERE id='$borrow_id'");

 
    if($category == 'novel'){
        $conn->query("UPDATE novelbooks SET quantity = quantity + 1 WHERE book_name='$book_name'");
    } elseif($category == 'education'){
        $conn->query("UPDATE educationbooks SET quantity = quantity + 1 WHERE book_name='$book_name'");
    } elseif($category == 'literature'){
        $conn->query("UPDATE litbooks SET quantity = quantity + 1 WHERE book_name='$book_name'");
    }

    $message = "Book '$book_name' returned successfully ✅";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Return Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="bg-white p-6 rounded shadow w-96 mx-auto">
<h2 class="text-2xl font-bold mb-4 text-center text-red-600">Return Book</h2>

<?php if($message) echo "<p class='text-green-600 font-bold mb-3'>$message</p>"; ?>

<form method="POST" class="mb-4">
    <input type="text" name="username" placeholder="Student Username" class="w-full p-2 border mb-2 rounded" required>
    <input type="text" name="StudentId" placeholder="Student ID" class="w-full p-2 border mb-2 rounded" required>
    <button type="submit" name="search_student" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Search Borrowed Books</button>
</form>

<?php if(isset($borrowedQuery) && $borrowedQuery->num_rows > 0){ ?>
    <h3 class="font-bold mb-2">Borrowed Books:</h3>
    <?php while($row = $borrowedQuery->fetch_assoc()){ ?>
        <div class="border p-2 mb-2 rounded bg-gray-50">
            <p><strong>Book:</strong> <?= htmlspecialchars($row['book_name']); ?></p>
            <p><strong>Category:</strong> <?= ucfirst($row['category']); ?></p>
            <p><strong>Borrowed:</strong> <?= $row['borrow_date']; ?></p>
            <p><strong>Return Date:</strong> <?= $row['return_date']; ?></p>

            <form method="POST" class="mt-2">
                <input type="hidden" name="borrow_id" value="<?= $row['id']; ?>">
                <input type="hidden" name="book_name" value="<?= htmlspecialchars($row['book_name']); ?>">
                <input type="hidden" name="category" value="<?= $row['category']; ?>">
                <button type="submit" name="return_book" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Return Book</button>
            </form>
        </div>
    <?php } ?>
<?php } elseif(isset($borrowedQuery)){ ?>
    <p class="text-red-600 font-bold">No borrowed books found for this student.</p>
<?php } ?>

<button type="button" onclick="window.location='main.php'" class="mt-4 w-full bg-indigo-500 text-white p-2 rounded hover:bg-indigo-700">Back</button>

</div>
</body>
</html>