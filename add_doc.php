<?php

#test
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
    echo "<title> Doctor Lookup </title>";
    echo "<form action=\"add_doc.php\" method=\"get\">\n";
    echo "\tName <input type='string' name ='name'><br>";
    echo "\tBirthday <input type='string' name ='bday'><br>";
    echo "\tStart Date <input type='string' name ='sday'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function add(){
    echo "<title> add doctor</title>";
    $value = $_GET['name'];
    $bday = $_GET['bday'];
    $sday = $_GET['sday'];
    $link = mysqli_connect("localhost","root", "MS-06ZakuII","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }
    $sqlresults = "INSERT INTO doctor (name, birthday, start_date) VALUES ('$value', '$bday', '$sday');";

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


