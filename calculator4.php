<!DOCTYPE html>
<html>
<head>
<title>Library Management - Fine & Overdue Calculator</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat p-10"
      style="background-image: url('calimg.jpg');">

<div class="absolute inset-0 bg-black/60 -z-10"></div>

<h1 class="text-4xl text-center text-white font-bold mb-12 drop-shadow-lg">
    Fine & Overdue Calculator
</h1>

<div class="flex flex-col md:flex-row gap-10 justify-center items-start">

    
    <div class="bg-white/20 backdrop-blur-xl p-8 rounded-3xl 
                shadow-2xl w-full md:w-96 border border-white/30">

        <h2 class="text-2xl text-white font-bold text-center mb-6">
            Manual Fine Calculator
        </h2>

        <input type="number"
               id="days"
               placeholder="Enter Late Days"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      placeholder-white/70 border border-white/40
                      focus:outline-none focus:ring-4 focus:ring-blue-400">

        <button onclick="calculateFine()"
                class="w-full mt-6 bg-gradient-to-r from-blue-500 to-indigo-600
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg hover:scale-105 transition duration-300">
            Calculate Fine
        </button>

        <p id="fineResult"
           class="mt-6 font-bold text-center text-green-300 text-lg"></p>
    </div>

   
    <div class="bg-white/20 backdrop-blur-xl p-8 rounded-3xl 
                shadow-2xl w-full md:w-96 border border-white/30">

        <h2 class="text-2xl text-white font-bold text-center mb-6">
            Borrow & Return Calculator
        </h2>

        <label class="text-white font-semibold">Borrow Date</label>
        <input type="date"
               id="borrowDate"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      border border-white/40 mt-2 mb-4">

        <label class="text-white font-semibold">Return Date</label>
        <input type="date"
               id="returnDate"
               class="w-full p-4 rounded-xl bg-white/30 text-white
                      border border-white/40 mt-2">

        <button onclick="calculateOverdue()"
                class="w-full mt-6 bg-gradient-to-r from-green-500 to-emerald-600
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg hover:scale-105 transition duration-300">
            Calculate Overdue & Fine
        </button>

        <p id="dateResult"
           class="text-center font-bold mt-6 text-yellow-300 text-lg"></p>

        <button onclick="back()"
                class="w-full mt-6 bg-gradient-to-r from-emerald-400 to-teal-500
                       text-white p-4 rounded-xl font-semibold
                       shadow-lg hover:scale-105 transition duration-300">
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

function calculateOverdue(){

    let borrow = document.getElementById("borrowDate").value;
    let returned = document.getElementById("returnDate").value;

    if(!borrow || !returned){
        document.getElementById("dateResult").innerHTML =
        "Please select both dates.";
        return;
    }

    let borrowDate = new Date(borrow);
    let returnDate = new Date(returned);

    let difference = returnDate.getTime() - borrowDate.getTime();
    let totalDays = Math.ceil(difference / (1000 * 60 * 60 * 24));

    if(totalDays < 0){
        document.getElementById("dateResult").innerHTML =
        "Return date must be after borrow date.";
        return;
    }

 
    let freeDays = 14;

    if(totalDays <= freeDays){
        document.getElementById("dateResult").innerHTML =
        "Returned within 14 days. No fine 🎉";
    } 
    else {

        let overdueDays = totalDays - freeDays;
        let fine = overdueDays * 10;

        document.getElementById("dateResult").innerHTML =
        "Overdue Days: " + overdueDays + 
        "<br>Total Fine: Rs. " + fine;
    }
}
</script>

</body>
</html>