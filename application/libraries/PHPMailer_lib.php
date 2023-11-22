<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'third_party/PHPMailer/src/PHPMailer.php';
require APPPATH . 'third_party/PHPMailer/src/SMTP.php';
require APPPATH . 'third_party/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class PHPMailer_lib
{
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function sendEmail()
    {
        try {
            //Server settings
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.office365.com';
            $this->mail->SMTPAuth = true;
            //$this->mail->Username = 'nicotahindraza310501@gmail.com'; // Your google email address
            $this->mail->Username = 'm2manager2@outlook.com'; // Your Outlook email address
           // $this->mail->Password = 'bflk nsgr dghk drow'; // Your google email password
            $this->mail->Password = 'hpkevhhfaqafilfk'; // Your Outlook email password
            $this->mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $this->mail->Port = 587; // TCP port to connect to

            //Recipients
            $this->mail->setFrom('m2manager2@outlook.com',"Brada");
            $this->mail->addAddress('r12vatovavy@outlook.com'); // Add a recipient
			$lien = "assets/img/s2m/fond.jpg";
			$file_path = FCPATH  . $lien; // Replace with the path to your file
			 $this->mail->addAttachment($file_path);
            //Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Subject of the Email';
            $this->mail->Body = 'Body of the Email';
			//$this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
			echo 'Erreur lors de l\'envoi de l\'email : '. $this->mail->ErrorInfo;
            return false;
        }
    }
}
