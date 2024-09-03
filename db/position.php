<?php
class Positon
{
    public $db = null;
    public function __construct(DBController $db)
    {
        if (!(isset($db->con))) return null;
        $this->db = $db;
    }


    public function getData($table = 'position')
    {
        $result = $this->db->con->query("SELECT * FROM {$table}");
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (count($array) > 0) {
            return $array;
        }
    }


    public function deleteData($position_id = null, $table = 'position')
    {
        if ($position_id != null) {
            $result = $this->db->con->query("DELETE FROM {$table} WHERE {$table}.`position_id`={$position_id}");
            return $result;
        }
    }


    public function addData($position_name = null, $table = 'position')
    {
        $add_query = "INSERT INTO {$table} (`position_name`) VALUES ('$position_name')";
        $result = $this->db->con->query($add_query);
        return $result;
    }
}
