<?php

include('./vendor/autoload.php');
//loop through all folders in src and save the folder name in an array
if (!isset($_GET['day'])) {
    $days = array_filter(glob('./src/*'), 'is_dir');
    array_shift($days);
    asort($days);
    // loop through the array
    foreach ($days as $day) {
        $day = basename($day); // get the folder name
        // get url path from the browser
        echo "<h1>Hello $day!</h1>";
        echo "<pre>";
        $className = "App\\" . strtolower($day) . "\\" . ucfirst($day);
        // instantiate a dynmic class for the day
        [$round1, $round2] = (new $className('input'))->solve();
        echo "</pre>";
        // display the results as table
        if ($round1 && $round2) {
            echo "<table>";
            echo "<tr><th>Round 1</th><th>Round 2</th></tr>";
            echo "<tr><td>$round1</td><td>$round2</td></tr>";
            echo "</table>";
        }
    }
} else {
    $className = "App\\day" . $_GET['day'] . "\\Day" . $_GET['day'];
    echo '<pre style="background-color: black; color: #ddd; padding: 20px">';
    [$round1, $round2] = (new $className($_GET['mode'] ?? 'test'))->solve();
    echo "</pre>";
    // display the results as table
    if ($round1 || $round2) {
        echo "<table>";
        echo "<tr><th>Round 1</th><th>Round 2</th></tr>";
        echo "<tr><td>$round1</td><td>$round2</td></tr>";
        echo "</table>";
    }
}
