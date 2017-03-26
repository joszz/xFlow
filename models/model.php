<?php
/** The parent class for each model, defining basic Model functionality
 *  @package    Framework
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */

abstract class Model {
    protected   $settings;
    protected   $dbLink;
    
    /** The constructor of each Model, setting $settings to a local variable and calling setDBLink to establish a DB connection.
     *  @param      array               $settings           The array of settings defined in config.php
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */  
    public function Model($settings){
        $this->settings = $settings;
        $this->setDBLink();
    }
    
    /** Connects to the database, with credentials defined in config.php
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */    
    private function setDBLink(){
        if(empty($this->dbLink)){
            $this->dbLink = mysqli_connect($this->settings['db']['host'], 
                                          $this->settings['db']['user'], 
                                          $this->settings['db']['pass']) or die(mysql_error());    
            $this->setDatabaseName();
        }
    }
    
    /** Must be defined by each model to select a database
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */   
    protected abstract function setDatabaseName();
    
    /** Wrapper for mysql_query()
     *  @param      string              $query          Query string
     *  @return     MySQL resultset                     The result of the query
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */    
    final public function query($query){
        $query = mysqli_query($this->dbLink, $query) or die(mysql_error());
        return $query;
    }
    
    /** Wrapper for mysql_fetch_assoc() and mysql_fetch_array, retrieving single row
     *  @param      MySQL resultset     $result         The resultset to fetch
     *  @param      boolean             $assoc          Whether to fetch as array or assoc
     *  @return     array                               An array with data from the DB, either associative or index (mysql_fetch_array())                    
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */    
    final public function fetch($result, $assoc = true){
        return $assoc ? mysqli_fetch_assoc($result) : mysqli_fetch_array($result);
    }
    
    /** Wrapper for mysql_fetch_assoc() and mysql_fetch_array, but instead of fetch retrieves all rows
     *  @param      MySQL resultset     $result         The resultset to fetch
     *  @param      boolean             $assoc          Whether to fetch as array or assoc
     *  @return     array                               An array with data from the DB, either associative or index (mysql_fetch_array()) for all rows of the resultset                   
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      04-04-2014
     */   
    final public function fetchAll($result, $assoc = true){
        $values = array();

        while($row = ($assoc ? mysqli_fetch_assoc($result) : mysqli_fetch_array($result))) $values[] = $row;

        return $values;
    }
    
    /** Wrapper for mysql_real_escape_string()
     *  @param      string $value The string to escape
     *  @return     string        Escaped value
     * 
     *  @version    0.1
     *  @author     Jos Nienhuis
     *  @since      08-04-2014
     */ 
    final public function escape($value){
        return mysql_real_escape_string($value, $this->dbLink);
    }
}
?>
