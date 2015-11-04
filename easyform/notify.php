<?php
namespace EasyForm;

class Notify {
	public function email($params,$formId,$data) {
		$mailer = new PHPMailer();
		$mailer->isSMTP();
		$mailer->Host = $params['smtpServer'];
		$mailer->Port = $params['smtpPort'];
		$mailer->SMTPSecure = $params['ssl'];
		$mailer->SMTPAuth = true;
		$mailer->Username = $params['user'];
		$mailer->Password = $params['password'];
		$mailer->Subject = $params['subject'];
		
		$mailer->CharSet = "UTF-8";
		
		$mailer->setFrom($params['from']);
		$mailer->addAddress($params['to']);
		
		$msg = '<p>Message from form: '.$formId.'</p>';
		foreach($data as $k=>$v) {
			$msg.= '<p><b>'.$k.'</b>: '.$v.'</p>';
		}
		
		$mailer->msgHTML($msg);
		$mailer->send();
	}
}