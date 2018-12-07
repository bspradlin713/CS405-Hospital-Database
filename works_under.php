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
    echo "<title> Set Doctor For Nurse</title>";
    echo "<form action=\"works_under.php\" method=\"get\">\n";
    echo "\tDoctor Name <input type='text' name ='dName'><br>";
    echo "\tNurse Name <input type='text' name ='nName'><br>";
    echo "\t<input type='submit'>\n";
    echo "</form>";
}

function add(){
    echo "<title>set Doctor for Nurse</title>";
    $dName = $_GET['dName'];
    $nName = $_GET['nName'];
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




 
    $nID = $link->query("SELECT employee_id FROM nurse WHERE name='$nName'")->fetch_object()->employee_id;
    if (!$nID) {
        echo "Query failed in nurse: ". $link->error. "\n";
        exit;
    }
    else if ($nID->num_rows === 0){
	echo "No patient of the name ".$nName;
    }





    $sqlresults = "INSERT INTO works_under (doctor_id, nurse_id) VALUES ($dID, $nID)";

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


