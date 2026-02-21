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
<title>Borrow Book - Library</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat p-10"
      style="background-image: url('borrowbg.jpg');">

<div class="absolute inset-0 bg-black/60 -z-10"></div>

<div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
            shadow-2xl w-96 max-w-full border border-white/30">

    <h1 class="text-3xl font-bold text-center text-white drop-shadow-lg mb-8">
         Borrow Book
    </h1>

    <form method="POST" class="space-y-5">

        <select name="category" required
                class="w-full p-4 rounded-xl bg-white/30 text-white placeholder-white/70
                       border border-white/40 focus:outline-none focus:ring-4 focus:ring-blue-400
                       transition duration-300">
            <option value="" disabled selected>Select Category</option>
            <option value="novel">Novel</option>
            <option value="education">Education</option>
            <option value="literature">Literature</option>
        </select>

        <select name="book" required
                class="w-full p-4 rounded-xl bg-white/30 text-white placeholder-white/70
                       border border-white/40 focus:outline-none focus:ring-4 focus:ring-blue-400
                       transition duration-300">
            <option value="" disabled selected>Select Book</option>
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

        <button type="submit" name="borrow"
                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600
                       hover:from-indigo-600 hover:to-purple-600
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Borrow Book
        </button>

        <button type="button" onclick="window.location='main.php'"
                class="w-full mt-3 bg-gradient-to-r from-emerald-400 to-teal-500
                       hover:from-teal-500 hover:to-emerald-400
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Back
        </button>

    </form>
</div>
</body>
</html>