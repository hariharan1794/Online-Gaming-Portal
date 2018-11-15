<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'libs/PHPMailer/src/PHPMailer.php';
	require 'libs/PHPMailer/src/SMTP.php';
	require 'libs/PHPMailer/src/Exception.php';

	class Mail {
		protected $mail, $email, $link;

		public function __construct($options = '') {
			$this->mail 	= new PHPMailer(true);
			$this->email 	= $options['email'];
			$this->link 	= $options['link'];
		}

		public function send_mail() {
			//Server settings
			$this->mail->isSMTP();
			$this->mail->Host = 'smtp.gmail.com';
			$this->mail->SMTPAuth = true;
			$this->mail->Username = 'xxxx@gmail.com';
			$this->mail->Password = 'xxx';
			$this->mail->SMTPSecure = 'tls';
			$this->mail->Port = 587;

			//Recipients
			$this->mail->setFrom('xxxxx@gmail.com', 'XYZ
			 Gaming');
			$this->mail->addAddress($this->email);
			// $this->mail->addAddress('ellen@example.com');
			// $this->mail->addReplyTo('info@example.com', 'Information');
			// $this->mail->addCC('cc@example.com');
			// $this->mail->addBCC('bcc@example.com');

			//Attachments
			// $this->mail->addAttachment('/var/tmp/file.tar.gz');
			// $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');

			//Content
			$this->mail->isHTML(true);
			$this->mail->Subject = 'Invitation link';
			$this->mail->Body    = $this->link;
			$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			try {
				$this->mail->send();
				return 1;
			} catch (Exception $e) {
				return 0;
				// echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
			}
		}
	}
?>
