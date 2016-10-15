<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Front_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		if (!isset($_SESSION['userid']) || !$_SESSION['userid'])
		{
			redirect('admin/login');
		}
		else
		{
			redirect('admin/check');
		}
	}
	
	public function login()
	{
		$this->load->view('admin/login');
	}
	
	public function auth()
	{
		$username = $this->input->get('username');
		$password = $this->input->get('password');
		if ($this->Main_model->login($username, $password))
		{
			redirect('admin/check');
		}
		else
		{
			redirect('admin/login');
		}
	}
	
	
}
