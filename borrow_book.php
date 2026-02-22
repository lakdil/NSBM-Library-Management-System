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
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Borrow Book - Library</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center">


<div class="absolute inset-0 bg-cover bg-center -z-10" 
     style="background-image: url('borrowbook.jpg');"></div>
<div class="absolute inset-0 bg-black/60 -z-10"></div>


<div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
            shadow-2xl w-full max-w-md border border-white/30">

    <h1 class="text-3xl font-bold text-center text-white drop-shadow-lg mb-8">
        📚 Borrow Book
    </h1>

    <form method="POST" class="space-y-5">

      
        <div x-data="{ open: false, selected: 'Select Category' }" class="relative">
            <button type="button" @click="open = !open" 
                    class="w-full p-4 rounded-xl bg-white/20 text-white border border-white/40
                           focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 flex justify-between items-center">
                <span x-text="selected"></span>
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <ul x-show="open" @click.outside="open = false" 
                class="absolute z-50 w-full mt-1 bg-gray-800 rounded-xl shadow-lg text-white max-h-60 overflow-auto">
                <li @click="selected='Novel'; open=false; $refs.category.value='novel'" class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Novel</li>
                <li @click="selected='Education'; open=false; $refs.category.value='education'" class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Education</li>
                <li @click="selected='Literature'; open=false; $refs.category.value='literature'" class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Literature</li>
            </ul>
            <input type="hidden" name="category" x-ref="category" required>
        </div>

       
        <div x-data="{ open: false, selected: 'Select Book' }" class="relative">
            <button type="button" @click="open = !open" 
                    class="w-full p-4 rounded-xl bg-white/20 text-white border border-white/40
                           focus:outline-none focus:ring-4 focus:ring-blue-400 transition duration-300 flex justify-between items-center">
                <span x-text="selected"></span>
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <ul x-show="open" @click.outside="open = false" 
                class="absolute z-50 w-full mt-1 bg-gray-800 rounded-xl shadow-lg text-white max-h-60 overflow-auto">
                <optgroup label="Novel Books">
                    <?php while($row = $novels->fetch_assoc()){ ?>
                        <li @click="selected='<?= htmlspecialchars($row['book_name']); ?>'; open=false; $refs.book.value='<?= htmlspecialchars($row['book_name']); ?>'" 
                            class="px-4 py-2 hover:bg-gray-700 cursor-pointer"><?= htmlspecialchars($row['book_name']); ?></li>
                    <?php } ?>
                </optgroup>
                <optgroup label="Education Books">
                    <?php while($row = $education->fetch_assoc()){ ?>
                        <li @click="selected='<?= htmlspecialchars($row['book_name']); ?>'; open=false; $refs.book.value='<?= htmlspecialchars($row['book_name']); ?>'" 
                            class="px-4 py-2 hover:bg-gray-700 cursor-pointer"><?= htmlspecialchars($row['book_name']); ?></li>
                    <?php } ?>
                </optgroup>
                <optgroup label="Literature Books">
                    <?php while($row = $literature->fetch_assoc()){ ?>
                        <li @click="selected='<?= htmlspecialchars($row['book_name']); ?>'; open=false; $refs.book.value='<?= htmlspecialchars($row['book_name']); ?>'" 
                            class="px-4 py-2 hover:bg-gray-700 cursor-pointer"><?= htmlspecialchars($row['book_name']); ?></li>
                    <?php } ?>
                </optgroup>
            </ul>
            <input type="hidden" name="book" x-ref="book" required>
        </div>

       
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