<?php
    $scores = [];
    for ($i = 0; $i < $_GET['length']; $i++) {
        $scores[] = rand(1, 100); 
    }

    $json = json_encode($scores);

    echo $json;
?>