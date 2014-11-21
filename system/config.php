<?php 

class Config 
{

	public static function Enviroment($setting)
	{
		switch ($setting) 
		{	
			case 'dev' :
			case 'development' :
			{
				///////////////////////////////////
				//   DEBUG - Error Reporting.    //
				error_reporting(E_ALL);   	     //
				ini_set('display_errors', 1);    //
				///////////////////////////////////
				break; 
			} 
			case 'live': 
			{
				///////////////////////////////////
				//   DEBUG - Error Reporting.    //
				error_reporting(E_ALL);   	     //
				ini_set('display_errors', 0);    //
				///////////////////////////////////
				break; 
			}
		}
	} 

}


?> 