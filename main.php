<?php
session_start();
include("db.php");

if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];


$novels = $conn->query("SELECT * FROM novelbooks WHERE status='available'");
$education = $conn->query("SELECT * FROM educationbooks WHERE status='available'");
$literature = $conn->query("SELECT * FROM litbooks WHERE status='available'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Main Page</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">


<div class="bg-blue-600 text-white p-4 text-center">
    <h2 class="text-xl font-semibold">Welcome <?php echo $username; ?></h2>
</div>


<nav class="bg-white shadow p-4 flex space-x-6">

<?php if($role == "librarian"){ ?>
    <a href="add_member.php" class="text-blue-600 hover:underline">Add Member</a>
    <a href="add_book.php" class="text-blue-600 hover:underline">Add Book</a>
    <a href="delete_book.php" class="text-blue-600 hover:underline">Delete book</a>
    <a href="edit_book.php" class="text-blue-600 hover:underline">Edit book</a>
    <a href="return_book.php" class="text-blue-600 hover:underline">Return Book</a>

<?php } ?>

<a href="search_book.php" class="text-blue-600 hover:underline">Search Book</a>
<a href="borrow_book.php" class="text-blue-600 hover:underline">Borrow Book</a>
<a href="fine_calculator.php" class="text-blue-600 hover:underline">Fine Calculator</a>
<a href="logout.php" class="text-red-600 hover:underline">Logout</a>
<div class="absolute top-4 right-6">
    <a href="profile.php">
        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700">
            👤
        </div>
    </a>
</div>

</nav>


<div class="p-8">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

       
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-center mb-4 text-blue-600">Novel Books</h2>

            <?php if($novels->num_rows > 0){ ?>
                <?php while($row = $novels->fetch_assoc()){ ?>
                    <div class="border rounded-lg p-4 mb-4 shadow-sm hover:shadow-md transition">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                             class="w-full h-40 object-cover rounded mb-3">

                        <h3 class="font-semibold text-lg">
                            <?php echo $row['book_name']; ?>
                        </h3>

                        <p class="text-gray-600">
                            Author: <?php echo $row['author']; ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-500 text-center">No Available Books</p>
            <?php } ?>
        </div>


      
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-center mb-4 text-green-600">Education Books</h2>

            <?php if($education->num_rows > 0){ ?>
                <?php while($row = $education->fetch_assoc()){ ?>
                    <div class="border rounded-lg p-4 mb-4 shadow-sm hover:shadow-md transition">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                             class="w-full h-40 object-cover rounded mb-3">

                        <h3 class="font-semibold text-lg">
                            <?php echo $row['book_name']; ?>
                        </h3>

                        <p class="text-gray-600">
                            Author: <?php echo $row['author']; ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-500 text-center">No Available Books</p>
            <?php } ?>
        </div>


      
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-center mb-4 text-purple-600">Literature Books</h2>

            <?php if($literature->num_rows > 0){ ?>
                <?php while($row = $literature->fetch_assoc()){ ?>
                    <div class="border rounded-lg p-4 mb-4 shadow-sm hover:shadow-md transition">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                             class="w-full h-40 object-cover rounded mb-3">

                        <h3 class="font-semibold text-lg">
                            <?php echo $row['book_name']; ?>
                        </h3>

                        <p class="text-gray-600">
                            Author: <?php echo $row['author']; ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-500 text-center">No Available Books</p>
            <?php } ?>
        </div>

    </div>

</div>

</body>
</html>