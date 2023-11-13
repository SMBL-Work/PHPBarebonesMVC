<?php
namespace helpers;

use config\DB_Access;

/**
 * The sole purpose of this class helper is to aid in the repeating patterns of fetching rows, updating data, and inserting data
 */
class DBQuery_Helper extends DB_Access {
    public const EXPECT_BOOLEAN = 'boolean';
    public const EXPECT_INT = 'int';
    /**
     * Fetches multiple rows of data
     * @param string $sql
     * @param array $params
     * @param string $types
     * @return array returns an array of data that has multiple rows of contents
     */
    function fetchMultiRow($sql, $params = [], $types = ""){
        $stmt = $this->prepared_select($sql, $params, $types);
        while($row = $stmt->fetch_assoc()){ $data[] = $row; }
        $stmt->close();
        return $data ?? []; //if may laman si $data return it, pag wala return []
    }
    /**
     * Fetches a single row of data
     * @param string $sql
     * @param array $params
     * @param string $types
     * @return array returns an array of data that has one row of content
     */
    function fetchSingleRow($sql, $params = [], $types = ""){
        $stmt = $this->prepared_select($sql, $params, $types);
        $row = $stmt->fetch_assoc();
        $stmt->close();
        return $row  ?? []; //if may laman si $data return it, pag wala return []
    }
    /**
     * Fetches a single column data like for example if you just want the first_name column from your query
     * @param string $columnNameAlias the name of the column or alias that you want to retrieve
     * @param string $sql
     * @param array $params
     * @param string $types
     * @return mixed|null returns a value or null if nothing was returned
     */
    function fetchSingleColumn($columnNameAlias, $sql, $params = [], $types = ""){
        return $this->fetchSingleRow($sql, $params, $types)[$columnNameAlias] ?? null;
    }
    /**
     * @return boolean|int returns true if the update was a success and false if its not or returns the number of rows affected
     */
    function updateRow($sql, $params = [], $types = "", $options=self::EXPECT_BOOLEAN){
        $stmt = $this->prepared_query($sql, $params, $types);
        $affectedCount = $stmt->affected_rows;
        $stmt->close();
        switch($options){
            case self::EXPECT_BOOLEAN:
                return ($affectedCount != 0) ? true : false;
            break;
            case self::EXPECT_INT:
                return $affectedCount ?? 0;
            break;
        }
    }
    /**
     * @return int|boolean returns the created row id primary key or returns either true or false
     */
    function insertRow($sql, $params = [], $types = "", $options=self::EXPECT_INT){
        $stmt = $this->prepared_query($sql, $params, $types);
        $affectedCount = $stmt->affected_rows;
        $rowInserted = ($stmt->affected_rows !=0) ? $stmt->insert_id : 0;
        $stmt->close();
        switch($options){
            case self::EXPECT_INT:
                return $rowInserted;
            break;
            case self::EXPECT_BOOLEAN:
                return ($affectedCount != 0) ? true : false;
            break;
        }
    }
}