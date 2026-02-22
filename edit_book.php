<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$librarian_password = "admin123";
$message = "";

if(isset($_POST['update'])){

    $book_name = $conn->real_escape_string($_POST['book_name']);
    $author = $conn->real_escape_string($_POST['author']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $image = $conn->real_escape_string($_POST['image']);
    $password = $_POST['password'];

    if($password != $librarian_password){
        $message = "<div class='text-red-300 font-semibold text-center'>Wrong Librarian Password</div>";
    } else {

        $conn->query("UPDATE novelbooks 
                      SET author='$author', quantity='$quantity', image='$image' 
                      WHERE book_name='$book_name'");

        $conn->query("UPDATE educationbooks 
                      SET author='$author', quantity='$quantity', image='$image' 
                      WHERE book_name='$book_name'");

        $conn->query("UPDATE litbooks 
                      SET author='$author', quantity='$quantity', image='$image' 
                      WHERE book_name='$book_name'");

        $message = "<div class='text-green-300 font-semibold text-center'>Book Updated Successfully</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management - Edit Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
      style="background-image: url('picture.jpeg');">

      <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
                shadow-2xl w-96 max-w-full border border-white/30">

        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-white drop-shadow-lg">
                Library Management
            </h1>
            <p class="text-indigo-100 mt-2 text-sm">
                Update Book Information
            </p>
        </div>

        <div class="mb-4">
            <?php echo $message; ?>
        </div>

        <form method="POST" class="space-y-4">

            <input type="text"
                   name="book_name"
                   placeholder="Enter Book Name"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <input type="text"
                   name="author"
                   placeholder=" Author"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <input type="number"
                   name="quantity"
                   placeholder="New Quantity"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <input type="text"
                   name="image"
                   placeholder="Image Name (example.jpg)"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Librarian Password"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-red-400"
                   required>

            <button type="submit"
                    name="update"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600
                           hover:from-indigo-600 hover:to-blue-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105 transition duration-300">
                           Update Book
            </button>

            <button type="button"
                    onclick="window.location='main.php'"
                    class="w-full bg-gradient-to-r from-emerald-400 to-teal-500
                           hover:from-teal-500 hover:to-emerald-400
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105 transition duration-300">
                           Back to Dashboard
            </button>

        </form>
    </div>

</body>
</html>