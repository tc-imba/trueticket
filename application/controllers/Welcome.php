<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Front_Controller
{
	public function index()
	{
		echo $this->Main_model->encrypt('1') . '<br>';
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
			'ticket'    => $ticket,
			'event'     => $this->Main_model->load_event($ticket->event_id),
			'scan_list' => $this->Main_model->load_scan($ticket->id)
		);

		$this->load->library('IP');
		
		foreach ($data['scan_list'] as $key => $scan)
		{
			$ip_location = IP::find($scan->ip);
			$data['scan_list'][$key]->ip_str = $ip_location[1];
			
			/*$ip_location = $this->Main_model->request_get('http://freeapi.ipip.net/' . $scan->ip);
			$ip_location = json_decode($ip_location, true);
			print_r($ip_location);
			$ip_str = $ip_location[2];
			if ($ip_location[4])
			{
				$ip_str .= '(' . $ip_location[4] . ')';
			}
			if (!$ip_str)
			{
				$ip_str = '*';
			}
			$data['scan_list'][$key]->ip_str = $ip_str;*/
			$data['scan_list'][$key]->CREATE_TIMESTAMP = substr($data['scan_list'][$key]->CREATE_TIMESTAMP, 5);
		}
		
		//print_r($data['scan_list']);
		
		//echo $this->Main_model->get_remote_ip();
		
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
