<?php 


class Grammer
{

	/**
     * Holds and builds up an array of our WHERE statments.
     * @var Array
     */
	public $wheres = array();
 	
 	/**
     * Holds and builds up our order by statment
     * @var string
     */
	public $order_by;
	
	/**
     * Holds and builds up  our limit 
     * @var string
     */
	public $limit_by; 
	
	
	/**
     * Holds and builds up our collumns
     * @var string
     */
	public $column; 
	
	 /**
     * Holds and builds up our group bys
     * @var string
     */
	public $group_by;

	/**
     * Holds and builds up an array of any variables needed to be binded to our query. 
     * @var Array 
     */
	public $binds = array();
 	
 	/**
     * Holds our tables as part of our query. 
     * @var Array 
     */
	public $table;

 	/**
     * Holds our binded values - A MUST as this will sanitize any user input!
     * @var Array 
     */
	public $bindValues; 
	
	/**
     * Build a where statment to use as part of a database query. 
     * args[0] = column
     * args[1] = operator
     * args[2] = value 
     * @access public 
     * @param $args array 
     * @return This Object
     */
	public function where($args)
	{
	
		$column = $this->table.'.'.$args[0]; 
		
		$bind_column = $this->table.'_'.$args[0]; 

		$this->wheres[] = $column.' '. $args[1].' :'.$bind_column;
			 
		$this->binds[$bind_column] = $args[2];
	
	}

	public function limit($limit)
	{
		$this->limit_by = $limit;
	} 

    /**
     * adds a group by statment to our query string. 
     * @param $group string
     */
	public function setGroupBy($group)
	{
		$this->group_by = $group; 
	}

    /**
     * adds a Order by to our query string. 
     * @param $order string
     */
	public function setOrderBy($order)
	{
		$this->order_by = $order; 
	}

    /**
     * adds a limit to our query string. 
     * @param $limit string
     */
	public function setLimitBy($limit)
	{
		$this->limit_by = $limit; 
	}

    /**
     * adds a table to our query string. 
     * @param $table string
     */
	public function setTable($table)
	{
		$this->table = $table; 
	}

    /**
     * adds a column to our query string. 
     * @param $column string
     */
	public function setColumns($column)
	{
		$this->column = $column; 
	}

    /**
     * adds a value to bind to our query string. 
     * @param $data array
     */
	public function setBinds($data)
	{
		
		foreach ($data as $key => $value) {

			$this->column[] = $key;
			$this->binds[$key] = $value; 	

		}

	}

    /**
     * gets to our binded values. 
     * @return array
     */
	public function getBinds()
	{
		return $this->binds;
	}

    /**
     * Resets all our Select statment variables. 
     * @return This Object
     */
	public function clearSelectGrammer() 
	{
		$this->wheres = array();
 	
 		$this->order_by = '';
	
		$this->limit_by = ''; 

		$this->column = ''; 

		$this->group_by = '';

		$this->binds = array();

		$this->table = '';

		$this->bindValues = ''; 
	}

    /**
     * Resets all our Select statment variables. 
     * @return This Object
     */
	public function clearInsertGrammer() 
	{
		$this->wheres = array();

		$this->order_by = '';
	
		$this->limit_by = ''; 

		$this->column = ''; 

		$this->binds = array();

		$this->table = '';

		$this->bindValues = ''; 
	}

    /**
     * Resets all our Select statment variables. 
     * @return This Object
     */
	public function clearUpdateGrammer() 
	{

		$this->wheres = array();

		$this->order_by = '';
	
		$this->limit_by = ''; 

		$this->column = ''; 

		$this->binds = array();

		$this->table = '';

		$this->bindValues = ''; 
		
	}

	public function clearDeleteGrammer() 
	{

		$this->wheres = array();	
	
		$this->limit_by = ''; 

		$this->binds = array();

		$this->table = '';

		$this->bindValues = ''; 
		
	}


}


?> 