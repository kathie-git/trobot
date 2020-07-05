<?php

include 'Includes/constants.php';

class XyfPlace
{
    public $x;
    public $y;
    public $f;
}

class XyfStore
{
    public $x = 0;
    public $y = 0;
    public $f;
    public $fNew;
    public $lr;
    public $lStep = false;
    public $rStep = false;
}

function storeXyfPlace($linePlace)
{
    /**
     *  e.g PLACE 0,0,NORTH
     */
    $dataStore = new XyfStore();
    $line = explode(',', $linePlace);

    if (!is_numeric(rtrim($line[0])) || !is_numeric(rtrim($line[1]))) {
        echo PHP_EOL;
        echo '====================================================';
        echo PHP_EOL;
        echo 'Invalid. Enter again!';
        echo PHP_EOL;
        echo '====================================================';
        echo PHP_EOL;
        exit;
    }
    $dataStore->x = intval($line[0]);
    $dataStore->y = intval($line[1]);
    $dataStore->f = rtrim($line[2]);
    $dataStore->fNew = rtrim($line[2]);

    return $dataStore;
}

function setLR($lrFlag)
{
    $lStore = new XyfStore();
    if (LEFT == $lrFlag) {
        $lStore->lStep = true;
    } else {
        $lStore->rStep = true;
    }
    // get f direction new
    $fPlace = new XyfPlace();
    $lStore->f = $fPlace->f;
    getFacingDirectionNew();
    return;
}

function updateXy($dStore)
{
    /**
     *  Can't move further South from y=0
     *  Can't go beyond 0,0
     */
    if ((SOUTH == $dStore->f) && (0 == $dStore->y)) {
        echo 'Invalid. Enter again!';
        exit;
    }
    /**
     *   Can't move further West from x=0
     *   Can't go beyond 0,0
     */
    if ((WEST == $dStore->f) && (0 == $dStore->x)) {
        echo 'Invalid. Enter again!';
        exit;
    }
    /**
     *   Can't go beyond y = 5
     */
    if ((NORTH == $dStore->f) && (5 == $dStore->y)) {
        echo 'Invalid. Enter again!';
        exit;
    }
    /**
     *   Can't go beyond x = 5
     */
    if ((EAST == $dStore->f) && (5 == $dStore->x)) {
        echo 'Invalid. Enter again!';
        exit;
    }
    /**
     *   Update x or y
     */
    if (EAST == $dStore->f || WEST == $dStore->f) {
        $dStore->x = $dStore->x + 1;
    } elseif (NORTH == $dStore->f || SOUTH == $dStore->f) {
        $dStore->y = $dStore->y + 1;
    }
    return $dStore;
}

function getFacingDirectionNew($store)
{

    $coordsMatrixes = array
    (
        "NORTH" => array
        (
            "LEFT" => "WEST",
            "RIGHT" => "EAST",
        ),
        "SOUTH" => array
        (
            "LEFT" => "EAST",
            "RIGHT" => "WEST",
        ),
        "EAST" => array
        (
            "LEFT" => "NORTH",
            "RIGHT" => "SOUTH",
        ),
        "WEST" => array
        (
            "LEFT" => "SOUTH",
            "RIGHT" => "NORTH",
        ),
    );
    if ($store->lStep) {
        $lr = LEFT;
    } else {
        $lr = RIGHT;

    }
    foreach ($coordsMatrixes as $facingNEWSPlace => $leftRight) {
        if ($facingNEWSPlace == $store->f) {
            foreach ($leftRight as $leftRightStep => $newsNew) {
                if ($leftRightStep == $lr) {
                    $store->fNew = $newsNew;
                    return $store;
                }
            }
        }
    }
}

function reportNewCoords($store)
{
    echo PHP_EOL;
    echo '=========================================================';
    echo PHP_EOL;
    echo 'The new Coordinates: ' . $store->x . ',' . $store->y . ',' . $store->fNew;
    echo PHP_EOL;
    echo '=========================================================';
    echo PHP_EOL;
    return;
}
?>