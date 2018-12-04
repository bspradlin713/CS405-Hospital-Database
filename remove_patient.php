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
    echo "<title> Delete a Doctor </title>";
    echo "<form action=\"remove_doc.php\" method=\"get\">\n";
    echo "\tName <input type='string' name ='name'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function remove(){
    echo "<title>remove patient</title>";
    $value = $_GET['name'];
    $link = mysqli_connect("localhost","root", "MS-06ZakuII","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }
    $sqlresults = "DELETE FROM patient WHERE name = '$value'";

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


