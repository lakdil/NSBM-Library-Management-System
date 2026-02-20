<?php
session_start();
include("db.php");

$resultHTML = "";

if(isset($_POST['search'])){
    $book = trim($conn->real_escape_string($_POST['book_name']));

    if(empty($book)){
        $resultHTML = "<div class='text-red-600 font-bold text-center'>Please enter a book name ❌</div>";
    } else {
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

        if(!$query){
            die("SQL Error: " . $conn->error);
        }

        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                $bookName = htmlspecialchars($row['book_name']);
                $author = htmlspecialchars($row['author']);
                $category = htmlspecialchars($row['category']);
                $image = $row['image'];

                // Check if image exists, fallback to default
                $imgPath = 'uploads/' . $image;
                if(empty($image) || !file_exists($imgPath)){
                    $imgPath = 'uploads/default.jpg'; // make sure you have a default.jpg in uploads/
                }

                $resultHTML .= "
                <div class='border p-4 rounded mb-4 bg-gray-50 shadow hover:shadow-md transition'>
                    <img src='$imgPath' class='w-full h-40 object-cover rounded mb-3'>

                    <p><strong>Book Name:</strong> $bookName</p>
                    <p><strong>Author:</strong> $author</p>
                    <p><strong>Category:</strong> $category</p>
                </div>
                ";
            }
        } else {
            $resultHTML = "<div class='text-red-600 font-bold text-center'>Book Not Found ❌</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">

<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">

    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Search Book</h2>

    <form method="POST">

        <input type="text" 
               name="book_name"
               placeholder="Enter Book Name"
               class="w-full p-2 border mb-3 rounded"
               required>

        <button type="submit" 
                name="search"
                class="bg-blue-600 text-white p-2 w-full rounded hover:bg-blue-700">
            Search
        </button>

    </form>

    <div class="mt-6">
        <?php echo $resultHTML; ?>
    </div>

    <button type="button"
        onclick="window.location='main.php'"
        class="mt-4 bg-indigo-500 hover:bg-indigo-700 text-white p-2 w-full rounded">
        Back
    </button>

</div>

</body>
</html>