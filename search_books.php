<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("db.php");

$resultHTML = "";

if(isset($_POST['search'])){

    $book = $_POST['book_name'];

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

    if($query->num_rows > 0){

        while($row = $query->fetch_assoc()){

            $bookName = $row['book_name'];
            $author = $row['author'];
            $category = $row['category'];
            $image = $row['image'];

            $resultHTML .= "
            <div class='border p-4 rounded mb-4 bg-gray-50 shadow'>
                <img src='uploads/$image' 
                     class='w-full h-40 object-cover rounded mb-3'>

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
?>

<!DOCTYPE html>
<html>
<head>
<title>Search Book</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">

<div class="bg-white p-6 rounded shadow w-96 mx-auto">

    <h2 class="text-xl font-bold mb-4 text-center">Search Book</h2>

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

        <div class="mt-4">
            <?php echo $resultHTML; ?>
        </div>

        <button type="button"
        onclick="window.location='main.php'"
        class="mt-4 bg-indigo-500 hover:bg-indigo-700 text-white p-2 w-full rounded">
        Back
        </button>

    </form>

</div>

</body>
</html>