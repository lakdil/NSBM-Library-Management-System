<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("db.php");

$resultHTML = "";

if(isset($_POST['search'])){

    $book = $conn->real_escape_string($_POST['book_name']);

    $sql = "
    SELECT book_name, author, image, 'Novel' AS category 
    FROM novelbooks 
    WHERE book_name LIKE '%$book%'

    UNION

    SELECT book_name, author, image, 'Education' AS category 
    FROM educationbooks 
    WHERE book_name LIKE '%$book%'

    UNION

    SELECT book_name, author, image, 'Literature' AS category 
    FROM litbooks 
    WHERE book_name LIKE '%$book%'
    ";

    $query = $conn->query($sql);

    if($query && $query->num_rows > 0){

        while($row = $query->fetch_assoc()){

            $bookName = htmlspecialchars($row['book_name']);
            $author = htmlspecialchars($row['author']);
            $category = $row['category'];
            $image = htmlspecialchars($row['image']);

            $resultHTML .= "
            <div class='bg-white/30 backdrop-blur-md p-5 rounded-2xl shadow-lg border border-white/40 mb-5'>
                <img src='uploads/$image' 
                     class='w-full h-48 object-cover rounded-xl mb-4'>

                <p class='text-white'><strong>Book Name:</strong> $bookName</p>
                <p class='text-white'><strong>Author:</strong> $author</p>
                <p class='text-white'><strong>Category:</strong> $category</p>
            </div>
            ";
        }

    } else {
        $resultHTML = "<div class='text-red-300 font-bold text-center mt-4'>Book Not Found</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System - Search Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col items-center justify-start bg-cover bg-center bg-no-repeat p-10"
      style="background-image: url('images/library-bg.jpg');">

    <div class="absolute inset-0 bg-black/60 -z-10"></div>

    <div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
                shadow-2xl w-96 max-w-full border border-white/30">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white drop-shadow-lg">
                Library Management
            </h1>
            <p class="text-indigo-100 mt-2 text-sm">
                Search and manage your book collection
            </p>
        </div>

        <form method="POST" class="space-y-5">

            <input type="text"
                   name="book_name"
                   placeholder="Enter Book Name"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400
                          focus:border-transparent transition duration-300"
                   required>

            <button type="submit"
                    name="search"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600
                           hover:from-indigo-600 hover:to-blue-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105
                           transition duration-300">
                           Search Book
            </button>

            <button type="button"
                    onclick="window.location='main.php'"
                    class="w-full bg-gradient-to-r from-emerald-400 to-teal-500
                           hover:from-teal-500 hover:to-emerald-400
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105
                           transition duration-300">
                ⬅ Back to Dashboard
            </button>

        </form>
    </div>

    <div class="w-full max-w-2xl mt-10">
        <?php echo $resultHTML; ?>
    </div>

</body>
</html>