<?php 

class Query
{
	/**
     * Holds our database object. 
     * @var Object
     */
	private $db;  

	/**
     * Constructor, creates or gets our singleton database obj and sets it to $this->db.  
     * @access public 
     * 
     */
	public function __construct() 
	{
		$this->db = Connect::getInstance("localhost", "pdo", "root", "root"); 
	}


	 /**
	  * Method takes a query string and queries our database. Returns an assoc array of the results. 
	  *
	  * @access public
	  * @param string $query
	  * @param optinal $bind
	  * @return associativeArray. 
	  */
	public function getAssoc($query, $binds = array())  
	{		
		if ($query === "") {
			throw new Exception("Error - No query passed in!");
		}

		$statment = $this->process($query, $binds);
		
		return $statment->fetchAll(); 
	}	

	 /**
	  * Method takes a query string and queries our database. Returns an assoc array of the results. 
	  *
	  * @access public
	  * @param string $query
	  * @param optinal $bind
	  * @return Object. 
	  */
	public function getObj($query, $binds = array())  
	{		
		if ($query === "") {
			throw new Exception("Error - No query passed into GetObj Method - Query.php!");
			 
		}

		$statment = $this->process($query, $binds);
		
		return $statment->fetch( PDO::FETCH_OBJ); 
	}	

	 /**
	  * Method takes a query string and inserts any passed in values to our database. 
	  *
	  * @access public
	  * @param string $query
	  * @param optinal $binds  
	  * @return int 
	  */
	public function insert($query, $binds=array())
	{
		
		if ($query === "") {
			
			throw new Exception("No query passed into INSERT method - Query.php"); 
	
		}
		
		$output = $this->process($query, $binds); 

		if ($output) {
			
			return $this->db->lastInsertId();
		} else {
			
			return false;
		
		}

	} 

	 /**
	  * Method takes a query string and any values to insert into our database. 
	  *
	  * @access public
	  * @param string $query
	  * @param optinal $binds  
	  * @return bool 
	  */
	public function update($query, $binds=array())
	{
		if ($query === "") {
			throw new Exception("No query passed into UPDATE method - Query.php"); 
		}
		
		$output = $this->process($query, $binds); 
		
		if ($output) {
			return true;
		} else {
			return false;
		}

	} 

	 /**
	  *  Method processes a query string, binds any optinal parameters to the query and executes the query.  
	  *
	  * @access protected
	  * @param string $query
	  * @param array $binds
	  * @return String $statment  
	  */ 
	protected function process($query, $binds = array()) 
	{ 
		try { 

			$statment = $this->db->prepare($query); 

			$statment = $this->bind($binds, $statment);
			 
			$statment->execute(); 
				 
			return $statment;

		} catch (PDOException $e) { 
			die($e->getMesssage()); 
		}
	}

	/**
	 * Method binds any params to this object's query and returns the query as string.  	  
	 *
	 * @access public
	 * @param string $statment
	 * @param array $binds
	 * @return string $statment  
	 */ 
	public function bind($binds, $statment)
	{	
		if ( count($binds) > 0) {
			
			foreach($binds as $bind => $value) {
	 	 	  
	 	 		$statment->bindValue(':'.$bind, $value, $this->getDataType($bind));  

	 		}	

		}		
 	 	
		return $statment;
	}

	/**
	 * Method will return a PDO data type coresponding to the data type of a passed in parameter.  	  
	 *
	 * @access protected
	 * @param string $data
	 * @return DataType  
	 */ 
	protected function getDataType($data) 
	{
		$return_type;  

	 	switch($data)
	 	{
	 		default: 
	 		{
	 			return PDO::PARAM_STR; 
	 		}

	 		case 'Boolean' : 
	 		{
	 			return PDO::PARAM_BOOL;  
	 		}

	 		case 'string' :
	 		{
	 			return PDO::PARAM_STR;  
	 		}

	 		case 'double' :
	 		{
	 			return PDO::PARAM_STR;  
		 	}


	 	} 
		 
	}

}

?>

