<?php

include "ReturnValues.php";
include "PostFetcher.php";
include "../Configurations.php";

class FormBase {
    private $return_code;
    private $database_link;
    private $master_result;
    private $post_data;

    public function return_fault($err_name, $custom_info = "") {             //程序出现错误时将会调用此方法
        $ops_code = $this->return_code->get_val($err_name);
        $this->master_result['code'] = $ops_code;
        $this->master_result['status'] = "fail";
        if (strlen($custom_info)) $this->master_result['obj'] = $custom_info;
        else $this->master_result['obj'] = $this->return_code->get_com($err_name);
        echo json_encode($this->master_result);
        $this->after_run();
    }
    public function return_success($success_name, $return_info) {                    //程序操作成功时调用此方法
        $ops_code = $this->return_code->get_val($success_name);
        $this->master_result['code'] = $ops_code;
        $this->master_result['status'] = "success";
        if (is_array($return_info)) $this->master_result['obj'] = json_encode($return_info);
        else $this->master_result['obj'] = $return_info;
        echo json_encode($this->master_result);
        $this->after_run();
    }
    private function after_run() {
        @$this->database_link->close();
        exit;
    }

    public function __construct() {
        $this->return_code = new ReturnValues();
        $this->master_result = array(
            'code' => $this->return_code->get_val("UNKNOWN_ERROR"),
            'status' => "fail",
            'obj' => "null"
        );
        $this->database_link = new mysqli(
            Configurations::get()["database"]["host"],
            Configurations::get()["database"]["user"],
            Configurations::get()["database"]["password"],
            Configurations::get()["database"]["database"]
        );
        if ($this->database_link->connect_error) {
            $this->return_fault(
                "CANNOT_CONNECT_SERVER",
                "错误({$this->database_link->connect_errno})：无法连接到服务器"
            );
        }
        $this->post_data = new PostFetcher();
    }

    public function add_return_code(string $name, int $val, string $comment = "") {
        $this->return_code->add($name, $val, $comment);
    }
    public function override_return_code(string $name, int $val, string $comment = "") {
        $this->return_code->override($name, $val, $comment);
    }

    public function add_post(string $name) {
        $this->post_data->add($name);
    }
    public function get_post(string $name) {
        return $this->post_data->valueOf($name);
    }
    public function validate_isset() {
        $this->post_data->validate();
    }
    public function report_data_error($err_name) {
        $this->return_fault($err_name);
    }
    public function validate_user(string $key) {
        $res = $this->sql_select("users", "`user_group`", "`id`='{$this->post_data->valueOf($key)}'");
        if (!$res) $this->return_fault("INVALID_USER_ID");
        if ($res["user_group"] == 'B') $this->return_fault("USER_BANNED");
    }
    public function simulate_post(string $name, string $val) {
        $this->post_data->simulate($name, $val);
    }

    public function sql_select(string $table, string $target, string $condition = "") {
        return $this->sql_select_raw($table, $target, $condition)->fetch_array(MYSQLI_ASSOC);
    }
    public function sql_select_raw(string $table, string $target, string $condition = "") {
        if (strlen($condition)) $sql_word = "SELECT {$target} FROM {$table} WHERE {$condition}";
        else $sql_word = "SELECT {$target} FROM {$table}";
        $res = $this->database_link->query($sql_word);
        if (!$res) $this->return_fault("UNKNOWN_ERROR");
        return $res;
    }
    public function sql_insert(string $table, string $target, string $values) {
        printf("INSERT INTO {$table} ({$target}) VALUES ({$values}) <br/>");
        $res = $this->database_link->query("INSERT INTO {$table} ({$target}) VALUES ({$values})");
        if (!$res) $this->return_fault("UNKNOWN_ERROR", $this->database_link->error);
        return $res;
    }
    public function sql_delete(string $table, string $condition) {
        $res = $this->database_link->query("DELETE FROM {$table} WHERE {$condition}");
        if (!$res) $this->return_fault("UNKNOWN_ERROR");
        return $res;
    }
    public function sql_update(string $table, string $values, string $condition) {
        $res = $this->database_link->query("UPDATE {$table} SET {$values} WHERE $condition");
        if (!$res) $this->return_fault("UNKNOWN_ERROR");
        return $res;
    }
}