<?php 

abstract class routerBaseClass
{

	protected $uri = array(); 

	protected $uri_root;

	protected $uri_controller; 

	protected $uri_params = array();

	public function __construct() 
	{
		$this->default_controller = 'home'; 

		$this->extractURI(); 

		$this->extractParams();

		$this->extractController(); 

		$this->extractMethod(); 

	}

	public function getController() 
	{	
		if(!!$this->uri_controller) {
			return $this->uri_controller;
		} else {
			return $this->default_controller; 
		}
	}

	public function getParams()
	{
		return $this->uri_params; 
	}
	
	public function getMethod() 
	{
		if(!!$this->uri_method) {
			return $this->uri_method; 
		} else {
			return "index"; 
		}
	}

	public function setController($controller)
	{
		$this->uri_controller = $controller; 
	} 

	public function extractURI() 
	{
		$this->uri = explode('/', $_SERVER['REQUEST_URI'] );
		
		array_shift($this->uri);
		return $this->uri; 

	}

	public function extractParams() 
	{
		if (count($this->uri) > 3) {			
			for ($i = 3; $i < count($this->uri); $i++) {
				$this->uri_params[] = $this->extractURI()[$i];   
			}
		}
	}

	public function extractMethod() 
	{
		//NOTE *************** Our servers are only running PHP 5.2 *********** 
		//selecting an array element passed back from a method will only work php version > 5.3
		if(!!$this->extractURI()[2]) { 
			$this->uri_method = $this->extractURI()[2];	 
		
		} else {
			$this->uri_method = 'index'; 
		}
	
	}

	public function extractController() 
	{
		//NOTE **** 
		//Selecting an array element passed back from a method will only work php version > 5.3
		if(!!$this->extractURI()[1]) { 
			$this->uri_controller = $this->extractURI()[1];
		} else { 
			$this->uri_controller = $this->default_controller;
		}

	}



	

}



?> 