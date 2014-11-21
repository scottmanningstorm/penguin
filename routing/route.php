<?php 


class Route 
{

	protected $router; 

	protected $uri; 

	protected $controller_obj;

	protected $params = array(); 

	public function __construct() 
	{
		$this->router = new Router();

		$this->uri = new uri();
	}
		
	public function callController() 
	{ 	
		$this->uri->extractURI(); 

		$class_name = $this->uri->getController(); 

		if (!class_exists($class_name)) {
			$class_name = 'home';
		} 

		if(!method_exists($class_name, $this->uri->getMethod())) {
			 $this->uri->setMethod = 'index';
		}
		
		$this->uri->setParams($this->uri->extractParams());
		$this->uri->setParams($this->uri->getParams()); 
  
		$this->controller_obj = $this->router->loadController($class_name, $this->uri->getMethod(), $this->uri->getParams());  	
		
	}

}


?> 