<?php

/*
 * Created on 2011-3-11
 *
 * @author yijian.cen
 *
 */
class System_Mail_Smtp {

	protected $_mailer;

	protected $_smtp_host;

	protected $_smtp_port;

	protected $_smtp_username;

	protected $_smtp_password;

	protected $_mail_from;

	protected $_messages;

	public function __construct() {
		require 'PHPMailer/class.phpmailer.php';
		$this->_mailer = new PHPMailer();
		$smtpConfig = System_Globals :: get('config');
		$this->_smtp_host = $smtpConfig->SMTP_HOST;
		$this->_smtp_port = $smtpConfig->SMTP_PORT;
		$this->_smtp_username = $smtpConfig->SMTP_USERNAME;
		$this->_smtp_password = $smtpConfig->SMTP_PWD;
		$this->_mail_from = $smtpConfig->MAIL_FROM;
	}

	public function send($to, $subject, $body, $fromName = '推闻网') {
		$this->_mailer->CharSet = 'UTF-8';
		$this->_mailer->IsSMTP(); // tell the class to use SMTP
		$this->_mailer->SMTPAuth = true; // enable SMTP authentication
		//基础配置
		$this->_mailer->Port = $this->_smtp_port;
		$this->_mailer->Host = $this->_smtp_host;
		$this->_mailer->Username = $this->_smtp_username;
		$this->_mailer->Password = $this->_smtp_password;

		//收发设置
		$this->_mailer->From = $this->_mail_from;
		$this->_mailer->FromName = $fromName;

		$to = explode(',', $to);
		foreach ($to as $receiver) {
			$this->_mailer->AddAddress($receiver);
		}

		//发送内容
		$this->_mailer->Subject = $subject;
		$this->_mailer->IsHTML(true); // send as HTML
		$this->_mailer->Body = $body;

		ob_start();
		if (!$this->_mailer->Send()) {
			$this->_messages = ob_get_contents();
			ob_end_clean();
			return false;
		}
		ob_end_clean();
		return true;
	}

	public function getErrorMessages() {
		return $this->_messages;
	}

}
?>