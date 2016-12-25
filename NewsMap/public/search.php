<?php

    require(__DIR__ . "/../includes/config.php");

    // numerically indexed array of places
    $places = [];
    
    /****search database for places matching $_GET["geo"], store in $places****/
    
    //evaluate input data
    if($_GET["geo"])
    {
        //search by postal code
        if(is_numeric($_GET["geo"]))
        {
            $resultP_c = CS50::query("SELECT * FROM places WHERE postal_code LIKE ?", $_GET["geo"] ."%");
            //check if there are findings
            if($resultP_c)
            {
                foreach($resultP_c as $result)
                    $places[] = $result; 
            }
        }
        // search by place name
        else
        {
            $resultP_n = CS50::query("SELECT * FROM places WHERE place_name LIKE ?", $_GET["geo"] ."%");
            
            //check if there are findings
            if($resultP_n)
            {
                foreach($resultP_n as $result)
                    $places[] = $result; 
            }
        }   
    }
    else
    {
        error_log("No geo-data to search");
        exit;
    }
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($places, JSON_PRETTY_PRINT));
?>