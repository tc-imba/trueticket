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
		return NULL;
	}
	
	public function load_event($id)
	{
		$query = $this->db->get_where('event', array('id' => $id));
		if ($query->num_rows() > 0)
		{
			$data = $query->row(0);
			return $data;
		}
		return NULL;
	}
	
	public function load_scan($id)
	{
		$query = $this->db->select('*')->from('scan')->where(array('ticket_id' => $id))
		                  ->order_by('CREATE_TIMESTAMP', 'DESC')->limit(5)->get();
		if ($query->num_rows() > 0)
		{
			$data = $query->result();
			return $data;
		}
		return array();
	}
	
	public function add_scan($id)
	{
		$this->db->insert('scan', array(
			'ticket_id' => $id,
			'ip'        => $this->get_remote_ip(),
			'device'    => $this->get_remote_device()
		));
	}
	
	public function checkin($id)
	{
		$this->db->update('ticket', array(
			'check_time'     => date('Y-m-d H:i:s', time()),
			'check_admin_id' => $_SESSION['userid']
		), array('id' => $id));
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
	
	public function get_remote_ip()
	{
		if (getenv('HTTP_CLIENT_IP'))
		{
			$ip = getenv('HTTP_CLIENT_IP');
		}
		else if (getenv('HTTP_X_FORWARDED_FOR'))
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		else if (getenv('REMOTE_ADDR'))
		{
			$ip = getenv('REMOTE_ADDR');
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	public function get_remote_device()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (stristr($_SERVER['HTTP_USER_AGENT'], 'Android'))
		{
			return 'Android';
		}
		else if (stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone'))
		{
			return 'iOS';
		}
		else
		{
			return 'other';
		}
	}
	
	public function generate_demo($str)
	{
		$image = imagecreatefrompng('./img/demo.png');
		$font_file = './img/SourceCodePro-Light.ttf';
		
		$red = imagecolorallocate($image, 0xC5, 0x1F, 0x1F);
		$black = imagecolorallocate($image, 0x00, 0x00, 0x00);
		
		$red_str = substr($str, 0, 4);
		$black_str = substr($str, 4, 6);
		
		$offset = 0;
		for ($i = 3; $i >= 0; $i--)
		{
			
			if ($red_str[$i] >= '0' && $red_str[$i] <= '9')
			{
				$offset += 14;
				imagefttext($image, 17, 0, 115 - $offset, 110, $red, $font_file, $red_str[$i]);
			}
			else
			{
				$offset += 17;
				imagefttext($image, 22, 0, 115 - $offset, 110, $red, $font_file, $red_str[$i]);
			}
		}
		for ($i = 0; $i < 6; $i++)
		{
			imagefttext($image, 17, 0, 120 + $i * 14, 110, $black, $font_file, $black_str[$i]);
		}
		
		header('Content-Type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
	
	
}