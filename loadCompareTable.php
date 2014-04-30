<?php
    require("dblogin.php");
    $db_conn = mysqli_connect($server, $username, $password,$database);
    if (!$db_conn)
        die("Unable to connect: " . mysqli_error());  // die is similar to exit
   
    $cmd = "SELECT * FROM Stocks";            
    $retval = mysqli_query($db_conn , $cmd);
    $table = "";
    while($row = mysqli_fetch_array($retval)){
            $table .= "<tr>";
            $table .= "<td> <input type='checkbox' class='btn'></td>";
            $table .= "<td>".$row['tickerSymbol']."</td>";
            $table .= "<td>".$row['companyName']."</td>";
            $table .= "<td>".$row['sector']."</td>";
            $table .= "<td>".$row['currentPrice']."</td>";
            $table .= "</tr>";
     }
    
    echo $table;
    mysqli_close($db_conn);
    
    
?>