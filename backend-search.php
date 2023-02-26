<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "profhacks");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    //$sql = "SELECT * FROM `solid_26_hazardous_waste_facilities_in_new_jersey` WHERE `RECYCLING_TYPE` LIKE '%{?}%'";
    $uno = $_REQUEST["term"];
    
    $sql = "SELECT * FROM `solid_26_hazardous_waste_facilities_in_new_jersey` WHERE RECYCLING_TYPE LIKE ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                echo "<div class='container'>";
                echo "<div class='table-responsive'>";
                
                echo "<table class='table table-striped w-auto'>";
                echo "<tr>";
                echo "<td>Facility Name </td> <td> Address </td> <td> Recycling Types </td>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<tr>";
                    echo "<td class='col-md-auto'>" . $row["FACILITY_NAME"] . "</td>";
                    echo "<td>" . $row["Full_Addy"] . "</td>";
                    echo "<td>" . $row["RECYCLING_TYPE"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "</div>";
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>