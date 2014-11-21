<?php 

class uri
{

	protected $uri = array(); 

	protected $rootDir;

	protected $controller; 

	protected $params = array();

	protected $method; 


	public function getController() 
	{	
		if(!!$this->controller) {
			$return = $this->controller;
		} else {
			$return = 'home'; 
		}

		return ucwords($return); 
	}

	public function getParams()
	{
		return $this->params; 
	}
	
	public function getMethod() 
	{
		if(!!$this->method) {
			return $this->method; 
		} else {
			return "index"; 
		}
	}

	public function setController($controller)
	{
		$this->controller = $controller; 
	} 

	public function setMethod($method)
	{	
		$this->method = $method; 
	} 

	public function setParams($params)
	{
		$this->params = $params;
	} 


	public function extractURI() 
	{
		$this->uri = explode('/', $_SERVER['REQUEST_URI'] );
		
		array_shift($this->uri);
		array_shift($this->uri);

		$this->setController($this->uri[0]); 		

		if (isset($this->uri[1])) {
			$this->setMethod($this->uri[1]); 
		}

		$this->setParams($this->extractParams());  

		return $this->uri; 

	}

	public function extractParams() 
	{
		$params = array(); 

		if (count($this->uri) > 2) {			
			for ($i = 2; $i < count($this->uri); $i++) {
				$params[] = $this->uri[$i];   
			}	
		}

		return $params;
	}

	public function extractMethod() 
	{
		//NOTE *************** Our servers are only running PHP 5.2 *********** 
		//selecting an array element passed back from a method will only work php version > 5.3
		if(!!$this->extractURI()[2]) { 
			$this->method = $this->extractURI()[2];	 
		
		} else {
			$this->method = 'index'; 
		}
	
	}

	public function extractController() 
	{
		//NOTE **** 
		//Selecting an array element passed back from a method will only work php version > 5.3 
		if(!!$this->extractURI()[1]) { 
			$return = $this->extractURI()[1];
		} else { 
			$return = 'Home';
		}

		return $return; 

	}


}

?> 