<!DOCTYPE html>
<html>
<head>
<title>Library Management - Fine & Date Calculator</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat p-10"
      style="background-image: url('finebackground.jpg');">

<div class="absolute inset-0 bg-black/60 -z-10"></div>

<h1 class="text-4xl text-center text-white font-bold mb-12 drop-shadow-lg">
    Fine & Date Calculator
</h1>

<!-- Main Flex Container -->
<div class="flex flex-col md:flex-row gap-10 justify-center items-start">

    <!-- LEFT SIDE - Fine Calculator -->
    <div class="bg-white/20 backdrop-blur-xl p-8 rounded-3xl 
                shadow-2xl w-full md:w-96 border border-white/30">

        <h2 class="text-2xl text-white font-bold text-center mb-6">
            Fine Calculator
        </h2>

        <input type="number"
               id="days"
               placeholder="Enter Late Days"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400
                      transition duration-300">

        <button onclick="calculateFine()"
                class="w-full mt-6 bg-gradient-to-r from-blue-500 to-indigo-600
                       hover:from-indigo-600 hover:to-blue-500
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Calculate Fine
        </button>

        <p id="fineResult"
           class="mt-6 font-bold text-center text-green-300 text-lg"></p>
    </div>


    <!-- RIGHT SIDE - Date Difference -->
    <div class="bg-white/20 backdrop-blur-xl p-8 rounded-3xl 
                shadow-2xl w-full md:w-96 border border-white/30">

        <h2 class="text-2xl text-white font-bold text-center mb-6">
            Date Difference Calculator
        </h2>

        <label class="text-white font-semibold">Enter Date 1</label>
        <input type="date"
               id="dateInput1"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      border border-white/40 mt-2 mb-4
                      focus:outline-none focus:ring-4 focus:ring-green-400">

        <label class="text-white font-semibold">Enter Date 2</label>
        <input type="date"
               id="dateInput2"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      border border-white/40 mt-2">

        <button onclick="dateDiff()"
                class="w-full mt-6 bg-gradient-to-r from-green-500 to-emerald-600
                       hover:from-emerald-600 hover:to-green-500
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Calculate Days
        </button>

        <p id="dateResult"
           class="text-center font-bold mt-6 text-yellow-300 text-lg"></p>

        <button onclick="back()"
                class="w-full mt-6 bg-gradient-to-r from-emerald-400 to-teal-500
                       hover:from-teal-500 hover:to-emerald-400
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg transform hover:scale-105
                       transition duration-300">
            Back to Dashboard
        </button>
    </div>

</div>


<script>
function back(){
    window.location.href="main.php";
}

function calculateFine(){
    let days = document.getElementById("days").value;

    if(days === "" || days < 0){
        document.getElementById("fineResult").innerHTML =
        "Please enter valid late days.";
        return;
    }

    let fine = days * 10;

    document.getElementById("fineResult").innerHTML =
    "Total Fine: Rs. " + fine;
}

function dateDiff(){
    let dateI1 = document.getElementById("dateInput1").value;
    let dateI2 = document.getElementById("dateInput2").value;

    if(!dateI1 || !dateI2){
        document.getElementById("dateResult").innerHTML =
        "Please select both dates.";
        return;
    }

    let date1 = new Date(dateI1);
    let date2 = new Date(dateI2);

    let time_difference = date2.getTime() - date1.getTime();
    let result = Math.ceil(time_difference / (1000 * 60 * 60 * 24));

    if(result < 0){
        document.getElementById("dateResult").innerHTML =
        "Date 2 must be after Date 1.";
        return;
    }

    document.getElementById("dateResult").innerHTML =
    result + " days between both dates.";
}
</script>

</body>
</html>