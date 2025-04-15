<?php
// start session
session_start();
function db()
{
    // Create connection
    $host = 'localhost';
    $user = 'root';
    $ww = '';
    $database = '_dpc_Klant-Kaart_12524';
    $conn = new mysqli($host, $user, $ww, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //   echo "Connected successfully";
    return $conn;
}

// functie om in te loggen
function login($email, $ww)
{
    if (isset($_POST['login'])) {
        $error = NULL;
        //voorkomt sql injecties
        $email = stripslashes($email);
        $ww = stripslashes($ww);
        $email = mysqli_real_escape_string(db(), $email);
        $ww = mysqli_real_escape_string(db(), $ww);
        //set de query en voert hem uit
        $sql = "SELECT * FROM gebruikers WHERE email='$email' AND ww='$ww'";
        $result = db()->query($sql);
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                if ($data['actief'] == 'actief') {
                    $_SESSION['inlog'] = true;
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['rol'] = $data['rol'];
                    header("Location: pages/index.php");
                    die();
                }
                $error = 'Uw account staat momenteel uit';
                return $error;
            }
        } else {
            $error = 'Wachtwoord of email is niet correct';
            return $error;
        }
    }
}

//zoekfunctie
function zoek($table, $zoektermen, $row, $profiel)
{
    $sql = $sql = "SELECT * FROM $table WHERE";
    for ($i = 0; $i < count($row); $i++) {
        if ($zoektermen[$i] != NULL) {
            if ($i == 0) {
                if($table == "aanbieding"){
                    $sql = $sql . " $row[$i] BETWEEN " . $zoektermen[$i][0] . " AND " . $zoektermen[$i][1] . " AND punten BETWEEN " . $zoektermen[$i][2] . " AND " . $zoektermen[$i][3]; 
                }elseif($table == "product"){
                    $sql = $sql . " $row[$i] BETWEEN " . $zoektermen[$i][0] . " AND " . $zoektermen[$i][1];
                }elseif($row[$i] == "gebruikerid" || $row[$i] == "id"){
                    $sql = $sql . " $row[$i] = '$zoektermen[$i]'";
                }
                else{
                   $sql = $sql . " $row[$i] LIKE '%$zoektermen[$i]%'"; 
                }  
            } elseif ($i == count($row) - 1) {
                $sql = $sql . " AND $row[$i] = '$zoektermen[$i]'";
            } else {
                $sql = $sql . " AND $row[$i] LIKE '%$zoektermen[$i]%'";
            }
        }
    }
    // echo $sql;
    if($table == "bestelling" && $profiel == "ja"){
         return $sql  . " ORDER BY datum DESC LIMIT 6";        
    }elseif($table == "product"){
        return $sql  .  " ORDER BY id DESC";
    }else{
       return $sql; 
    }
    
}
