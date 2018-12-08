<?php

class MathCircle {
    private $x;
    private $y;
    private $r;
    public function __construct(float $x, float $y, float $r) {
        $this->x = $x;
        $this->y = $y;
        $this->r = $r;
    }
    public function intersection(MathCircle $alter) {
        if ($this->x > $alter->x) return $alter->intersection($this);
        $dist = Basic::point_dist($this->x, $this->y, $alter->x, $alter->y);//圆心点距离
        //printf("|number 1: %f, %f, %f|<br>", $this->x, $this->y, $dist);///////////////////
        if ($alter->r + $this->r < $dist) return array();
        else if ($alter->r + $this->r == $dist) {
            if ($this->x == $alter->x) return array( 0 => array("x" => ($this->x) / 1000, "y"=> ($this->y - $this->r)) / 1000);
        } else {//$alter->r + $this->r > $dist
            $triangle_s = Basic::herons_eqa($this->r, $alter->r, $dist);//由两个半径和圆心连线组成的半三角形面积
            //printf("triangle = $triangle_s <br/>");
            $vertical_len = $triangle_s / $dist;//半三角形的高
            if ($this->x == $alter->x) return array(
                0 => array("x" => ($this->x + $vertical_len) / 1000, "y"=> ($this->y - $this->r) / 1000),
                1 => array("x" => ($this->x - $vertical_len) / 1000, "y"=> ($this->y - $this->r) / 1000)
            );
            else {
                $line = new MathLiner($this->x, $this->y, $alter->x, $alter->y);//圆心连接线
                //printf("Original_line:%s<br>", $line);///////////////////////////////////
                $dist_this = sqrt($this->r * $this->r - $vertical_len * $vertical_len);//圆心到法线的距离
                $normal_intersection = $line->line_move($this->x, $dist_this);//通过dist_this算出法线
                //printf("Calc_point:(%f, %f)<br>", $normal_intersection["x"], $normal_intersection["y"]);///////////////////////////////////
                //printf("Mid_point:(%f, %f)<br>", ($this->x + $alter->x) / 2, ($this->y + $alter->y) / 2);///////////////////////////////////
                $line->mk_normal($normal_intersection["x"], $normal_intersection["y"]);//通过dist_this算出法线
                //printf("Normal_line:%s<br>", $line);///////////////////////////////////
                $line_move_1 = $line->line_move($normal_intersection["x"], $vertical_len);
                $line_move_2 = $line->line_move($normal_intersection["x"], -$vertical_len);
                return array(
                    0 => array("x" => $line_move_1["x"] / 1000, "y"=> $line_move_1["y"] / 1000),
                    1 => array("x" => $line_move_2["x"] / 1000, "y"=> $line_move_2["y"] / 1000)
                );
            }
        }
        return array();
        /*$a = 2 * $this->r * ($this->x - $alter->x);
        $b = 2 * $this->r * ($this->y - $alter->y);
        $c = $alter->r * $alter->r - $this->r * $this->r - ($this->x - $alter->x) * ($this->x - $alter->x) - ($this->y - $alter->y) * ($this->y - $alter->y);
        $aa = $a * $a + $b * $b;
        $bb = -2 * $a * $c;
        $cc = $c * $c - $b - $b;
        printf("solve: %fx2 + %fx + %f = 0<br>", $aa, $bb, $cc);////////////////
        $delta = $bb * $bb - 4 * $aa * $cc;
        if ($delta < 0) return array();
        else if ($delta == 0) return array(0 => array("x" => -$bb / (2 * $aa) / 1000, "y"=> $this->y = sqrt($this->r * $this->r - (-$bb / (2 * $aa) - $aa) * (-$bb / (2 * $aa) - $aa)) + $bb) / 1000);
        else return array(
            0 => array("x" => (-$bb + sqrt($delta)) / (2 * $aa) / 1000, "y"=> $this->y = sqrt($this->r * $this->r - ((-$bb + sqrt($delta)) / (2 * $aa)) * ((-$bb + sqrt($delta)) / (2 * $aa)) + $bb) / 1000),
            1 => array("x" => (-$bb - sqrt($delta)) / (2 * $aa) / 1000, "y"=> $this->y = sqrt($this->r * $this->r - ((-$bb - sqrt($delta)) / (2 * $aa)) * ((-$bb - sqrt($delta)) / (2 * $aa)) + $bb) / 1000)
        );*/
    }
    public function __toString() {
        return "(x - " . $this->x . ")2 + (y - " . $this->y . ")2 = " . $this->r;
    }
}