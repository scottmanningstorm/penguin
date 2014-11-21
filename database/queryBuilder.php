<?php

class QueryBuilder 
{
	 /**
     * Holds our componenets to build up for our select statment 
     * @access public 
     * 
     */
	protected $select_components = array('select',
										  'table', 	
										  'columns',
										  'where',
										  'orderBy',
										  'groupBy',
										  'limit',
										);
	 /**
     * Holds our componenets to build up for our insert statment 
     * @access public 
     * 
     */
	protected $insert_components = array('insert',
										 'columns',
										 'values', 
									     'limit',
										);
	 /**
     * Holds our componenets to build up for our update statment 
     * @access public 
     * 
     */
	protected $update_components = array('update',
										 'set',	 
										 'where',
										 'orderBy',
										 'limitby', 
										);
	
	protected $delete_components = array('delete',
										 'where',
										 'limit',
										);  
	 
	 /**
	 * Method will itterate over Update components and compile a sql statment based on properties set in this grammer object. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string $statment  
	 */ 
	public function compileUpdate(Grammer $grammer) 
	{	
		$statment = $this->callMethod($grammer, $this->update_components); 
		 
		return $statment;
	}
	 
	 /**
	 * Method will itterate over Select components and compile a sql statment based on properties set in this grammer object. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string $statment  
	 */ 
	public function compileSelect(Grammer $grammer)
	{
		
		$statment = $this->callMethod($grammer, $this->select_components); 
		 
		return $statment;
	}
	
	public function compileDelete(Grammer $grammer)
	{
		$statment = $this->callMethod($grammer, $this->delete_components); 
		
		return $statment;
	}

	 /**
	 * Method will itterate over Insert components and compile a sql statment based on properties set in this grammer object. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string $statment  
	 */ 
	public function compileInsert(Grammer $grammer)  
	{
		$statment = $this->callMethod($grammer, $this->insert_components); 
	
		return $statment;
	}

	 /**
	 * Method will itterate over passed in componenets and calls a correponding method to build up a query.  
	 *
	 * @access public
	 * @param $select_components
	 * @param $grammer 
	 * @return string $statment  
	 */ 
	public function callMethod($grammer, $components) 
	{
		foreach ($components as $value) {

			$method = 'build'.ucfirst($value);
		
			if (method_exists($this, $method)) {
				
				$statment[] = $this->{$method}($grammer);

			}

		}
		
		return implode(' ', $statment);

	}

	 /**
	 * Method will build the update part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string $statment  
	 */ 
	public function buildUpdate(Grammer $grammer) 
	{

		if (!! $grammer->table) {
			return 'UPDATE user';  
		}
		return 'UPDATE ' . $grammer->table;
	} 


	 /**
	 * Method will build the Insert part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildInsert(Grammer $grammer) 
	{
		return 'INSERT INTO ' . $grammer->table;
	} 

	 /**
	 * Method will build the columns part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildColumns(Grammer $grammer)
	{	
 		if ($grammer->column > 0) { 
			return '(' .implode(', ', $grammer->column ). ' )';  
		}
	}

     /**
	 * Method will build the SET part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildSet(Grammer $grammer) 
	{
		$set = array();

		foreach ($grammer->column as $col) {

			$set[] = $col.' = :'.$col; 
		}

		return 'SET '. implode(', ', $set) .'';  
	} 

	 /**
	 * Method will build the VALUES part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildValues(Grammer $grammer)
	{ 	
		return 'VALUES (' .implode(', ', $grammer->binds ).' )';
	}
	
	 /**
	 * Method will build the SELECT part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildSelect(Grammer $grammer)
	{	
		
		if (count($grammer->column) > 1) {
			
			return 'SELECT' . $grammer->column;
		} else {
			
			return 'SELECT *'; 
		
		}

	}

	 /**
	 * Method will build the GROUP BY part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildGroup(Grammer $grammer) 
	{
		$return = '';

		if(!!$group) {
			$return = 'GROUP BY ' . $grammer->group_by; 
		} 

		return $return; 
	}

	 
     /**
	 * Method will build the ORDER BY part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildOrder(Grammer $grammer)
	{
		$return = ''; 

		if ($grammer->order_by) {
			$return = ' ORDER BY '. $grammer->order_by;
		}

		return $return; 
	} 
	


     /**
	 * Method will build the FROM part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildTable(Grammer $grammer) 
	{	
		return "FROM " . $grammer->table;
	}

    /**
	 * Method will build the WHERE part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildWhere(Grammer $grammer)
	{	

		if (count($grammer->wheres) > 0) {

			$return = 'WHERE '. implode(' AND ', $grammer->wheres);

			return $return; 
		}

	}


     /**
	 * Method will build the LIMIT BY part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildLimit(Grammer $grammer) 
	{

		$return = '';

		if (!!$grammer->limit_by) { 
			$return = ' LIMIT ' . $grammer->limit_by; 
		}

		return $return; 

	}


	 /**
	 * Method will build the columns part of a query string. 
	 *
	 * @access public
	 * @param $grammer 
	 * @return string 
	 */ 
	public function buildColumn($columns) 
	{	
		if (!!$columns) {	

			$return = $columns; 
		
		} else {
			
			$return = '*'; 
		
		}

		return $return; 
	}

	public function buildDelete(Grammer $grammer) 
	{
		return 'DELETE FROM ' .$grammer->table; 
	}

}

?> 