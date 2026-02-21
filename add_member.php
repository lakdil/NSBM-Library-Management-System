<?php
session_start();
include("db.php"); 


if(!isset($_SESSION['role']) || $_SESSION['role'] != "librarian"){
    header("Location: main.php");
    exit();
}

$message = "";


if(isset($_POST['add'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $studentId = trim($_POST['StudentId']);

 
    if($name && $email && $phone && $studentId){
        
        $stmt = $conn->prepare("SELECT id FROM members WHERE StudentId=? OR email=?");
        $stmt->bind_param("ss", $studentId, $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $message = "⚠ Member with this Student ID or Email already exists.";
        } else {
          
            $stmt_insert = $conn->prepare("INSERT INTO members (name, email, phone, StudentId) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $name, $email, $phone, $studentId);

            if($stmt_insert->execute()){
                $message = "✅ Member added successfully!";
            } else {
                $message = "❌ Error: " . $conn->error;
            }
        }

        $stmt->close();
    } else {
        $message = "⚠ Please fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Member - Library</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat p-10"
      style="background-image: url('background.jpg');">

<div class="absolute inset-0 bg-black/60 -z-10"></div>

<div class="relative bg-white/20 backdrop-blur-xl p-10 rounded-3xl 
            shadow-2xl w-96 max-w-full border border-white/30">

    <h1 class="text-3xl font-bold text-center text-white drop-shadow-lg mb-4">
        ➕ Add New Member
    </h1>

    <?php if($message){ ?>
        <p class="text-center font-semibold mb-4 <?php echo strpos($message,'successfully')!==false?'text-green-400':'text-red-400'; ?>">
            <?php echo $message; ?>
        </p>
    <?php } ?>

    <form method="POST" class="space-y-5">

        <input type="text" name="name" placeholder="Full Name" required
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300">

        <input type="email" name="email" placeholder="Email" required
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300">

        <input type="text" name="phone" placeholder="Phone" required
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300">

        <input type="text" name="StudentId" placeholder="Student ID" required
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300">

        <button name="add"
                class="w-full bg-gradient-to-r from-blue-500 to-indigo-600
                       hover:from-indigo-600 hover:to-blue-500
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Add Member
        </button>

        <button type="button" onclick="back()"
                class="w-full mt-3 bg-gradient-to-r from-emerald-400 to-teal-500
                       hover:from-teal-500 hover:to-emerald-400
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Back
        </button>

    </form>
</div>

<script>
function back(){
    window.location.href="main.php";
}
</script>

</body>
</html>