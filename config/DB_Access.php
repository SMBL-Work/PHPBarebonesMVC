<?php
namespace config;
use mysqli;
class DB_Access{
    private $dbServerName = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "dbname";
    
    //usage when extending to this class you may use statement like: $this->dbConnection->query("SELECT * from SomeTable";)
    public static mysqli $dbConnection;
    public function __construct(){
        // $this->dbConnection = new mysqli($this->dbServerName,$this->dbUsername,$this->dbPassword,$this->dbName);
        self::$dbConnection = new mysqli($this->dbServerName,$this->dbUsername,$this->dbPassword,$this->dbName);
        if(self::$dbConnection->connect_errno){
            echo "Database Connection Error";
        }
        self::$dbConnection->query("SET time_zone = '+08:00' ");
    }
    function getServerTime($humanReadable=false){
        $sql = "SELECT CURRENT_TIMESTAMP() as ServerTime";
        if($humanReadable){
            $sql = "SELECT DATE_FORMAT(CURRENT_TIMESTAMP(), '%M %e, %Y %l:%i %p') as ServerTime";
        }
        $stmt = self::$dbConnection->query($sql);
        $row = $stmt->fetch_assoc();
        $stmt->close();
        return $row['ServerTime'];
    }
    //Sample usage for prepared_query()
    //$stmt = prepared_query($this->dbConnection,"UPDATE users SET active_flag=?, username=? WHERE user_id=?",[$activeFlag,$username,$userID],"isi");
    /**
     * Creates a prepared statement
     * @param string $sql receives a string of sql statement that has question marks
     * @param array $params receives an array of variables that you want to insert in your question mark placeholders, make sure to type them in the order of how you placed the question marks
     * @param string $types receives a string of data types, example: "issi" they are typed in the order of how you typed the question marks that expects a specific data type. For example you want to prepare the query for a user id, then you must put "i"
     * @return mixed
     */
    function prepared_query($sql, $params, $types = "")
    {
        $types = $types ?: str_repeat("s", count($params));
        $stmt = self::$dbConnection->prepare($sql);

        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }

    /**
     * Does the same thing as prepared query but avoids the need to call get_result() after, which can help in fetching associative arrays
     * @param string $sql receives a string of sql statement that has question marks
     * @param array $params receives an array of variables that you want to insert in your question mark placeholders, make sure to type them in the order of how you placed the question marks
     * @param string $types receives a string of data types, example: "issi" they are typed in the order of how you typed the question marks that expects a specific data type. For example you want to prepare the query for a user id, then you must put "i"
     * @return mixed
     */
    function prepared_select($sql, $params = [], $types = "") {
        return $this->prepared_query($sql, $params, $types)->get_result();
    }

    //For more info where I got this helper visit the following url:
    //https://phpdelusions.net/mysqli_examples/prepared_select
    //https://phpdelusions.net/mysqli/simple
    
}

?>