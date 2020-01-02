<?php
  /** A PHP class to access MySQL database with convenient methods
    * in an object oriented way, and with a powerful debug system.\n
    * Licence:  LGPL \n
    * Web site: http://slaout.linux62.org/
    * @version  1.0
    * @author   S&eacute;bastien Lao&ucirc;t (slaout@linux62.org)
    */
  class DB {
    /** Put this variable to true if you want ALL queries to be debugged by default:
      */
	  
	private $defaultDebug=false;

    /** INTERNAL: The start time, in miliseconds.
      */
	private $mtStart;
    /** INTERNAL: The number of executed queries.
      */
	private $nbQueries;
    /** INTERNAL: The last result ressource of a query().
      */
	private $lastResult;

  private $mysqli;

    /** Connect to a MySQL database to be able to use the methods below.
      */
	function __construct($base, $server, $user, $pass){
      $this->mtStart    = $this->getMicroTime();
      $this->nbQueries  = 0;
      $this->lastResult = NULL;
      $this->mysqli = new mysqli($server, $user, $pass, $base) or die('Server connexion not possible.');
    }
	
    /** Query the database.
      * @param $query The query.
      * @param $debug If true, it output the query and the resulting table.
      * @return The result of the query, to use with fetchNextObject().
      */
	public function query($query, $debug = -1){
    $this->nbQueries++;

    if (strtolower(substr(trim($query),0,6)) == "insert") {
      return $this->insert($query);
    } else {
      $this->lastResult = $this->mysqli->query($query);
			$this->debug($debug, $query, $this->lastResult);
			return $this->lastResult;
		}
  }
	
	public function alter($query){
		if($this->query($query)){
			return true;
		}else{
			return false;
		}
	}
	public function insert($query){
		$this->execute($query);
		return $this->lastInsertedId();
	}

    /** Do the same as query() but do not return nor store result.\n
      * Should be used for INSERT, UPDATE, DELETE...
      * @param $query The query.
      * @param $debug If true, it output the query and the resulting table.
      */
	public function execute($query, $debug = -1){
      $this->nbQueries++;
      $this->mysqli->query($query) or $this->debugAndDie($query);

      $this->debug($debug, $query);
    }
    /** Convenient method for $result->fetch_object.
      * @param $result The ressource returned by query(). If NULL, the last result returned by query() will be used.
      * @return An object representing a data row.
      */
	// public function fetchNextObject($result = NULL){
 //      if ($result == NULL)
 //        $result = $this->lastResult;

 //      $this->consoleLog(__LINE__, $result->num_rows);
 //      $this->consoleLog(__LINE__, $result->fetch_object);

 //      if ($result == NULL || $result->num_rows < 1)
 //        return NULL;
 //      else
 //        return $result->fetch_object;
 //    }
	/** Obtiene un array con todos los objetos
	  */
   
   /** Get the result of the query as an object. The query should return a unique row.\n
      * Note: no need to add "LIMIT 1" at the end of your query because
      * the method will add that (for optimisation purpose).
      * @param $query The query.
      * @param $debug If true, it output the query and the resulting row.
      * @return An object representing a data row (or NULL if result is empty).
      */
  public function getObjeto($query, $debug = -1){
      $query = "$query LIMIT 1";

      $this->nbQueries++;
      $result = $this->query($query) or $this->debugAndDie($query);

      $this->debug($debug, $query, $result);

      return $result->fetch_object();
    }

	public function getObjetos($query){
		$result=$this->query($query);

    if($result==NULL){
      $result = $this->lastResult;
    }

    if($result==NULL){
      return NULL;
    }else{

      if($result->num_rows>0){
        $array=array();

        while ($row = $result->fetch_object()) {
          $array[]=$row;
        }

				return $array;
			}else{
				return NULL;
			}
		} 
	}
	
    /** Get the number of rows of a query.
      * @param $result The ressource returned by query(). If NULL, the last result returned by query() will be used.
      * @return The number of rows of the query (0 or more).
      */
	public function numRows($result = NULL){
      if ($result == NULL)
        return $result->num_rows>lastResult;
      else
        return $result->num_rows;
    }
    /** Get the result of the query as value. The query should return a unique cell.\n
      * Note: no need to add "LIMIT 1" at the end of your query because
      * the method will add that (for optimisation purpose).
      * @param $query The query.
      * @param $debug If true, it output the query and the resulting value.
      * @return A value representing a data cell (or NULL if result is empty).
      */
	public function queryValue($query, $debug = -1){
      $query = "$query LIMIT 1";

      $this->nbQueries++;
      $result = $this->query($query) or $this->debugAndDie($query);
      $line = $this->mysqli->fetch_row($result);

      $this->debug($debug, $query, $result);

      return $line[0];
    }
    /** Get the maximum value of a column in a table, with a condition.
      * @param $column The column where to compute the maximum
      * @param $table The table where to compute the maximum
      * @param $where The condition before to compute the maximum.
      * @return The maximum value (or NULL if result is empty).
      */
	public function maxOf($column, $table, $where){
      return $this->queryValue("SELECT MAX(`$column`) FROM `$table` WHERE $where");
    }
    /** Get the maximum value of a column in a table.
      * @param $column The column where to compute the maximum.
      * @param $table The table where to compute the maximum.
      * @return The maximum value (or NULL if result is empty).
      */
	public function maxOfAll($column, $table){
      return $this->queryValue("SELECT MAX(`$column`) FROM `$table`");
    }
    /** Get the count of rows in a table, with a condition.
      * @param $table The table where to compute the number of rows.
      * @param $where The condition before to compute the number or rows.
      * @return The number of rows (0 or more).
      */
	public function countOf($table, $where){
      return $this->queryValue("SELECT COUNT(*) FROM `$table` WHERE $where");
    }
    /** Get the count of rows in a table.
      * @param $table The table where to compute the number of rows.
      * @return The number of rows (0 or more).
      */

	public function countOfAll($table){

      return $this->queryValue("SELECT COUNT(*) FROM `$table`");

    }

    /** Internal function to debug when MySQL encountered an error,

      * even if debug is set to Off.

      * @param $query The SQL query to echo before diying.

      */

	private function debugAndDie($query){
    $this->debugQuery($query, "Error");
    // die("<p style=\"margin: 2px;\">".$this->mysqli->error()."</p></div>");
    die("<p style=\"margin: 2px;\">".$this->mysqli->connect_errno."</p></div>");
  }

    /** Internal function to debug a MySQL query.\n

      * Show the query and output the resulting table if not NULL.

      * @param $debug The parameter passed to query() functions. Can be boolean or -1 (default).

      * @param $query The SQL query to debug.

      * @param $result The resulting table of the query, if available.

      */

	private function debug($debug, $query, $result = NULL){

      if ($debug === -1 && $this->defaultDebug === false)

        return;

      if ($debug === false)

        return;



      $reason = ($debug === -1 ? "Default Debug" : "Debug");

      $this->debugQuery($query, $reason);

      if ($result == NULL)

        echo "<p style=\"margin: 2px;\">Number of affected rows: ".$this->mysqli->affected_rows()."</p></div>";

      else

        $this->debugResult($result);

    }

    /** Internal function to output a query for debug purpose.\n

      * Should be followed by a call to debugResult() or an echo of "</div>".

      * @param $query The SQL query to debug.

      * @param $reason The reason why this function is called: "Default Debug", "Debug" or "Error".

      */

	private function debugQuery($query, $reason = "Debug"){
    $color = ($reason == "Error" ? "red" : "orange");
    echo "<div style=\"border: solid $color 1px; margin: 2px;\">".
         "<p style=\"margin: 0 0 2px 0; padding: 0; background-color: #DDF;\">".
         "<strong style=\"padding: 0 3px; background-color: $color; color: white;\">$reason:</strong> ".
         "<span style=\"font-family: monospace;\">".htmlentities($query)."</span></p>";
  }

    /** Internal function to output a table representing the result of a query, for debug purpose.\n

      * Should be preceded by a call to debugQuery().

      * @param $result The resulting table of the query.

      */

	private function debugResult($result){

      echo "<table border=\"1\" style=\"margin: 2px;\">".

           "<thead style=\"font-size: 80%\">";

      $numFields = $this->mysqli->field_count($result);

      // BEGIN HEADER

      $tables    = array();

      $nbTables  = -1;

      $lastTable = "";

      $fields    = array();

      $nbFields  = -1;

      while ($column = $this->mysqli->fetch_field($result)) {

        if ($column->table != $lastTable) {

          $nbTables++;

          $tables[$nbTables] = array("name" => $column->table, "count" => 1);

        } else

          $tables[$nbTables]["count"]++;

        $lastTable = $column->table;

        $nbFields++;

        $fields[$nbFields] = $column->name;

      }

      for ($i = 0; $i <= $nbTables; $i++)

        echo "<th colspan=".$tables[$i]["count"].">".$tables[$i]["name"]."</th>";

      echo "</thead>";

      echo "<thead style=\"font-size: 80%\">";

      for ($i = 0; $i <= $nbFields; $i++)

        echo "<th>".$fields[$i]."</th>";

      echo "</thead>";

      // END HEADER

      while ($row = $this->mysqli->fetch_array($result)) {

        echo "<tr>";

        for ($i = 0; $i < $numFields; $i++)

          echo "<td>".htmlentities($row[$i])."</td>";

        echo "</tr>";

      }

      echo "</table></div>";

      $this->resetFetch($result);

    }

    /** Get how many time the script took from the begin of this object.

      * @return The script execution time in seconds since the

      * creation of this object.

      */

	private function getExecTime(){

      return round(($this->getMicroTime() - $this->mtStart) * 1000) / 1000;

    }

    /** Get the number of queries executed from the begin of this object.

      * @return The number of queries executed on the database server since the

      * creation of this object.

      */

	public function getQueriesCount(){

      return $this->nbQueries;

    }

    /** Go back to the first element of the result line.

      * @param $result The resssource returned by a query() function.

      */

	private function resetFetch($result){

      if ($this->mysqli->num_rows($result) > 0)

        $this->mysqli->data_seek($result, 0);

    }

    /** Get the id of the very last inserted row.

      * @return The id of the very last inserted row (in any table).

      */

	private function lastInsertedId(){

      return $this->mysqli->insert_id;

    }

    /** Close the connexion with the database server.\n

      * It's usually unneeded since PHP do it automatically at script end.

      */

	private function close(){

      mysql_close();

    }



    /** Internal method to get the current time.

      * @return The current time in seconds with microseconds (in float format).

      */

	private function getMicroTime(){

      list($msec,$sec)=explode(' ',microtime());

      return floor($sec/1000)+$msec;

    }

    private function consoleLog($line, $var) {
      echo '<script>console.log("PHP#'.$line.'-->", "'.$var.'");</script>';
    }
  } // class DB


?>