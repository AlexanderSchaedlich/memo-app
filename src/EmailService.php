<?php  
    include "composer/vendor/autoload.php";

    // give aliases to namespaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class EmailService extends AbstractController {

		public function sendEmail($recipientEmail, $recipientName, $subject, $message) {
	        $mail = new PHPMailer(true); // true enables exceptions

	        try {
	            // mail parameters
				$mail->CharSet = "UTF-8";
	            $mail->setFrom("alexander.schaedlich@gmail.com", "Smiling Memos");
	            $mail->addAddress($recipientEmail, $recipientName);
	            $mail->Subject = $subject;
	            $mail->isHTML(true);
	            $mail->Body = $message;

	            // smtp parameters
	            $mail->isSMTP();
	            $mail->Host = "smtp.elasticemail.com";
	            $mail->SMTPAuth = true;
	            $mail->SMTPSecure = "tls";
	            $mail->Username = "alexander.schaedlich@gmail.com";
	            $mail->Password = "12359E29D17A4C805176438EC9E4020DCACA";
	            $mail->Port = 25;
	            // $mail->Port = 2525; // for localhost

	            // send
	            $mail->send();
	            return true;
	        } 

	        // catch a PHPMailer exception
	        catch (Exception $e) {
	            echo $e->errorMessage();
	            return false;
	        } 

	        // catch a PHP exception
	        catch (\Exception $e) {
	            echo $e->getMessage();
	            return false;
	        }
	    }
	}
?>