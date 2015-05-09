<?php

 /**
  * 免费邮件发送类<br/><br/>
  */
 final class freemail {

	private $from = null, $pass = null, $to = null;
	private $smtp = null, $port = null;
	private $socket = null;
	private $data = null;
	private $header = null;

	/**
	 * 是否显示调试信息<br/>
	 * @var boolean 是或否<br/><br/>
	 */
	public $debug = true;

	/**
	 * 免费发送邮件类<br/>
	 * @param string $smtp 邮件发送端服务器地址<br/>
	 * @param int $port 发送端口（默认为25）<br/>
	 * @param string $from 邮件来自哪个邮箱<br/>
	 * @param string $pass 登录服务器的密码<br/>
	 * @param string $to 邮件发往哪个邮箱<br/>
	 * @param string $header 标记邮件来源的字符串（默认为“TripEC”）<br/><br/>
	 */
	public function __construct($smtp, $port, $from, $pass, $to, $header) {
	    $this->smtp = $smtp;
	    $this->port = $port;
	    $this->from = $from;
	    $this->pass = $pass;
	    $this->to = $to;
	    $this->header = $this->safeEncoding(($header) ? $header : "TripEC");
	}

	/**
	 * 以socket方式开始发送邮件（需要php.ini中设置开启socket的扩展功能）<br/>
	 * @param string $title 邮件主题<br/>
	 * @param string $body 邮件本体的 HTML<br/>
	 * @return boolean 返回布尔值指示是否发送成功<br/><br/>
	 */
	public function socket_send($title = null, $body = null) {
	    $this->socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	    if (!$this->socket) {
		   $this->show_debug('创建socket失败', true);
	    }
	    if (socket_connect($this->socket, $this->smtp, $this->port)) {
		   $this->show_debug('服务器连接应答:' . $this->safeEncoding(socket_strerror(socket_last_error())));
	    } else {
		   $this->show_debug('socket连接失败', true);
	    }
	    $this->data = "EHLO HELO\r\n";
	    $this->do_send();
	    $this->data = "AUTH LOGIN\r\n";
	    $this->do_send();
	    $this->data = base64_encode($this->from) . "\r\n";
	    $this->do_send();
	    $this->data = base64_encode($this->pass) . "\r\n";
	    $this->do_send();
	    $this->data = "MAIL FROM:<" . $this->from . ">\r\n";
	    $this->do_send();
	    $this->data = "RCPT TO:<" . $this->to . ">\r\n";
	    $this->do_send();
	    $this->data = "DATA\r\n";
	    $this->do_send();
	    $this->data = "MIME-Version:1.0 \r\n";
	    $this->data.= "Content-type:text/html;charset=utf-8 \r\n";
	    $this->data.= "From:" . $this->header . "<" . $this->from . ">\r\n";
	    $this->data.= "To: " . $this->to . "\r\n";
	    $this->data.="Subject:" . $this->safeEncoding($title) . "\r\n\r\n";
	    $this->data.=$this->safeEncoding($body) . "\r\n.\r\n";
	    $this->do_send();
	    $this->data = "QUIT\r\n";
	    $this->do_send();
	    socket_close($this->socket);
	    return true;
	}

	/**
	 * 以fsock方式开始发送邮件<br/>
	 * @param string $title 邮件主题<br/>
	 * @param string $body 邮件本体的 HTML<br/>
	 * @return boolean 返回布尔值指示是否发送成功<br/><br/>
	 */
	public function fsock_send($title = null, $body = null) {
	    $mail = Array('state' => 1, 'auth' => 1,);

	    date_default_timezone_set('PRC');

	    $title = '=?utf-8?B?' . base64_encode($title) . '?=';
	    $body = chunk_split(base64_encode(preg_replace("/(^|(\r\n))(\.)/", "\1.\3", $body)));

	    $headers = "";
	    $headers .= "MIME-Version:1.0\r\n";
	    $headers .= "Content-type:text/html\r\n";
	    $headers .= "Content-Transfer-Encoding: base64\r\n";
	    $headers .= "From: " . $this->header . "<" . $this->from . ">\r\n";
	    $headers .= "Date: " . date("r") . "\r\n";
	    list($msec, $sec) = explode(" ", microtime());
	    $headers .= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $this->from . ">\r\n";

	    if (!$fp = fsockopen($this->smtp, $this->port, $errno, $errstr, 30)) {
		   exit("无法连接发送方的服务器");
	    }

	    stream_set_blocking($fp, true);

	    $lastmessage = fgets($fp, 512);
	    if (substr($lastmessage, 0, 3) != '220') {
		   exit("连接时 - " . $lastmessage);
	    }

	    fputs($fp, ($mail['auth'] ? 'EHLO' : 'HELO') . " befen\r\n");
	    $lastmessage = fgets($fp, 512);
	    if (substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250) {
		   exit("HELO/EHLO - " . $lastmessage);
	    }

	    while (1) {
		   if (substr($lastmessage, 3, 1) != '-' || empty($lastmessage)) {
			  break;
		   }
		   $lastmessage = fgets($fp, 512);
	    }

	    if ($mail['auth']) {
		   fputs($fp, "AUTH LOGIN\r\n");
		   $lastmessage = fgets($fp, 512);
		   if (substr($lastmessage, 0, 3) != 334) {
			  exit($lastmessage);
		   }

		   fputs($fp, base64_encode($this->from) . "\r\n");
		   $lastmessage = fgets($fp, 512);
		   if (substr($lastmessage, 0, 3) != 334) {
			  exit("AUTH LOGIN - " . $lastmessage);
		   }

		   fputs($fp, base64_encode($this->pass) . "\r\n");
		   $lastmessage = fgets($fp, 512);
		   if (substr($lastmessage, 0, 3) != 235) {
			  exit("AUTH LOGIN - " . $lastmessage);
		   }

		   $email_from = $this->from;
	    }

	    fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from) . ">\r\n");
	    $lastmessage = fgets($fp, 512);
	    if (substr($lastmessage, 0, 3) != 250) {
		   fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from) . ">\r\n");
		   $lastmessage = fgets($fp, 512);
		   if (substr($lastmessage, 0, 3) != 250) {
			  exit("MAIL FROM - " . $lastmessage);
		   }
	    }

	    foreach (explode(',', $this->to) as $touser) {
		   $touser = trim($touser);
		   if ($touser) {
			  fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser) . ">\r\n");
			  $lastmessage = fgets($fp, 512);
			  if (substr($lastmessage, 0, 3) != 250) {
				 fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser) . ">\r\n");
				 $lastmessage = fgets($fp, 512);
				 exit("RCPT TO - " . $lastmessage);
			  }
		   }
	    }

	    fputs($fp, "DATA\r\n");
	    $lastmessage = fgets($fp, 512);
	    if (substr($lastmessage, 0, 3) != 354) {
		   exit("DATA - " . $lastmessage);
	    }

	    fputs($fp, $headers);
	    fputs($fp, "To: " . $this->to . "\r\n");
	    fputs($fp, "Subject: $title\r\n");
	    fputs($fp, "\r\n\r\n");
	    fputs($fp, "$body\r\n.\r\n");
	    $lastmessage = fgets($fp, 512);
	    if (substr($lastmessage, 0, 3) != 250) {
		   exit("END - " . $lastmessage);
	    }

	    fputs($fp, "QUIT\r\n");
	    return true;
	}

	private function do_send() {
	    socket_write($this->socket, $this->data, strlen($this->data));
	    $this->show_debug('客户端发送:' . $this->data);
	    $this->show_debug('服务器应答：' . socket_read($this->socket, 1024)) . '<br>';
	}

	private function show_debug($args = null, $exit = false) {
	    if ($this->debug)
		   echo $args . '<br>';
	    if ($exit == true) {
		   return false;
		   exit;
	    }
	}

	// 字符转码
	private function safeEncoding($string, $outEncoding = 'UTF-8') {
	    $encoding = "UTF-8";
	    for ($i = 0; $i < strlen($string); $i++) {
		   if (ord($string{$i}) < 128)
			  continue;
		   if ((ord($string{$i}) & 224) == 224) {
			  //第一个字节判断通过   
			  $char = $string{ ++$i};
			  if ((ord($char) & 128) == 128) {
				 //第二个字节判断通过   
				 $char = $string{ ++$i};
				 if ((ord($char) & 128) == 128) {
					$encoding = "UTF-8";
					break;
				 }
			  }
		   }
		   if ((ord($string{$i}) & 192) == 192) {
			  //第一个字节判断通过   
			  $char = $string{ ++$i};
			  if ((ord($char) & 128) == 128) {
				 // 第二个字节判断通过   
				 $encoding = "GB2312";
				 break;
			  }
		   }
	    }
	    if (strtoupper($encoding) == strtoupper($outEncoding))
		   return $string;
	    else
		   return iconv($encoding, $outEncoding, $string);
	}

 }
 