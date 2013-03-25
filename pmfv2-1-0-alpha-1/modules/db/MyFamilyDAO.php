<?php

define ('L_ALL', 0);
define ('L_HEADER', 1);

class MyFamilyDAO {
	
	//Note that mysql does not support nested transactions
	var $inTrans = 0;
	
	function startTrans() {
		global $pdo;
		$pdo->beginTransaction();
		$this->inTrans++;
	}
	
	function commitTrans() {
		global $pdo;
		$this->inTrans--;
		if ($this->inTrans == 0) {
			//Because no nested transactions avoid premature commit
			$pdo->commit();
		}
	}
	
	function rollbackTrans() {
		global $pdo;
		$pdo->rollBack();
		$this->inTrans = 0;
	}
	
	function rowsChanged($result) {
		return($result->rowCount());
	}
//Not reliable for all databases see http://php.net/manual/en/pdostatement.rowcount.php	
//TODO - don't use this
	function rowsFetched($result) {
		return($result->rowCount());
	}
	
	function lockTable($table) {
	}
	
	function unlockTable($table) {
	}
	
	function runQuery($query, $msg) {
		global $pdo;
	   try {
		if (!($result = $pdo->query($query))) {
			//error_log($query);
			error_log($pdo->errorInfo());
			if ($this->inTrans > 0) {
				$this->rollbackTrans();
			}
			die($msg);
		}
	   } catch (PDOException $ex) {
		error_log($ex->getMessage());
	   }
		//error_log($query);
		//echo $query."<br/>";
		return ($result);
	}
	
	
	function addPersonRestriction($op, $birth = 'b', $death = 'd') {
		$config = Config::getInstance();
		$restrictdate = $config->restrictdate;
		
		$ret = "";
		if ($_SESSION["id"] == 0) {
			$ret = $op." ".$birth.".date1 < '".$restrictdate."'";
		}
		return ($ret);
	}
	
	function addRandom() {
		return(" ORDER BY RAND() ");
	}
	
	function addLimit($search, &$query) {
		if (isset($search->count)) {
			$query .= " LIMIT ";
			if (isset($search->start)) {
				$query .= $search->start.",";
			}
			$query .= $search->count;
		}
	}
	
	function getNextRow($result) {
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return ($row);
	}
	
	function freeResultSet($result) {
		  $result->closeCursor();
	}
	
	function getInsertId() {
		global $pdo;
		return ($pdo->lastInsertId());
	}

	function getNumRows($table) {
		global $tblprefix;
		$res = $this->runQuery("SELECT COUNT(*) as number FROM $tblprefix$table",'');
		$row = $this->getNextRow($res);
		$this->freeResultSet($res);
		return ($row["number"]);
	}	
}
?>
