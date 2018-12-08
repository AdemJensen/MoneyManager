<?php

include "MathLiner.php";
include "MathCircle.php";

class Basic {
    public static function swap(&$a, &$b) {
        $c = $b;
        $b = $a;
        $a = $c;
    }

    public static function herons_eqa(float $a, float $b, float $c) {
        $p = ($a + $b + $c) / 2;
        //printf("Herons: $a, $b, $c = %f <br/>", sqrt($p * ($p - $a) * ($p - $b) * ($p - $c)));
        return sqrt($p * ($p - $a) * ($p - $b) * ($p - $c));
    }

    public static function point_dist(float $x1, float $y1, float $x2, float $y2) {
        return sqrt(($x1 - $x2) * ($x1 - $x2) + ($y1 - $y2) * ($y1 - $y2));
    }

    public static function point_middle(float $x1, float $y1, float $x2, float $y2) {
        return array("x" => ($x1 + $x2), "y" => ($y1 + $y2));
    }
}