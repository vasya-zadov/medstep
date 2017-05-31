<?php

require 'phpmailer/PHPMailerAutoload.php';

class EMailerAdyn
{
	protected static $_instance;
	
	protected $mailer = null;
	
	private function __construct()
	{
		$this->mailer=new PHPMailer;
		$this->mailer->isSMTP();
		$this->mailer->CharSet = "UTF-8";
		$this->mailer->SMTPDebug = 0;
		$this->mailer->Debugoutput = 'html';
		$this->mailer->Host = app()->settings->smtpHost;
		$this->mailer->Port = app()->settings->smtpPort;
		$this->mailer->SMTPSecure = 'tls';
		$this->mailer->SMTPAuth = true;
		$this->mailer->Username = app()->settings->smtpUserName;		
		$this->mailer->Password = app()->settings->smtpPassword;	
		$this->mailer->setFrom(app()->settings->smtpUserName);
		$this->mailer->addReplyTo(app()->settings->contactEmail);
	}
	
    /**
     * 
     * @return EMailerAdyn
     */
	public static function getInstance()
	{
		if (self::$_instance === null)
		{//create new exemplar
			self::$_instance=new self();
		}
		//return new or exist exemplar
		return self::$_instance;
	}
	
	public function send($email, $subject, $message)
	{
        if(is_array($email))
        {
            foreach($email as $one)
            {
                $this->mailer->addAddress($one);
            }
        }
        else
            $this->mailer->addAddress($email);		
        
		$this->mailer->Subject = $subject;
		$this->mailer->msgHTML($message);
	
		return $this->mailer->send();
	}
}