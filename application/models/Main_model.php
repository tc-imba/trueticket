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
	
	public function request_get($url = '')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		//curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost); // Post提交的数据包
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		
		$data = curl_exec($ch);//运行curl
		if (curl_errno($ch))
		{
			echo 'Errno' . curl_error($ch);//捕抓异常
		}
		curl_close($ch);
		return $data;
	}
	
	public function generate_demo($str)
	{
		$image = imagecreatefrompng('./img/demo.png');
		$font_file = './img/calibril.ttf';
		
		$red = imagecolorallocate($image, 0xFF, 0x00, 0x00);
		$black = imagecolorallocate($image, 0x00, 0x00, 0x00);
		
		$red_str = substr($str, 0, 4);
		$black_str = substr($str, 4, 6);
		
		for ($i = 0; $i < 4; $i++)
		{
			imagefttext($image, ($red_str[$i] >= '0' && $red_str[$i] <= '9' ? 18 : 22), 0,
			            60 + $i * 15, 110, $red, $font_file, $red_str[$i]);
		}
		for ($i = 0; $i < 6; $i++)
		{
			imagefttext($image, 18, 0, 120 + $i * 14, 110, $black, $font_file, $black_str[$i]);
		}
		
		header('Content-Type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
	
	
}