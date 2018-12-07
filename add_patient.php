<?php


if (isset($_GET['name'])){
    processForm();
} else {
    displayForm();
}

#Opening for HTML file
function startHTML(){
    echo "<!DOCTYPE HTML>\n<html>\n<body>\n";
}

#ending for HTML File
function endHTML(){
    echo"</body>\n</html>\n";
}

function makeForm(){
    echo "<title> Add Patient </title>";
    echo "<form action=\"add_patient.php\" method=\"get\">\n";
    echo "\tSSN <input type='string' name ='ssn'><br>";
    echo "\tName <input type='string' name ='name'><br>";
    echo "\tBirthday <input type='string' name ='bday'><br>";
    echo "\tEntry Date <input type='string' name ='sday'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function add(){
    echo "<title> add doctor</title>";
    $ssn = $_GET['ssn'];
    $value = $_GET['name'];
    $bday = $_GET['bday'];
    $sday = $_GET['sday'];
    $link = mysqli_connect("localhost","root", "Password1","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }
    $sqlresults = "INSERT INTO patient (ssid, name, birthday, entered_hospital) VALUES ('$ssn', '$value', '$bday', '$sday');";

    if ($link->query($sqlresults)) {
	echo "Added\n";
    }
    else{
        echo "Query failed: ". $link->error. "\n";
        exit;
    }
   

}
function processForm(){
    startHTML();
    add();
    endHTML();
}
function displayForm(){
    startHTML();
    makeForm();
    endHTML();
}
?>


