<?php
namespace Easyform;

class Notify {
	public function email($params,$formId,$data,$fields) {
		$mailer = new \PHPMailer();
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
		
		foreach($params['to'] as $address) {
			$mailer->addAddress($address);
		}
		
		$msg = '<p>Message from form: '.$formId.'</p>';
		foreach($data as $k=>$v) {
			$label = !empty($fields[$k]['label'])?$fields[$k]['label']:$k;
			$msg.= '<p><b>'.$label.'</b>: '.$v.'</p>';
		}
		
		$mailer->msgHTML($msg);
		$mailer->send();
	}
}