<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;

class notificationMailer
{
	private $mailer;

	public function __construct(\Swift_Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function indexAction($subject, $mail, $text)
	{

		$message = (new \Swift_Message("hello"))
			->setSubject($subject)
			->setFrom('admin@gmail.com')
			->setTo($mail)
			->addPart(
			$text
		);

		return $this->mailer->send($message) > 0;
	}
}