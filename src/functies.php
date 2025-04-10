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



// functie om de resultaten van alle aanbiedingen voor inloggen te zoeken
function zoekaanbiedinguitlog($kortingmin, $kortingmax, $puntenmin, $puntenmax, $categorie)
{
    $sql = "SELECT * FROM aanbieding";
    //korting
    if ($kortingmax != null) {
        //korting-punten
        if ($kortingmax != null) {
            $sql = $sql . " WHERE prijs BETWEEN $kortingmin AND $kortingmax AND punten BETWEEN $puntenmin AND $puntenmax";
            //categorie
            if ($categorie != null) {
                $sql = $sql . " AND categorie = '$categorie'";
            }
        }
    }
    return $sql . " ORDER BY id DESC";
}

//functie om de resultaten bij alle bonnen te filteren
function zoekaanbiedingproduct($orgineelmin, $orgineelmax, $product, $productid)
{
    $sql = "SELECT * FROM product WHERE id = $productid";
    //orginele prijs
    if ($orgineelmin != null && $orgineelmax != null) {
        //orginele prijs-product
        $sql = $sql . " AND prijs BETWEEN $orgineelmin AND $orgineelmax";
        if ($product != NULL) {
            $sql = $sql . " AND naam LIKE '%$product%'";
        }
    }
    return $sql;
}

//functie om resultaten van alle bestellingen te filteren op de profiel pagina
function zoekbonprofiel($bonid, $gebruikt, $profielid)
{
    $sql = "SELECT * FROM bestelling WHERE gebruikerid = $profielid";
    //bonid
    if ($bonid != null) {
        $sql = $sql . " AND id = '$bonid'";
        //bonid-gebruikt admin
        if ($gebruikt != null) {
            $sql = $sql . " AND gebruikt = '$gebruikt'";
        }
    }
    //gebruikt
    elseif ($gebruikt != null) {
        $sql = $sql . " AND gebruikt = '$gebruikt'";
        //gebruikt-bonid admin
        if ($bonid != null) {
            $sql = $sql . " AND id = '$bonid'";
        }
    }
    return $sql . " ORDER BY datum DESC LIMIT 6";
}

//functie om resultaten op de admin profiel pagina te filteren



function zoek($table, $zoektermen, $row)
{
    $sql = $sql = "SELECT * FROM $table WHERE";
    for ($i = 0; $i <= count($row) - 1; $i++) {
        if ($zoektermen[$i] != NULL) {
            if ($i == 0) {
                $sql = $sql . " $row[$i] LIKE '%$zoektermen[$i]%'";
            } elseif ($i == count($row) - 1) {
                $sql = $sql . " AND $row[$i] = '$zoektermen[$i]'";
            } else {
                $sql = $sql . " AND $row[$i] LIKE '%$zoektermen[$i]%'";
            }
        }
    }
    // echo $sql;
    return $sql;
}

//functie om de resultaten van alle bonnen te filteren
function zoekbon($zoektermen, $row, $admin)
{
    $sql = "SELECT * FROM bestelling";
    for($i = 0; $i < count($zoektermen) - 1; $i++){
        if($zoektermen[$i] != null){
            if($i == 0){
                $sql = $sql . " WHERE $row[$i] = '$zoektermen[$i]'";
            }else{
                $sql = $sql . " AND $row[$i] = '$zoektermen[$i]'";
            }
        }    
    }
    // echo $sql;
    if($admin == "ja"){
        return $sql . " ORDER BY datum DESC LIMIT 6";
    }
    if($admin == "nee"){
       return $sql . " ORDER BY datum DESC"; 
    }
    
}

//functie om de resultaten van alle aanbiedingen te filteren zodra je ingelogt bent
function zoekaanbieding($zoektermen, $prijs, $row)
{
    $sql = "SELECT * FROM aanbieding";
    for ($i = 0; $i <= count($zoektermen) - 1; $i++) {
        if ($zoektermen[$i] != null) {
            if ($i == 0) {
                $sql = $sql . " WHERE $row[$i] BETWEEN $prijs[0] AND $prijs[1] AND punten BETWEEN $prijs[2] AND $prijs[3]";
            }elseif($i == count($zoektermen) - 1){
                $sql = $sql . " AND $row[$i] = '$zoektermen[$i]'";
            }else{
                $sql = $sql . " AND $row[$i] = '$zoektermen[$i]'";
            }
        }
    }
    // echo $sql;
    return $sql . " ORDER BY id DESC";
}



