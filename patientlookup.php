<?php


if (isset($_GET['name']) && isset($_GET['category'])){
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
    echo "<title> Patient Lookup </title>";
    echo "<h1>Please enter lookup information below</h1>";
    echo "<form action=\"patientlookup.php\" method=\"get\">\n";
    echo "\tPatient Directory:\n";
    echo "\t<select name ='category'>\n";
    echo "\t\t<option value ='Name'> Name </option>\n";
    echo "\t\t<option value ='Patient ID'> Patient ID </option>\n";
    echo "\t<input type='string' name ='name'>\n";
        echo "\t<input type='checkbox' name='DrPatient' value='Show'> Show Patient's Doctors<br>";

    echo "\t<input type='checkbox' name='nursePatient' value='Show'> Show Patient's Nurses";


}

function displayResults(){
    echo "<title> Patients Lookup </title>";
    $value = $_GET['name'];
    $lookup = $_GET['category'];
    echo "<h1>Patients with name matching $value</h1>";
    $link = mysqli_connect("localhost","root", "MS-06ZakuII","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }
    $sqlresults = "SELECT * FROM patient WHERE $lookup='$value'";

    $q_results = $link->query($sqlresults);
    if (!$q_results) {
        echo "Query failed: ". $link->error. "\n";
        exit;
    }
    else if ($q_results->num_rows === 0) {
        echo "<h3>No patients match the value of ". $value. "\n </h3>";
    }
    else{
        echo "<h3>Patients with matching $lookup:</h3><br>";
        while ($s_names = $q_results->fetch_assoc()) {
            echo $s_names["name"]. "\t\t". $s_names["birthday"]. "\t\t". $s_names["entered_hosptial"]. "<br \>";
            if (isset($_GET['DrPatient'])){
		echo "\t\tServed by Doctor:<br>";
		$findMe = $s_names['name'];
		#FIRST PART	
	    }
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


