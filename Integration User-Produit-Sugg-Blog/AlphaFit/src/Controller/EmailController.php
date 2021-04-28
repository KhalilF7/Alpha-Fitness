<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
   /**
     * @Route("/email")
     *
     */
    public function sendEmail(MailerInterface $mailer)
    {
          $email = (new Email())
              ->from('meriem.benaouayene@esprit.tn')
              ->to('meriem.des@gmail.com')
              ->subject('test')
              ->html('<p>thnka u </p>');
          $mailer->send($email);
              return new Response('email sent');
    }

}