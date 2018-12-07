<?php


if (isset($_GET['nName'])){
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
    echo "<title> Set Primary Nurse </title>";
    echo "<form action=\"primary_nurse.php\" method=\"get\">\n";
    echo "\tNurse Name <input type='text' name ='nName'><br>";
    echo "\tPatient Name <input type='text' name ='pName'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function add(){
    echo "<title>set primary nurse</title>";
    $nName = $_GET['nName'];
    $pName = $_GET['pName'];
    $link = mysqli_connect("localhost","root", "Password1","hospital");
   
    if(!$link){
        die("Failed to connect: " . mysqli_connect_error());
    }





    $nID = $link->query("SELECT employee_id FROM nurse WHERE name='$nName'")->fetch_object()->employee_id;
    if (!$nID) {
        echo "Query failed in nurse : ". $link->error. "\n";
        exit;
    }
    else if ($nID->num_rows === 0){
	echo "No nurse of the name ".$nName;
    }




 
    $pID = $link->query("SELECT ssid FROM patient WHERE name='$pName'")->fetch_object()->ssid;
    if (!$pID) {
        echo "Query failed in patient: ". $link->error. "\n";
        exit;
    }
    else if ($pID->num_rows === 0){
	echo "No patient of the name ".$pName;
    }





    $sqlresults = "INSERT INTO supervises (nurse_id, patient_id) VALUES ($nID, $pID)";

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


