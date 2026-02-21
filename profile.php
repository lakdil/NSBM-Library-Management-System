<?php
session_start();
include("db.php");

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$today = date("Y-m-d");

$totalQuery = $conn->query("
    SELECT COUNT(*) AS total 
    FROM borrowbooks 
    WHERE username='$username'
");
$totalBorrowed = $totalQuery->fetch_assoc()['total'];

$currentQuery = $conn->query("
    SELECT COUNT(*) AS current 
    FROM borrowbooks 
    WHERE username='$username' AND status='Borrowed'
");
$currentBorrowed = $currentQuery->fetch_assoc()['current'];

$lastBorrowDate = "No records";
$lastQuery = $conn->query("
    SELECT borrow_date 
    FROM borrowbooks 
    WHERE username='$username'
    ORDER BY borrow_date DESC 
    LIMIT 1
");
if($lastQuery->num_rows > 0){
    $lastBorrowDate = $lastQuery->fetch_assoc()['borrow_date'];
}

$nextReturn = "No active borrow";
$returnQuery = $conn->query("
    SELECT return_date 
    FROM borrowbooks 
    WHERE username='$username' 
    AND status='Borrowed'
    ORDER BY return_date ASC
    LIMIT 1
");
if($returnQuery->num_rows > 0){
    $nextReturn = $returnQuery->fetch_assoc()['return_date'];
}

$booksQuery = $conn->query("
    SELECT book_name, category, borrow_date, return_date, status
    FROM borrowbooks
    WHERE username='$username'
    ORDER BY borrow_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Profile</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-fixed"
      style="background-image: url('profile.jpg');">

<div class="absolute inset-0 bg-black/60 -z-10"></div>

<div class="relative w-full max-w-2xl bg-white/20 backdrop-blur-xl 
            p-8 rounded-3xl shadow-2xl border border-white/30 text-white">

    <h2 class="text-3xl font-bold text-center mb-6">👤 My Profile</h2>

    <div class="space-y-2 mb-6 text-sm">
        <p><strong>Username:</strong> <?php echo $username; ?></p>
        <p><strong>Total Books Borrowed:</strong> <?php echo $totalBorrowed; ?></p>
        <p><strong>Currently Borrowed:</strong> <?php echo $currentBorrowed; ?></p>
        <p><strong>Last Borrow Date:</strong> <?php echo $lastBorrowDate; ?></p>
        <p><strong>Next Return Deadline:</strong> <?php echo $nextReturn; ?></p>
    </div>

    <hr class="my-4 border-white/40">

    <h3 class="text-lg font-bold mb-3">Borrowed Books</h3>

    <div class="space-y-3 max-h-60 overflow-y-auto text-sm">
    <?php
    if($booksQuery->num_rows > 0){
        while($row = $booksQuery->fetch_assoc()){

            $overdue = "";
            if($row['status'] == "Borrowed" && $row['return_date'] < $today){
                $overdue = "<span class='text-red-400 font-bold'> (Overdue!)</span>";
            }

            echo "
            <div class='bg-white/10 p-3 rounded-lg'>
                <p><strong>Book:</strong> {$row['book_name']}</p>
                <p><strong>Category:</strong> {$row['category']}</p>
                <p><strong>Borrowed:</strong> {$row['borrow_date']}</p>
                <p><strong>Return:</strong> {$row['return_date']} {$overdue}</p>
                <p><strong>Status:</strong> {$row['status']}</p>
            </div>
            ";
        }
    } else {
        echo "<p class='text-gray-300'>No borrowed books yet.</p>";
    }
    ?>
    </div>

    <hr class="my-4 border-white/40">

    <h3 class="text-lg font-bold mb-2">Library Usage Analysis</h3>

    <div class="text-sm mb-6">
    <?php
    if($totalBorrowed == 0){
        echo "<p>You haven't borrowed any books yet.</p>";
    }
    elseif($totalBorrowed <= 3){
        echo "<p>Light Reader – Keep exploring!</p>";
    }
    elseif($totalBorrowed <= 10){
        echo "<p>Active Reader – Great job!</p>";
    }
    else{
        echo "<p>Heavy Reader – Library Champion!</p>";
    }
    ?>
    </div>

    <button onclick="window.location='main.php'"
    class="bg-indigo-600 text-white p-3 w-full rounded-xl hover:bg-indigo-700 transition">
    Back to Dashboard
    </button>

</div>

</body>
</html>