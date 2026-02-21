<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$message = "";

if(isset($_POST['add'])){

    $book_name = $conn->real_escape_string($_POST['book_name']);
    $author = $conn->real_escape_string($_POST['author']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $category = $_POST['category'];
    $image = $conn->real_escape_string($_POST['image']);   

    if($category == "Novel"){
        $sql = "INSERT INTO novelbooks (book_name, author, quantity, image) 
                VALUES ('$book_name', '$author', '$quantity', '$image')";
    }
    elseif($category == "Education"){
        $sql = "INSERT INTO educationbooks (book_name, author, quantity, image) 
                VALUES ('$book_name', '$author', '$quantity', '$image')";
    }
    elseif($category == "Literature"){
        $sql = "INSERT INTO litbooks (book_name, author, quantity, image) 
                VALUES ('$book_name', '$author', '$quantity', '$image')";
    }

    if(isset($sql) && $conn->query($sql)){
        $message = "<div class='text-green-300 font-semibold text-center'>Book Added Successfully</div>";
    } else {
        $message = "<div class='text-red-300 font-semibold text-center'> Error Adding Book</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management - Add Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
      style="background-image: url('book.jpg');">

    
    <div class="absolute inset-0 bg-black/60"></div>

    
    <div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
                shadow-2xl w-96 max-w-full border border-white/30">

        
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-white drop-shadow-lg">
                Library Management
            </h1>
            <p class="text-indigo-100 mt-2 text-sm">
                Add a New Book to the Collection
            </p>
        </div>

        
        <div class="mb-4">
            <?php echo $message; ?>
        </div>

        
        <form method="POST" class="space-y-4">

            <input type="text"
                   name="book_name"
                   placeholder="Book Name"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <input type="text"
                   name="author"
                   placeholder="Author"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <input type="number"
                   name="quantity"
                   placeholder="Quantity"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <select name="category"
                    class="w-full p-4 rounded-xl bg-white/30 text-white
                           border border-white/40 focus:outline-none
                           focus:ring-4 focus:ring-indigo-400"
                    required>
                <option value="" class="text-black">Select Category</option>
                <option value="Novel" class="text-black">Novel</option>
                <option value="Education" class="text-black">Education</option>
                <option value="Literature" class="text-black">Literature</option>
            </select>

            <input type="text"
                   name="image"
                   placeholder="Image Name (example.jpg)"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-blue-400"
                   required>

            <button type="submit"
                    name="add"
                    class="w-full bg-gradient-to-r from-green-500 to-emerald-600
                           hover:from-emerald-600 hover:to-green-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105
                           transition duration-300">
                Add Book
            </button>

            <button type="button"
                    onclick="window.location='main.php'"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600
                           hover:from-indigo-600 hover:to-blue-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105
                           transition duration-300">
                Back to Dashboard
            </button>

        </form>
    </div>

</body>
</html>