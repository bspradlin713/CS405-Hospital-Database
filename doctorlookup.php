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
    echo "<title> Doctor Lookup </title>";
    echo "<h1>Please enter lookup information below</h1>";
    echo "<form action=\"doctorlookup.php\" method=\"get\">\n";
    echo "\tDoctor Name:\n";
    echo "\t<input type='string' name ='name'>\n";
}

function displayResults(){
    echo "<title> doctor Lookup </title>";
    $value = $_GET['name'];
    echo "<h1>Doctors with name matching $value</h1>";
    $link = mysqli_connect("localhost","root", "MS-06ZakuII","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }
    $sqlresults = "SELECT * FROM doctor WHERE name='$value'";

    $q_results = $link->query($sqlresults);
    if (!$q_results) {
        echo "Query failed: ". $link->error. "\n";
        exit;
    }
    else if ($q_results->num_rows === 0) {
        echo "<h3>No doctors match the value of ". $value. "\n </h3>";
    }
    else{
        echo "<h3>Doctors with matching name:</h3>";
        while ($s_names = $q_results->fetch_assoc()) {
            echo $s_names["name"]. "\t\t". $s_names["Birthday"]. "\t\t". $s_names["start_date"]. "<br \>";
        }
    }


}
function processForm(){
    startHTML();
    displayResults();
    endHTML();
}
function displayForm(){
    startHTML();
    makeForm();
    endHTML();
}
?>

