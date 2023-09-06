<?php
namespace config;

use mysqli;

class DB_Access{
    private $dbServerName = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "u443412455_pa_dev";
    
    public mysqli $dbConnection; //usage when extending to this class you may use statement like: $this->dbConnection->query("SELECT * from SomeTable";)
    function __construct(){
        $this->dbConnection = new mysqli($this->dbServerName,$this->dbUsername,$this->dbPassword,$this->dbName) or die("unable to connect");
        if($this->dbConnection->connect_errno){
            echo "Database Connection Error";
        }
        $this->dbConnection->query("SET time_zone = '+08:00' ");
    }
    
    //Sample usage for prepared_query()
    //$stmt = prepared_query($this->dbConnection,"UPDATE users SET active_flag=?, username=? WHERE user_id=?",[$activeFlag,$username,$userID],"isi");
    /**
     * Creates a prepared statement
     * @param mysqli $mysqli receives a mysqli database connection
     * @param string $sql receives a string of sql statement that has question marks
     * @param array $params receives an array of variables that you want to insert in your question mark placeholders, make sure to type them in the order of how you placed the question marks
     * @param string $types receives a string of data types, example: "issi" they are typed in the order of how you typed the question marks that expects a specific data type. For example you want to prepare the query for a user id, then you must put "i"
     * @return mixed
     */
    function prepared_query($mysqli, $sql, $params, $types = "")
    {
        $types = $types ?: str_repeat("s", count($params));
        $stmt = $mysqli->prepare($sql);

        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }

    // Sample Usage [usually used to avoid get_result()]:
    // $start = 0;
    // $limit = 10;
    // $sql = "SELECT * FROM users LIMIT ?,?";
    // $user_list = prepared_select($mysqli, $sql, [$start, $limit])->fetch_all(MYSQLI_ASSOC);
    /**
     * Does the same thing as prepared query but avoids the need to call get_result() after, which can help in fetching associative arrays
     * @param mysqli $mysqli receives a mysqli database connection
     * @param string $sql receives a string of sql statement that has question marks
     * @param array $params receives an array of variables that you want to insert in your question mark placeholders, make sure to type them in the order of how you placed the question marks
     * @param string $types receives a string of data types, example: "issi" they are typed in the order of how you typed the question marks that expects a specific data type. For example you want to prepare the query for a user id, then you must put "i"
     * @return mixed
     */
    function prepared_select($mysqli, $sql, $params = [], $types = "") {
        return $this->prepared_query($mysqli, $sql, $params, $types)->get_result();
    }

    //For more info where I got this helper visit the following url:
    //https://phpdelusions.net/mysqli_examples/prepared_select
    //https://phpdelusions.net/mysqli/simple
}

?>