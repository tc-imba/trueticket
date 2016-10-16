<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scan extends Front_Controller
{
	public function index()
	{
		$data = $this->input->get('data');
		if (!$data)
		{
			echo 'fail1';
			exit();
		}
		$data = $this->Main_model->decrypt($data);
		$ticket = $this->Main_model->load_ticket($data);
		if (!$ticket)
		{
			echo 'fail3';
			exit();
		}
		$scan_list = $this->Main_model->load_scan($ticket->id);
		if (count($scan_list) > 0)
		{
			$create_time = strtotime($scan_list[0]->CREATE_TIMESTAMP);
			$now = time();
			if ($now - $create_time <= 60)
			{
				echo 'fail4';
				exit();
			}
		}
		$this->Main_model->add_scan($ticket->id);
		echo 'success';
		exit();
	}
}
