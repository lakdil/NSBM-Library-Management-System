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

    <h1 class="text-3xl font-bold text-center text-white drop-shadow-lg mb-8">
        ➕ Add New Member
    </h1>

    <form method="POST" class="space-y-5">

        <input type="text" name="name" placeholder="Full Name"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300" required>

        <input type="email" name="email" placeholder="Email"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300" required>

        <input type="text" name="phone" placeholder="Phone"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300" required>

        <input type="text" name="StudentId" placeholder="Student ID"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300" required>

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