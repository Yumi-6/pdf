<?php
class conect {
    public $host ="localhost";
    public $user = "root";
    public $pass = "";
    public $db = "felizander";
    public $conn;

    public function conn() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if (! $this->conn) {
            return die("erro ao estabelecer ligacão".mysqli_connect_error());
        }
        return $this->conn;
    }
}