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
<html>
<head>
<title>My Profile</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">

<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">

<h2 class="text-2xl font-bold text-center mb-4">👤 My Profile</h2>

<div class="space-y-2 mb-4">

    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Total Books Borrowed:</strong> <?php echo $totalBorrowed; ?></p>
    <p><strong>Currently Borrowed:</strong> <?php echo $currentBorrowed; ?></p>
    <p><strong>Last Borrow Date:</strong> <?php echo $lastBorrowDate; ?></p>
    <p><strong>Next Return Deadline:</strong> <?php echo $nextReturn; ?></p>

</div>

<hr class="my-4">

<h3 class="text-lg font-bold mb-2">📚 Borrowed Books</h3>

<div class="space-y-2 max-h-48 overflow-y-auto">

<?php
if($booksQuery->num_rows > 0){
    while($row = $booksQuery->fetch_assoc()){

        $overdue = "";
        if($row['status'] == "Borrowed" && $row['return_date'] < $today){
            $overdue = "<span class='text-red-600 font-bold'> (Overdue!)</span>";
        }

        echo "
        <div class='border p-2 rounded bg-gray-50 text-sm'>
            <p><strong>Book:</strong> {$row['book_name']}</p>
            <p><strong>Category:</strong> {$row['category']}</p>
            <p><strong>Borrowed:</strong> {$row['borrow_date']}</p>
            <p><strong>Return:</strong> {$row['return_date']} {$overdue}</p>
            <p><strong>Status:</strong> {$row['status']}</p>
        </div>
        ";
    }
} else {
    echo "<p class='text-gray-500'>No borrowed books yet.</p>";
}
?>

</div>

<hr class="my-4">

<h3 class="text-lg font-bold mb-2">📊 Library Usage Analysis</h3>

<div class="text-sm">

<?php
if($totalBorrowed == 0){
    echo "<p>You haven't borrowed any books yet.</p>";
}
elseif($totalBorrowed <= 3){
    echo "<p>📘 Light Reader – Keep exploring!</p>";
}
elseif($totalBorrowed <= 10){
    echo "<p>📚 Active Reader – Great job!</p>";
}
else{
    echo "<p>🏆 Heavy Reader – Library Champion!</p>";
}
?>

</div>

<button onclick="window.location='main.php'"
class="mt-4 bg-indigo-600 text-white p-2 w-full rounded hover:bg-indigo-700">
Back
</button>

</div>

</body>
</html>