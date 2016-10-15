<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Front_Controller
{
	public function index()
	{
		echo $this->Main_model->encrypt('2') . '<br>';
		unset($_SESSION['userid']);
		
		$data = $this->input->get('data');
		if (!$data)
		{
			// error
		}
		
		$data = $this->Main_model->decrypt($data);
		if (!is_int($data))
		{
			// error
		}
		
		$ticket = $this->Main_model->load_ticket($data);
		if (!$ticket)
		{
			// error
		}
		$data = array(
			'ticket' => $ticket,
			'event' => $this->Main_model->load_event($ticket->event_id),
		    'scan_list' => $this->Main_model->load_scan($ticket->id)
		);
		print_r($data);
		
		echo $_SERVER["REMOTE_ADDR"];
		
		if (!isset($_SESSION['userid']) || !$_SESSION['userid'])
		{
			// User
			$this->load->view('check', $data);
		}
		else
		{
			// Admin
		}
	}
}
