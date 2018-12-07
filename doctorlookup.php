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
    echo "\tDoctor Name: (Blank for All)\n";
    echo "\t<input type='string' name ='name'>\n";
    echo "\t<input type='checkbox' name='nurseDrRelat' value='Show'> Show which Nurses the Doctor works with:";

    echo "\t<input type='checkbox' name='doctorPatient' value='Show'> Show which Patients the Doctor Cares For:";


   
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
            echo $s_names["name"]. "\t\t". $s_names["birthday"]. "\t\t". $s_names["start_date"]. "<br \>";
            if (isset($_GET['nurseDrRelat')){
                echo "Nurses that work with this doctor<br>;
                $name = $s_names["name"];
                $sql2 = "SELECT * FROM (SELECT B.name FROM (SELECT W.nurse_id, D.name FROM doctor D JOIN works_under W where D.employee_id = W.doctor_id) AS A JOIN  (SELECT name, employee_id FROM nurse) AS B WHERE B.employee_id = A.nurse_id) AS C WHERE C.name=$name";
                $results2 = $link->query($sql2);
                if ($results2-> num_rows !== 0){
                        while($nu = $results2->fetch_assoc()){
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;". $nu['name']. "<br>";
                        }
                }
                else{
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;Has No Nurses!<br>";
                }
            }
            if (isset($_GET['doctorPatient'])){
                echo "Doctor's Patients<br>";
                $name = $s_names["name"];
                $sql2 = "SELECT * FROM (SELECT B.name FROM (SELECT C.patient_id FROM doctor D JOIN cares_for C where C.doctor_id=D.employee_id) AS A JOIN (SELECT name, ssid FROM patient) AS B WHERE B.ssid =A.patient_id) AS D WHERE D.name = $name";
                $results2 = $link->query($sql2);
                if ($results2-> num_rows !== 0){
                        while($nu = $results2->fetch_assoc()){
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;". $nu['name']. "<br>";
                        }
                }
                else{
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;Has No Patients!<br>";
                }
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


