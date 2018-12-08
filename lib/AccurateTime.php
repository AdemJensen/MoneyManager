<?php

class AccurateTime {
    private $year = 0;
    private $month = 0;
    private $day = 0;
    private $hour = 0;
    private $minute = 0;
    private $second = 0;
    public function __construct($string = null) {
        if (isset($string)) {
            $this->str_assign($string);
        } else {
            $this->current_time();
        }
    }
    private function rec_sub_ops(&$var1, &$var2, $division) {
        while ($var1 < 0) {
            $var1 += $division;
            $var2--;
        }
        $var2 += (int) ($var1 / $division);
        $var1 %= (int) ($division);
    }
    private static function is_leap_year($year) {
        return ($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0;
    }
    private static function get_month_day($year, $month) {
        switch ($month) {
            case 1: return 31;
            case 2: return self::is_leap_year($year) ? 29 : 28;
            case 3: return 31;
            case 4: return 30;
            case 5: return 31;
            case 6: return 30;
            case 7: return 31;
            case 8: return 31;
            case 9: return 30;
            case 10: return 31;
            case 11: return 30;
            case 12: return 31;
        }
        return -1;
    }
    private function reconstruct() {
        $this->rec_sub_ops($this->second, $this->minute, 60);
        $this->rec_sub_ops($this->minute, $this->hour, 60);
        $this->rec_sub_ops($this->hour, $this->day, 24);
        $this->month--;
        $this->rec_sub_ops($this->month, $this->year, 12);
        $this->month++;
        while ($this->day > self::get_month_day($this->year, $this->month)) {
            $this->day -= self::get_month_day($this->year, $this->month);
            $this->month++;
            if ($this->month > 12) {
                $this->month -= 12;
                $this->year++;
            }
        }
        while ($this->day <= 0) {
            $this->month--;
            if ($this->month <= 0) {
                $this->month += 12;
                $this->year--;
            }
            $this->day += self::get_month_day($this->year, $this->month);
        }
    }
    public function str_assign($string) {
        $result = Array();
        preg_match_all("/\d+/", $string, $result);
        $this->year = (int)$result[0][0];
        $this->month = (int)$result[0][1];
        $this->day = (int)$result[0][2];
        $this->hour = (int)$result[0][3];
        $this->minute = (int)$result[0][4];
        $this->second = (int)$result[0][5];
    }
    public function int_assign($y, $M, $d, $h, $m, $s) {
        $this->year = $y;
        $this->month = $M;
        $this->day = $d;
        $this->hour = $h;
        $this->minute = $m;
        $this->second = $s;
    }
    public function current_time() {
        date_default_timezone_set('PRC');
        $this->str_assign(date("Y-m-d H:i:s"));
    }
    public function add($d, $h, $m, $s) {
        $this->day += $d;
        $this->hour += $h;
        $this->minute += $m;
        $this->second += $s;
        $this->reconstruct();
    }
    public function get_year() {
        return $this->year;
    }
    public function get_month() {
        return $this->month;
    }
    public function get_day() {
        return $this->day;
    }
    public function get_hour() {
        return $this->hour;
    }
    public function get_minute() {
        return $this->minute;
    }
    public function get_second() {
        return $this->second;
    }
    public function smaller_than(AccurateTime $alter) {
        if ($this->year > $alter->year) return 0;
        if ($this->year < $alter->year) return 1;
        if ($this->month > $alter->month) return 0;
        if ($this->month < $alter->month) return 1;
        if ($this->day > $alter->day) return 0;
        if ($this->day < $alter->day) return 1;
        if ($this->hour > $alter->hour) return 0;
        if ($this->hour < $alter->hour) return 1;
        if ($this->minute > $alter->minute) return 0;
        if ($this->minute < $alter->minute) return 1;
        if ($this->second >= $alter->second) return 0;
        return 1;
    }
    public function bigger_than(AccurateTime $alter) {
        return $alter->smaller_than($this);
    }
    public function equals(AccurateTime $alter) {
        return $this->year == $alter->year &&
            $this->month == $alter->month &&
            $this->day == $alter->day &&
            $this->hour == $alter->hour &&
            $this->minute == $alter->minute &&
            $this->second == $alter->second;
    }
    public function expired($d = 0, $h = 0, $m = 0, $s = 0) {
        $target_time = $this;
        $target_time->add($d, $h, $m, $s);
        return $target_time->smaller_than(new AccurateTime());
    }
    public function __toString() {
        return sprintf("%04d-%02d-%02d %02d:%02d:%02d", $this->year, $this->month, $this->day, $this->hour, $this->minute, $this->second);
    }
}