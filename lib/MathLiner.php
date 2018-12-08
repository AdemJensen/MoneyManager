<?php

class MathLiner {
    private $k;
    private $b; //y = kx + b
    public function __construct(float $k_a_x1, float $b_b_y1, float $c_x2 = null, float $y2 = null) {
        if ($y2 != null) {
            //(x1, y1), (x2, y2)
            $this->k = ($y2 - $b_b_y1) / ($c_x2 - $k_a_x1);
            $this->b = $b_b_y1 - $this->k * $k_a_x1;
        } else {
            if ($c_x2 != null) {
                //Ax + By + C = 0
                $this->k = - $k_a_x1 / $b_b_y1;
                $this->b = - $c_x2 / $b_b_y1;
            } else {
                $this->k = $k_a_x1;
                $this->b = $b_b_y1;
            }
        }
    }
    public function get_y(float $x) {
        return $this->k * $x + $this->b;
    }
    public function get_x(float $y) {
        return ($y - $this->b) / $this->k;
    }
    public function line_move(float $x, float $len) {
        $x_len = cos(atan($this->k)) * $len;
        //printf("Fetched_by_line_move: x = $x, len = $len, x_len = $x_len<br>");
        return array("x" => $x + $x_len, "y" => $this->get_y($x + $x_len));
    }
    public function mk_normal(float $x, float $y) {//法线
        $this->k = -(1.0 / $this->k);
        $this->b = $y - $this->k * $x;
    }
    public function __toString() {
        return "y = " . $this->k . "x + " . $this->b;
    }
}