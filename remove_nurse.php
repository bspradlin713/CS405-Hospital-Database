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
    echo "<title> Delete a Nurse </title>";
    echo "<form action=\"remove_nurse.php\" method=\"get\">\n";
    echo "\tName <input type='string' name ='name'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function remove(){
    echo "<title>remove nurse</title>";
    $value = $_GET['name'];
    $link = mysqli_connect("localhost","root", "MS-06ZakuII","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }
    $sqlresults = "DELETE FROM nurse WHERE name = '$value'";

    if ($link->query($sqlresults)) {
	echo "Remove\n";
    }
    else{
        echo "Query failed: ". $link->error. "\n";
        exit;
    }
   

}
function processForm(){
    startHTML();
    remove();
    endHTML();
}
function displayForm(){
    startHTML();
    makeForm();
    endHTML();
}
?>


