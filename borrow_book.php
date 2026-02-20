<?php
session_start();
include("db.php");


if(!isset($_SESSION['username']) || $_SESSION['role'] != "student"){
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

if(isset($_POST['borrow'])){
    $book = trim($_POST['book']);
    $category = strtolower(trim($_POST['category']));
    $check = null;

    if($category == "novel"){
        $check = $conn->query("SELECT quantity FROM novelbooks WHERE book_name='$book' AND quantity > 0");
        if($check->num_rows > 0) $conn->query("UPDATE novelbooks SET quantity = quantity - 1 WHERE book_name='$book'");
    } elseif($category == "education"){
        $check = $conn->query("SELECT quantity FROM educationbooks WHERE book_name='$book' AND quantity > 0");
        if($check->num_rows > 0) $conn->query("UPDATE educationbooks SET quantity = quantity - 1 WHERE book_name='$book'");
    } elseif($category == "literature"){
        $check = $conn->query("SELECT quantity FROM litbooks WHERE book_name='$book' AND quantity > 0");
        if($check->num_rows > 0) $conn->query("UPDATE litbooks SET quantity = quantity - 1 WHERE book_name='$book'");
    }

    if(isset($check) && $check->num_rows > 0){
        $return_date = date('Y-m-d', strtotime('+14 days'));
        $conn->query("INSERT INTO borrowbooks (username, book_name, category, borrow_date, return_date, status)
                      VALUES ('$username','$book','$category', CURDATE(), '$return_date', 'Borrowed')");
        echo "<script>alert('Book Borrowed ✅ Return by $return_date'); window.location='borrow_book.php';</script>";
    } else {
        echo "<script>alert('Book Not Available ❌');</script>";
    }
}


$novels = $conn->query("SELECT book_name FROM novelbooks WHERE quantity > 0");
$education = $conn->query("SELECT book_name FROM educationbooks WHERE quantity > 0");
$literature = $conn->query("SELECT book_name FROM litbooks WHERE quantity > 0");
?>

<!DOCTYPE html>
<html>
<head>
<title>Borrow Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
<div class="bg-white p-6 rounded shadow w-96 mx-auto">
<h2 class="text-2xl font-bold mb-4 text-center">Borrow Book</h2>

<form method="POST">
<label>Category:</label>
<select name="category" class="w-full p-2 border mb-3 rounded" required>
<option value="novel">Novel</option>
<option value="education">Education</option>
<option value="literature">Literature</option>
</select>

<label>Book:</label>
<select name="book" class="w-full p-2 border mb-3 rounded" required>
<optgroup label="Novel Books">
<?php while($row = $novels->fetch_assoc()){ ?>
<option value="<?= htmlspecialchars($row['book_name']); ?>"><?= htmlspecialchars($row['book_name']); ?></option>
<?php } ?>
</optgroup>
<optgroup label="Education Books">
<?php while($row = $education->fetch_assoc()){ ?>
<option value="<?= htmlspecialchars($row['book_name']); ?>"><?= htmlspecialchars($row['book_name']); ?></option>
<?php } ?>
</optgroup>
<optgroup label="Literature Books">
<?php while($row = $literature->fetch_assoc()){ ?>
<option value="<?= htmlspecialchars($row['book_name']); ?>"><?= htmlspecialchars($row['book_name']); ?></option>
<?php } ?>
</optgroup>
</select>

<button type="submit" name="borrow" class="bg-purple-600 text-white p-2 w-full rounded">Borrow Book</button>
<button type="button" onclick="window.location='main.php'" class="mt-3 bg-indigo-500 text-white p-2 w-full rounded">Back</button>
</form>
</div>
</body>
</html>