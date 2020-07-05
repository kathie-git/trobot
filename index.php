<?php

include 'Includes/Libraries.php';

$fline = file('Files/instructionsData.txt');

$moveCount = 0;
$j = 0;
$store = new XyfStore();
$instruction = ["MOVE", "LEFT", "RIGHT", "REPORT"];

for ($i = 0; $i < count($fline); $i++) {
    $line = explode(' ', $fline[$i]);
    if (count($line) > 1 && 'PLACE' !== $line[0]) {
        echo PHP_EOL;
        echo '====================================================';
        echo PHP_EOL;
        echo 'Invalid. Start with PLACE!';
        echo PHP_EOL;
        echo '====================================================';
        echo PHP_EOL;
        exit;
    }
    if ('PLACE' == rtrim($line[0])) {
        $store = storeXyfPlace($line[1]);
        $storeXy = $store;
    } else {
        /**
         *  MOVE LEFT RIGHT REPORT
         */
        switch (rtrim($fline[$i])) {
            case PLACE:
                storeXyfPlace($fline[$i]);
                break;
            case MOVE:
                updateXy($storeXy);
                break;
            case LEFT:
                $storeXy->lStep = true;
                $storeFNew = getFacingDirectionNew($storeXy);
                $storeXy = $storeFNew;
                break;
            case RIGHT:
                $storeXy->rStep = true;
                $storeFNew = getFacingDirectionNew($storeXy);
                $storeXy = $storeFNew;
                break;
            case REPORT:
                reportNewCoords($storeXy);
                if ($i == count($fline)) {
                    exit;
                } else {
                    break;
                }
            default:
                echo PHP_EOL;
                echo '====================================================';
                echo PHP_EOL;
                echo 'Invalid. Enter again!';
                echo PHP_EOL;
                echo '====================================================';
                echo PHP_EOL;
                exit;
        }
    }
}
?>