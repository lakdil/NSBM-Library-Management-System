<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");


session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != "librarian"){
    header("Location: main.php");
    exit();
}

$librarian_password = "admin123"; 
$message = "";

if(isset($_POST['delete'])){

    $book_name = trim($_POST['book_name']);
    $password = $_POST['password'];

    if($password !== $librarian_password){
        $message = "<div class='text-red-300 font-semibold text-center'>Wrong Librarian Password</div>";
    } else {

        $deleted = false;
        $tables = ['novelbooks', 'educationbooks', 'litbooks'];

        foreach($tables as $table){
            $stmt = $conn->prepare("DELETE FROM $table WHERE book_name=?");
            $stmt->bind_param("s", $book_name);
            $stmt->execute();

            if($stmt->affected_rows > 0){
                $deleted = true;
            }
        }

        if($deleted){
            $message = "<div class='text-green-300 font-semibold text-center'>Book Deleted Successfully ✅</div>";
        } else {
            $message = "<div class='text-red-300 font-semibold text-center'>Book Not Found ❌</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management - Delete Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center bg-cover bg-center bg-fixed"
      style="background-image: url('deletebook.jpg');">

    <div class="absolute inset-0 bg-black/60 -z-10"></div>

    <div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
                shadow-2xl w-96 max-w-full border border-white/30">

        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-white drop-shadow-lg">
                Library Management
            </h1>
            <p class="text-indigo-100 mt-2 text-sm">
                Delete a Book from the Collection
            </p>
        </div>

        
        <?php if($message) echo "<div class='mb-4'>$message</div>"; ?>

     
        <form method="POST" class="space-y-4">

            <input type="text"
                   name="book_name"
                   placeholder="Book Name to Delete"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-red-400"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Librarian Special Password"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-red-400"
                   required>

            <button type="submit"
                    name="delete"
                    class="w-full bg-gradient-to-r from-red-500 to-rose-600
                           hover:from-rose-600 hover:to-red-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105 transition duration-300">
                           Delete Book
            </button>

            <button type="button"
                    onclick="window.location='main.php'"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600
                           hover:from-indigo-600 hover:to-blue-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105 transition duration-300">
                           Back to Dashboard
            </button>

        </form>
    </div>
</body>
</html>