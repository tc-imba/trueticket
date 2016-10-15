<?php if (!defined('BASEPATH'))
{
	exit('No direct script access allowed');
}

abstract class Front_Controller extends CI_Controller
{

	
	public function __construct()
	{
		parent::__construct();
		
		if (ENVIRONMENT == 'development')
		{
			$this->output->enable_profiler(true);
		}
		
	}
	
}