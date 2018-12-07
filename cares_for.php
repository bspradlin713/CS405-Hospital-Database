<?php


if (isset($_GET['dName'])){
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
    echo "<title> Set caring Doctor </title>";
    echo "<form action=\"cares_for.php\" method=\"get\">\n";
    echo "\tDoctor Name <input type='text' name ='dName'><br>";
    echo "\tPatient Name <input type='text' name ='pName'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function add(){
    echo "<title>set caring doctor</title>";
    $dName = $_GET['dName'];
    $pName = $_GET['pName'];
    $link = mysqli_connect("localhost","root", "Password1","hospital");
   
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }





    $dID = $link->query("SELECT employee_id FROM doctor WHERE name='$dName'")->fetch_object()->employee_id;
    if (!$dID) {
        echo "Query failed in doctor : ". $link->error. "\n";
        exit;
    }
    else if ($dID->num_rows === 0){
	echo "No doctor of the name ".$dName;
    }




 
    $pID = $link->query("SELECT ssid FROM patient WHERE name='$pName'")->fetch_object()->ssid;
    if (!$pID) {
        echo "Query failed in patient: ". $link->error. "\n";
        exit;
    }
    else if ($pID->num_rows === 0){
	echo "No patient of the name ".$pName;
    }





    $sqlresults = "INSERT INTO cares_for (doctor_id, patient_id) VALUES ($dID, $pID)";

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


