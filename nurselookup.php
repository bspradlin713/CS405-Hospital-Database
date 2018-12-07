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
    echo "<title> Nurse Lookup </title>";
    echo "<h1>Please enter lookup information below</h1>";
    echo "<form action=\"nurselookup.php\" method=\"get\">\n";
    echo "\tNurse Name: (Blank for All)\n";
    echo "\t<input type='string' name ='name'>\n<br>";

    echo "\t<input type='checkbox' name='nurseDrRelat' value='Show'> Show which doctors the Nurse works with<br>";
    echo "\t<input type='checkbox' name='nursePatients' value='ShowP'> Show which Patients the Nurse Supervises";

}

function displayResults(){
    echo "<title> Nurse Lookup </title>";
    $value = $_GET['name'];
    $showDr = $_GET['nurseDrRelat'];
    $showP = $_GET['nursePatients'];
    echo "<h1>Nurses with name matching $value</h1>";
    $link = mysqli_connect("localhost","root", "MS-06ZakuII","hospital");
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }


    $sqlresults = "SELECT * FROM nurse WHERE name LIKE CONCAT('$value', '%')";
    if (ctype_space($value)){

    	$sqlresults = "SELECT * FROM nurse";
    	
    }
    $q_results = $link->query($sqlresults);
    if (!$q_results) {
        echo "Query failed: ". $link->error. "\n";
        exit;
    }
    else if ($q_results->num_rows === 0) {
        echo "<h3>No nurses match the value of ". $value. "\n </h3>";
    }
    else{
        echo "<h3>Nurses with matching name:</h3>";
	echo "<h4>Name&nbsp;Birthday&nbsp;Start Date</h4>";
        while ($s_names = $q_results->fetch_assoc()) {
            echo $s_names["name"]. "\t\t". $s_names["birthday"]. "\t\t". $s_names["start_date"]. "<br \>";
            if (isset($_GET['nurseDrRelat'])){
   	    	echo "\t\t". "Works with:<br>";	
		$findMe = $s_names['name'];
		#FIRST PART
		$sql2 = "SELECT * FROM (SELECT D.name, A.name AS Nurse FROM(SELECT W.doctor_id, N.name FROM nurse N JOIN works_under W where N.employee_id=W.nurse_id) AS A JOIN (SELECT name, employee_id FROM doctor) AS D where A.doctor_id = D.employee_id) AS C WHERE Nurse LIKE CONCAT('$findMe','%')";
		$results2 = $link->query($sql2);
		if ($results2-> num_rows !== 0){
		    	while($dr = $results2->fetch_assoc()){
			    echo "&nbsp;&nbsp;&nbsp;&nbsp;". $dr['name']. "<br>";
			}
		}
		else{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;Works for No One!<br>";	
		}
            }
	    if (isset($_GET['nursePatients'])){
		echo "Cares For:<br>";
	        $findMe = $s_names['name'];
		$sql2 = "SELECT * FROM (SELECT D.name, A.name AS Nurse FROM(SELECT W.patient_id, N.name FROM nurse N JOIN supervises W where N.employee_id=W.nurse_id) AS A JOIN (SELECT name, ssid FROM patient) AS D where A.patient_id = D.ssid) AS C WHERE Nurse LIKE CONCAT('$findMe','%')";
		$results2 = $link->query($sql2);
		if($results2->num_rows !== 0){
 			while($p = $results2->fetch_assoc()){
				echo "&nbsp;&nbsp;&nbsp;&nbsp;". $p['name']. "<br>";	
			}
		}
		else{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;Cares for No One!<br>";
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