//functie om de resultaten van alle klanten te filteren
function zoekklant($actief, $voornaam, $achternaam, $bedrijf)
{
    $sql = "SELECT * FROM gebruikers WHERE";
    $zoekterm = array($voornaam, $achternaam, $bedrijf, $actief);
    $row = array("voornaam", "achternaam", "bedrijf", "actief");
    for ($i = 0; $i <= count($row) - 1; $i++) {
        if ($zoekterm[$i] != NULL) {
            if ($i == 0) {
                $sql = $sql . " $row[$i] LIKE '%$zoekterm[$i]%'";
            } elseif ($i == count($row) - 1) {
                $sql = $sql . " AND $row[$i] = '$zoekterm[$i]'";
            } else {
                $sql = $sql . " AND $row[$i] LIKE '%$zoekterm[$i]%'";
            }
        }
    }
    echo $sql;
    // //voornaam
    // if ($voornaam != NULL) {
    //     $sql = $sql . " voornaam LIKE '%$voornaam%'";
    //     //voornaam-actief
    //     if ($actief != NULL) {
    //         $sql = $sql . " AND actief = '$actief'";
    //         //voornaam-actief-achternaam
    //         if ($achternaam != NULL) {
    //             $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //             //voornaam-actief-achternaam-bedrijf
    //             if ($bedrijf  != NULL) {
    //                 $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //             }
    //         }
    //         //voornaam-actief-bedrijf
    //         elseif ($bedrijf  != NULL) {
    //             $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //             //voornaam-actief-bedrijf-achternaam
    //             if ($achternaam != NULL) {
    //                 $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //             }
    //         }
    //     }
    //     //voornaam-achternaam
    //     elseif ($achternaam != NULL) {
    //         $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //         //voornaam-achternaam-actief
    //         if ($actief != NULL) {
    //             $sql = $sql . " AND actief = '$actief'";
    //             //voornaam-achternaam-actief-bedrijf
    //             if ($bedrijf  != NULL) {
    //                 $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //             }
    //         }
    //         //voornaam-achternaam-bedrijf
    //         elseif ($bedrijf  != NULL) {
    //             $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //             //voornaam-achternaam-bedrijf-actief
    //             if ($actief != NULL) {
    //                 $sql = $sql . " AND actief = '$actief'";
    //             }
    //         }
    //     }
    //     //voornaam-bedrijf
    //     elseif ($bedrijf  != NULL) {
    //         $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //         //voornaam-bedrijf-actief
    //         if ($actief != NULL) {
    //             $sql = $sql . " AND actief = '$actief'";
    //             //voornaam-bedrijf-actief-achternaam
    //             if ($achternaam != NULL) {
    //                 $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //             }
    //         }
    //         //voornaam-bedrijf-achternaam
    //         elseif ($achternaam != NULL) {
    //             $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //             //voornaam-bedrijf-achternaam-actief
    //             if ($actief != NULL) {
    //                 $sql = $sql . " AND actief = '$actief'";
    //             }
    //         }
    //     }
    // }
    // //achternaam
    // elseif ($achternaam != NULL) {
    //     $sql = $sql . " achternaam LIKE '%$achternaam%'";
    //     //achternaam-actief
    //     if ($actief != NULL) {
    //         $sql = $sql . " AND actief = '$actief'";
    //         //achternaam-actief-bedrijf
    //         if ($bedrijf  != NULL) {
    //             $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //         }
    //     }
    //     //achternaam-bedrijf
    //     elseif ($bedrijf  != NULL) {
    //         $sql = $sql . " AND bedrijf LIKE '%$bedrijf%'";
    //         //achternaam-bedrijf-actief
    //         if ($actief != NULL) {
    //             $sql = $sql . " AND actief = '$actief'";
    //         }
    //     }
    // }
    // //bedrijf
    // elseif ($bedrijf  != NULL) {
    //     $sql = $sql . " bedrijf LIKE '%$bedrijf%'";
    //     //bedrijf-actief
    //     if ($actief != NULL) {
    //         $sql = $sql . " AND actief = '$actief'";
    //         //bedrijf-actief-achternaam
    //         if ($achternaam != NULL) {
    //             $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //         }
    //     }
    //     //bedrijf-achternaam
    //     elseif ($achternaam != NULL) {
    //         $sql = $sql . " AND achternaam LIKE '%$achternaam%'";
    //         //bedrijf-achternaam-actief
    //         if ($actief != NULL) {
    //             $sql = $sql . " AND actief = '$actief'";
    //         }
    //     }
    // }
    // //actief
    // elseif ($actief != NULL) {
    //     $sql = $sql . " actief='$actief'";
    // }
    // // echo $sql;
    return $sql;
}
