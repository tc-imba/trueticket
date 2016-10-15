<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends Front_Controller
{
	public function index()
	{
		$this->Main_model->generate_demo($this->input->get('str'));
		exit();
	}
}
