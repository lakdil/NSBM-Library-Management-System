<?php
session_start();
include("db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "librarian"){
    header("Location: main.php");
    exit();
}

$message = "";
$resultHTML = "";

if(isset($_POST['search_student'])){
    $username = $conn->real_escape_string(trim($_POST['username']));
    $StudentId = $conn->real_escape_string(trim($_POST['StudentId']));

    $borrowedQuery = $conn->query("
        SELECT id, book_name, category, borrow_date, return_date 
        FROM borrowbooks 
        WHERE username='$username' AND status='Borrowed'
    ");

    if($borrowedQuery && $borrowedQuery->num_rows > 0){

        while($row = $borrowedQuery->fetch_assoc()){

            $bookName = htmlspecialchars($row['book_name']);
            $category = ucfirst($row['category']);
            $borrowDate = $row['borrow_date'];
            $returnDate = $row['return_date'];
            $borrowId = $row['id'];

            $resultHTML .= "
            <div class='bg-white/30 backdrop-blur-md p-5 rounded-2xl shadow-lg border border-white/40 mb-5'>
                <p class='text-white'><strong>Book:</strong> $bookName</p>
                <p class='text-white'><strong>Category:</strong> $category</p>
                <p class='text-white'><strong>Borrowed:</strong> $borrowDate</p>
                <p class='text-white'><strong>Return Date:</strong> $returnDate</p>

                <form method='POST' class='mt-4'>
                    <input type='hidden' name='borrow_id' value='$borrowId'>
                    <input type='hidden' name='book_name' value='$bookName'>
                    <input type='hidden' name='category' value='{$row['category']}'>
                    <button type='submit' name='return_book'
                        class='w-full bg-gradient-to-r from-green-500 to-emerald-600
                               hover:from-emerald-600 hover:to-green-500
                               text-white p-3 rounded-xl font-semibold
                               shadow-lg transform hover:scale-105
                               transition duration-300'>
                        Return Book
                    </button>
                </form>
            </div>
            ";
        }

    } else {
        $resultHTML = "<div class='text-red-300 font-bold text-center mt-4'>No borrowed books found.</div>";
    }
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
<title>Library Management - Return Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col items-center justify-start bg-cover bg-center bg-no-repeat p-10"
      style="background-image: url('returnbook.jpg');">

<div class="absolute inset-0 bg-black/60 -z-10"></div>

<div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
            shadow-2xl w-96 max-w-full border border-white/30">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white drop-shadow-lg">
            Return Book
        </h1>
        <p class="text-indigo-100 mt-2 text-sm">
            Manage borrowed books and returns
        </p>
    </div>

    <?php if($message){ ?>
        <div class="text-green-300 font-bold text-center mb-4">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form method="POST" class="space-y-5">

        <input type="text"
               name="username"
               placeholder="Student Username"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      focus:border-transparent transition duration-300"
               required>

        <input type="text"
               name="StudentId"
               placeholder="Student ID"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      focus:border-transparent transition duration-300"
               required>

        <button type="submit"
                name="search_student"
                class="w-full bg-gradient-to-r from-blue-500 to-indigo-600
                       hover:from-indigo-600 hover:to-blue-500
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
                       Search Borrowed Books
        </button>

        <button type="button"
                onclick="window.location='main.php'"
                class="w-full bg-gradient-to-r from-emerald-400 to-teal-500
                       hover:from-teal-500 hover:to-emerald-400
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
                       Back to Dashboard
        </button>

    </form>
</div>

<div class="w-full max-w-2xl mt-10">
    <?php echo $resultHTML; ?>
</div>

</body>
</html>