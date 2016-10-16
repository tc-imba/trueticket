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
			redirect(base_url('admin/login'));
		}
		else
		{
			redirect(base_url(''));
		}
	}
	
	public function login()
	{
		$data = array(
			'error'    => $this->input->get('error'),
			'username' => $this->input->get('username')
		);
		$this->load->view('admin/login', $data);
	}
	
	public function logout()
	{
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		redirect(base_url());
	}
	
	public function auth()
	{
		$username = $this->input->get('username');
		$password = $this->input->get('password');
		if ($this->Main_model->login($username, $password))
		{
			redirect(base_url(''));
		}
		else
		{
			redirect(base_url('admin/login?error=1&username=' . $username));
		}
	}
	
	public function check()
	{
		if (!isset($_SESSION['userid']) || !$_SESSION['userid'])
		{
			echo '非管理员';
			exit();
		}
		$data = $this->input->get('data');
		if (!$data)
		{
			echo '查询失败';
			exit();
		}
		$data = $this->Main_model->decrypt($data);
		$ticket = $this->Main_model->load_ticket($data);
		if (!$ticket)
		{
			echo '查询失败';
			exit();
		}
		if ($ticket->check_admin_id)
		{
			echo '已验票';
			exit();
		}
		$this->Main_model->checkin($ticket->id);
		echo '验票成功';
		exit();
	}
	
	public function generate()
	{
		$data = array('id' => $this->input->get('id'),);
		$data['str'] = base_url() . '?data=' . urlencode($this->Main_model->encrypt($data['id']));
		$this->load->view('admin/generate', $data);
	}
	
	public function generate_image()
	{
		$str = urldecode($this->input->get('str'));
		$this->load->library('QRcode');
		header('Content-Type: image/png');
		QRcode::png($str, false, QR_ECLEVEL_L, 10);
		exit();
	}
}
