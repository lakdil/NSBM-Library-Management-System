<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">

<style>
input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    box-sizing: border-box;
}
</style>

</head>
<body class="bg-gray-100 p-8">


<div class="bg-white p-6 rounded shadow w-96 mx-auto mb-6">
    <h2 class="text-xl font-bold mb-4">Fine Calculator</h2>
    

    
    <input type="number" id="days" placeholder="Late Days">

    <button onclick="calculateFine()"
    class="bg-blue-600 text-white p-2 w-full rounded mt-3">
    Calculate
    </button>

    <p id="fineResult" class="mt-3 font-bold text-center"></p>
</div>


<div class="bg-white p-6 rounded shadow w-96 mx-auto">
    <h2 class="text-red-600 text-center font-bold mb-4">
        Calculate days between two given dates
    </h2>

    <label><b>Enter date1</b></label>
    <input type="date" id="dateInput1">

    <label class="mt-3 block"><b>Enter date2</b></label>
    <input type="date" id="dateInput2">

    <button onclick="dateDiff()" 
    class="bg-green-600 text-white p-2 w-full rounded mt-4">
    Calculate number of days
    </button>

    <button type="button" onclick="back()"
    class="px-3 py-1.5 text-white bg-indigo-500 rounded-lg hover:bg-indigo-700 w-full mt-3">
    Back
    </button>

    <h3 id="dateResult" class="text-center font-bold mt-4"></h3>
</div>

<script>
function back(){
    window.location.href="main.php";
}

function calculateFine(){
    let days = document.getElementById("days").value;
    let fine = days * 10;
    document.getElementById("fineResult").innerHTML =
    "Total Fine: Rs." + fine;
}

function dateDiff(){
    var dateI1 = document.getElementById("dateInput1").value;
    var dateI2 = document.getElementById("dateInput2").value;

    var date1 = new Date(dateI1);
    var date2 = new Date(dateI2);

    var time_difference = date2.getTime() - date1.getTime();
    var result = time_difference / (1000 * 60 * 60 * 24);

    document.getElementById("dateResult").innerHTML =
    result + " days between both dates.";
}
</script>

</body>
</html>