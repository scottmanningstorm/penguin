	<?php

Abstract class Active 
{
	/**
     * 
     * Holds an array of our grammer components used to build up our query strings.  
     * 
     */
	private $grammer_components = array( 'select',
										 'from',
										 'columns',
										 'where',
										 'columns',
										 'orderBy', 
										 'groupBy',
										 'values',
										 'table',
										 );
	
	/**
     * Holds our query string ready to pass over to the query class. 
     * @var String
     */
	public $query;

	/**
     * Holds ref to our query builder object
     * @var Object
     */
	public  $query_builder;

	/**
     * Holds ref to our grammer object
     * @var Object
     */
	public $grammer; 

	 /** 
	  * Class constructor, optinaly set table on initialisation
	  *
	  * @access public
	  * @param optinal $table
	  */
	public function __construct($table)
	{
		
		$this->query = new Query();

		$this->query_builder = new QueryBuilder();

		$this->grammer = new Grammer(); 
		
		$this->grammer->table = $table; 
	}

	 /**
	  * If we call a method which does not exsist in this class look inside Grammer class. 
	  *
	  * @access public
	  * @param $name string 
	  * @param $args array 
	  * @return This Object  
	  */
	public function __call($name, $args)
	{
		$this->findFunction($name, $args);

		return $this; 
	}

     /**
	  * If we try to call a method which does not exist this function will look for that metord inside the Grammer class
	  *
	  * @access protected
	  * @param $name string 
	  * @param $args array 
	  */
	protected function findFunction($name, $args) 
	{

		if (method_exists($this->grammer, $name)) {
		
			$this->grammer->{$name}($args); 

		} else {

			echo "No funcion found for " . $name; 

		}

	}
	 
	 /**
	  * Method will find an ID in our database matching the ID  passed in as a parameter. 
	  *
	  * @access public
	  * @param int $id
	  * @return associativeArray. 
	  */
	public function find($id)
	{		
		//$this->grammer->where('id = :id');
		$this->grammer->limit(1);

		return $this->query->getAssoc($this->query_builder->compileSelect(), array('id' => $id));
	}

	/**
	  * Method will find delete a record in our database matching the ID passed in as a parameter. 
	  *
	  * @access public
	  * @param int $id
	  * @return This Object 
	  */
	public function delete($id)
	{
		$this->grammer->wheres = array();
		
		$this->where('id', '=', $id);

		$this->grammer->limit(1);
		 
		$this->query->getAssoc($this->query_builder->compileDelete($this->grammer), array('user_id' => $id)); 
		 
		return $this; 
	}	

	 /**
	  * Method compiles our query and returns an associative array  
	  *
	  * @access public
	  * @return associativeArray. 
	  */
	public function get()
	{
		return $this->query->getAssoc($this->query_builder->compileSelect($this->grammer), $this->grammer->binds);
	}

	 /**
	  * Method compiles our query and inserts it into our database.  
	  *
	  * @access public
	  * @return associativeArray. 
	  */
	public function insert($values) 
	{  
		$this->grammer->setBinds($values);  
	
	 	return $this->query->insert($this->query_builder->compileInsert($this->grammer), $values);
	}

 	 /**
	  * Method compiles our query and updates a record to match any previous 'where' statments
	  *
	  * @access public
	  * @return associativeArray. 
	  */
	public function update($values)
	{	
		$this->grammer->setBinds($values);  
		$this->query->update($this->query_builder->compileUpdate($this->grammer), $this->grammer->getBinds()); 
	}	

	public function getLastInsertedId() 
	{
		//returns 0 : FIX
		return $this->query->lastId(); 
	}
	
	public function getDb($table = '', $id = '') 
	{
		$this->grammer->binds = array(); 	
		$this->grammer->setTable($table); 
		$this->grammer->wheres = array();
		if ($id === '') {
			$this->where('id', '>', 0); 
		} else {
			$this->where('user_id', '=', $id); 
		}
		return $this->query->getAssoc($this->query_builder->compileSelect($this->grammer), $this->grammer->binds);
	}

}


?>