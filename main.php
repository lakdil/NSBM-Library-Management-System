<?php
session_start();
include("db.php");

if(!isset($_SESSION['username'])){
    header("Location: index1.php");
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
<title>Library Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center bg-fixed"
      style="background-image: url('sample.jpg');">

<div class="absolute inset-0 bg-black/70 -z-10"></div>

<div class="bg-white/20 backdrop-blur-lg text-white p-4 text-center shadow-lg">
    <h2 class="text-xl font-semibold">Welcome <?php echo $username; ?> 👋</h2>
</div>

<nav class="bg-white/20 backdrop-blur-lg shadow-lg p-4 flex flex-wrap gap-6 justify-center text-white font-medium">

<?php if($role == "librarian"){ ?>
    <a href="add_member.php" class="hover:text-yellow-300">Add Member</a>
    <a href="add_book.php" class="hover:text-yellow-300">Add Book</a>
    <a href="delete_book.php" class="hover:text-yellow-300">Delete Book</a>
    <a href="edit_book.php" class="hover:text-yellow-300">Edit Book</a>
    <a href="return_book.php" class="hover:text-yellow-300">Return Book</a>
<?php } ?>

    <a href="search_book.php" class="hover:text-yellow-300">Search Book</a>
    <a href="borrow_book.php" class="hover:text-yellow-300">Borrow Book</a>
    <a href="fine_calculator.php" class="hover:text-yellow-300">Fine Calculator</a>
    <a href="logout.php" class="text-red-400 hover:text-red-600">Logout</a>

    <a href="profile.php" class="ml-4 bg-blue-600 px-4 py-1 rounded-full hover:bg-blue-700">
        Profile
    </a>
</nav>

<div class="p-10">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="bg-white/20 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/30 text-white">
            <h2 class="text-2xl font-bold text-center mb-6 text-blue-300">Novel Books</h2>

            <?php if($novels->num_rows > 0){ ?>
                <?php while($row = $novels->fetch_assoc()){ ?>
                    <div class="bg-white/10 rounded-xl p-4 mb-4 shadow hover:scale-105 transition">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                             class="w-full h-40 object-cover rounded-lg mb-3">

                        <h3 class="font-semibold text-lg">
                            <?php echo $row['book_name']; ?>
                        </h3>

                        <p class="text-gray-200">
                            Author: <?php echo $row['author']; ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-300 text-center">No Available Books</p>
            <?php } ?>
        </div>

        <div class="bg-white/20 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/30 text-white">
            <h2 class="text-2xl font-bold text-center mb-6 text-green-300">Education Books</h2>

            <?php if($education->num_rows > 0){ ?>
                <?php while($row = $education->fetch_assoc()){ ?>
                    <div class="bg-white/10 rounded-xl p-4 mb-4 shadow hover:scale-105 transition">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                             class="w-full h-40 object-cover rounded-lg mb-3">

                        <h3 class="font-semibold text-lg">
                            <?php echo $row['book_name']; ?>
                        </h3>

                        <p class="text-gray-200">
                            Author: <?php echo $row['author']; ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-300 text-center">No Available Books</p>
            <?php } ?>
        </div>

        <div class="bg-white/20 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/30 text-white">
            <h2 class="text-2xl font-bold text-center mb-6 text-purple-300">Literature Books</h2>

            <?php if($literature->num_rows > 0){ ?>
                <?php while($row = $literature->fetch_assoc()){ ?>
                    <div class="bg-white/10 rounded-xl p-4 mb-4 shadow hover:scale-105 transition">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                             class="w-full h-40 object-cover rounded-lg mb-3">

                        <h3 class="font-semibold text-lg">
                            <?php echo $row['book_name']; ?>
                        </h3>

                        <p class="text-gray-200">
                            Author: <?php echo $row['author']; ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-300 text-center">No Available Books</p>
            <?php } ?>
        </div>

    </div>

</div>

</body>
</html>