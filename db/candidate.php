<?php
class Candidate
{
    public $db = null;
    public function __construct(DBController $db)
    {
        if (!(isset($db->con))) return null;
        $this->db = $db;
    }
    public function getData($table = 'candidate')
    {
        $result = $this->db->con->query("SELECT * FROM {$table}");
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (count($array) > 0) {
            return $array;
        }
    }
    public function deleteData($candidate_id = null, $table = 'candidate')
    {
        $delete_query = "DELETE FROM {$table} WHERE {$table}.`candidate_id`={$candidate_id}";
        $result = $this->db->con->query($delete_query);
        return $result;
    }
    public function addData($candidate_name = null, $candidate_position = null, $table = 'candidate')
    {
        $add_query = "INSERT INTO {$table} (`candidate_name`,`candidate_position`) VALUES ('$candidate_name','$candidate_position')";
        $result = $this->db->con->query($add_query);
        return $result;
    }
}
