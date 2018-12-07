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
    echo "</select>";
    echo "\t<input type='string' name ='name'>\n";
    echo "\t<br>";
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
    $sqlresults = "SELECT * FROM patient WHERE $lookup LIKE CONCAT('$value','%')";
    
    
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
	echo "<h4>Name&nbsp;|&nbsp;Birthday&nbsp;|&nbsp;Start Date</h4>";

        while ($s_names = $q_results->fetch_assoc()) {
            echo $s_names["name"]. "\t\t". $s_names["birthday"]. "\t\t". $s_names["entered_hosptial"]. "<br \>";
            if (isset($_GET['DrPatient'])){
		echo "\t\tServed by Doctor:<br>";
		$findMe = $s_names['name'];
		#FIRST PART
		$sql2 = "SELECT DR, name FROM(SELECT * FROM(SELECT C.doctor_id, P.name FROM patient P JOIN cares_for C where P.ssid = C.patient_id) AS A JOIN (SELECT name as DR, employee_id FROM doctor) AS B WHERE A.doctor_id = B.employee_id)AS D where name = '$findMe'";
		$results2 = $link->query($sql2);

		if ($results2-> num_rows !== 0){
		    while($dr = $results2->fetch_assoc()){
			    echo "&nbsp;&nbsp;&nbsp;&nbsp;". $dr['DR']. "<br>";
		    }
		}
		else{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;No Doctor!<br>";	
		}	
	    }
	    if (isset($_GET['nursePatient'])){
		echo "Supervised by Nurses:<br>";
		 $findMe = $s_names['name'];
		$sql2 = "SELECT NURSE, name FROM(SELECT * FROM(SELECT S.nurse_id, P.name FROM patient P JOIN supervises S where S.patient_id = P.ssid) AS A JOIN (SELECT name as NURSE, employee_id FROM nurse) AS B WHERE A.nurse_id = B.employee_id) AS D where name ='$findMe'";
		$results2 = $link->query($sql2);
		 if ($results2-> num_rows !== 0){
                    while($nu = $results2->fetch_assoc()){
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;". $nu['NURSE']. "<br>";
                    }
                }
                else{
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;No Nurses!<br>";
                }
	
	    }
	    echo "<br>";
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


