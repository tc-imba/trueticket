<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model
{
	
	public function login($username, $password)
	{
		$query = $this->db->get_where('user', array('username' => $username));
		if ($query->num_rows() > 0)
		{
			$data = $query->row(0);
			if ($data->password == $password)
			{
				$_SESSION['userid'] = $data->id;
				$_SESSION['username'] = $data->username;
				//echo 'success';
				return true;
			}
		}
		return false;
	}
	
	public function load_ticket($id)
	{
		$query = $this->db->get_where('ticket', array('id' => $id));
		if ($query->num_rows() > 0)
		{
			$data = $query->row(0);
			return $data;
		}
		return null;
	}
	
	public function load_event($id)
	{
		$query = $this->db->get_where('event', array('id' => $id));
		if ($query->num_rows() > 0)
		{
			$data = $query->row(0);
			return $data;
		}
		return null;
	}
	
	public function load_scan($id)
	{
		$query = $this->db->get_where('scan', array('id' => $id));
		if ($query->num_rows() > 0)
		{
			$data = $query->row_array();
			return $data;
		}
		return array();
	}
	
	
	public function encrypt($str)
	{
		$key = pack('H*', 'add6c1c94070e379226b8feab88bfe50');
		$data = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_CBC, md5($key));
		return base64_encode($data);
	}
	
	public function decrypt($data)
	{
		$str = base64_decode($data);
		$key = pack('H*', 'add6c1c94070e379226b8feab88bfe50');
		$str = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_CBC, md5($key));
		return $str;
	}
}