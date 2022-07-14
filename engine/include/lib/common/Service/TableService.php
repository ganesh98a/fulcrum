<?php

class TableService
{
    /**
        * user_id provides the linkage to third parties via contacts table FK
        * and primary_contact_id is how we filter out any "Owned Projects"
        *
        * @param string $database
        * @param string $table - tell which table it should use
        * @param string $column - column name to be updated
        * @param string $primary_id - id which has to be updated
        * @param string $new_val -value to be updated
        primary_id
        * @return array
    */
    //To update a value in a table
    public static function UpdateTabularData($database,$table,$column,$primary_id,$new_val)
    {
        $db = DBI::getInstance($database);
        $query ="UPDATE  $table SET $column=? WHERE `id` = ? ";
        $arrValues = array($new_val,$primary_id);
        if( $db->execute($query, $arrValues, MYSQLI_USE_RESULT))
        {
            $res_value='1';
        }else
        {
            $res_value='0';
        }
        $db->free_result();
        return $res_value;
    }
    /**
     *
     * @param string $database
     * @param string $table - tell which table it should use
     * @param string $field - column name to get
     * @param string $mapid - id which has to be get
     * @param string $mapvalue - value which has to be get
     
     primary_id
     * @return array
     */
    //To get a single value in a table
    public static function getSingleField($database,$table,$field,$mapfield,$mapvalue)
    {
        $db = DBI::getInstance($database);
        $query ="SELECT $field from $table WHERE $mapfield = ?";
        $arrValues = array($mapvalue);
        $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
        $row = $db->fetch();
        $resfield = $row[$field];
        $db->free_result();
        return $resfield;
    }
    /* To get the values from Table
    @param string $database : Connection String
    @param array  $options :
        fields : Selected Fields (Default : Select all Fields),
        filter : Condition parameters,
        multiple : true or false (Default : false)
        table : Table Name


    */

    public static function GetTabularData($database, $options = array()){
        $db = DBI::getInstance($database);
        $db->free_result();

        if(!empty($options['table'])){
            $table_name = $options['table'];
        }else{
            die('notablepassed');
        }

        $limitBy = " Limit 1";
        if(!empty($options['multiple']) && $options['multiple'] =='true'){
            $limitBy = "";
        }
        $field = ' * ';
        if(!empty($options['fields'])){
            $field = implode(', ' , $options['fields']);
        }
        $filter = '1';
        $arrValues = array();
        if(!empty($options['filter'])){

            $filter = implode(' AND ',array_keys($options['filter']));
            $arrValues = array_values($options['filter']);
        }
        
        $getQuery = "SELECT ".$field." FROM ".$table_name." WHERE ".$filter." ".$limitBy;
        $db->execute($getQuery, $arrValues, MYSQLI_USE_RESULT);
        if(!empty($options['multiple']) && $options['multiple'] =='true'){
            $return_arr = array();
            while($getRow = $db->fetch()){
                $return_arr[] = $getRow;
            }
        }else{
          $return_arr = $db->fetch();
        }
        $db->free_result();
        return $return_arr;
    }

    /**
     * To update multiple value in a table using multiple condition 
     *
     * @param $database : Connection String
     * @param $options  : array of parameters 
     *          table : Table Name
                update : array of update field and value
                filter : Condition parameters                
     * @return array
     */
    public static function UpdateMultipleTabularData($database, $options = array())
    {
        $db = DBI::getInstance($database);

        if(!empty($options['table'])){
            $table_name = $options['table'];
        }else{
            die('notablepassed');
        }        

        $arrUpdate = array();
        if(!empty($options['update'])){

            $update = implode(' , ',array_keys($options['update']));
            $arrUpdate = array_values($options['update']);
        }

        $filter = '1';
        $arrFilter = array();
        if(!empty($options['filter'])){

            $filter = implode(' AND ',array_keys($options['filter']));
            $arrFilter = array_values($options['filter']);
        }

        $arrValues = array_merge($arrUpdate,$arrFilter);

        $query = "UPDATE ".$table_name." SET ".$update." WHERE ".$filter;
        
        if( $db->execute($query, $arrValues, MYSQLI_USE_RESULT))
        {
            $res_value='1';
        }else
        {
            $res_value='0';
        }
        $db->free_result();
        return $res_value;
    }

    /**
     * To delete row in table using multiple condition 
     *
     * @param $database : Connection String
     * @param $options  : array of parameters 
     *          table : Table Name
                update : array of update field and value
                filter : Condition parameters                
     * @return array
     */
    public static function DeleteTableRow($database, $options = array())
    {
        $db = DBI::getInstance($database);

        if(!empty($options['table'])){
            $table_name = $options['table'];
        }else{
            die('notablepassed');
        }        

        $filter = '1';
        $arrValues = array();
        if(!empty($options['filter'])){

            $filter = implode(' AND ',array_keys($options['filter']));
            $arrValues = array_values($options['filter']);
        }

        $query = "DELETE FROM ".$table_name." WHERE ".$filter;
        
        if( $db->execute($query, $arrValues, MYSQLI_USE_RESULT))
        {
            $res_value='1';
        }else
        {
            $res_value='0';
        }
        $db->free_result();
        return $res_value;
    }

}
