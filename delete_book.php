<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$librarian_password = "admin123"; 
$message = "";

if(isset($_POST['delete'])){

    $book_name = $conn->real_escape_string($_POST['book_name']);
    $password = $_POST['password'];

    if($password != $librarian_password){
        $message = "<div class='text-red-300 font-semibold text-center'>Wrong Librarian Password</div>";
    } else {

        $deleted = false;
        $tables = ['novelbooks', 'educationbooks', 'litbooks'];

        foreach($tables as $table){
            $result = $conn->query("DELETE FROM $table WHERE book_name='$book_name'");
            if($result && $conn->affected_rows > 0){
                $deleted = true;
            }
        }

        if($deleted){
            $message = "<div class='text-green-300 font-semibold text-center'>Book Deleted Successfully</div>";
        } else {
            $message = "<div class='text-red-300 font-semibold text-center'>Book Not Found</div>";
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
    <script>
       
        function togglePassword(id, iconId){
            const input = document.getElementById(id);
            const icon = document.getElementById(iconId);
            if(input.type === 'password'){
                input.type = 'text';
                icon.innerText = '🙈';
            } else {
                input.type = 'password';
                icon.innerText = '👁';
            }
        }
    </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-fixed"
      style="background-image: url('dlt.jpg');">

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

        <div class="mb-4">
            <?php echo $message; ?>
        </div>

        <form method="POST" class="space-y-4">

            <input type="text"
                   name="book_name"
                   placeholder="Book Name to Delete"
                   class="w-full p-4 rounded-xl bg-white/30 text-white
                          placeholder-white/70 border border-white/40
                          focus:outline-none focus:ring-4 focus:ring-red-400"
                   required>

            
            <div class="relative">
                <input type="password"
                       name="password"
                       id="password"
                       placeholder="Librarian Password"
                       class="w-full p-4 rounded-xl bg-white/30 text-white
                              placeholder-white/70 border border-white/40
                              focus:outline-none focus:ring-4 focus:ring-red-400"
                       required>
                <span onclick="togglePassword('password','icon1')"
                      id="icon1"
                      class="absolute right-4 top-4 cursor-pointer select-none text-white text-lg">
                      👁
                </span>
            </div>

            <button type="submit"
                    name="delete"
                    class="w-full bg-gradient-to-r from-red-500 to-rose-600
                           hover:from-rose-600 hover:to-red-500
                           text-white p-4 rounded-xl font-semibold
                           shadow-lg transform hover:scale-105
                           transition duration-300">
                           Delete Book
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