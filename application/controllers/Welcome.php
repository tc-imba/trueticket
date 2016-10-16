<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Front_Controller
{
	public function index()
	{
		
		$code = $this->input->get('data');
		if (!$code)
		{
			$this->load->view('homepage');
			return;
		}
		
		$data_decrypt = $this->Main_model->decrypt($code);
		$ticket = $this->Main_model->load_ticket($data_decrypt);
		if (!$ticket)
		{
			$this->load->view('error');
			return;
		}
		$data = array(
			'code'   => $code,
			'ticket' => $ticket,
			'event'  => $this->Main_model->load_event($ticket->event_id)
		);
		
		
		if (!isset($_SESSION['userid']) || !$_SESSION['userid'])
		{
			// User
			$data['type'] = 'user';
			$data['scan_list'] = $this->Main_model->load_scan($ticket->id);
			$this->load->library('IP');
			foreach ($data['scan_list'] as $key => $scan)
			{
				$ip_location = IP::find($scan->ip);
				$data['scan_list'][$key]->ip_str = $ip_location[1];
				$data['scan_list'][$key]->CREATE_TIMESTAMP = substr($data['scan_list'][$key]->CREATE_TIMESTAMP, 5);
			}
		}
		else
		{
			// Admin
			$data['type'] = 'admin';
			
		}
		$this->load->view('check', $data);
		
	}
}
