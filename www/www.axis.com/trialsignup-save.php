<?php
$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;


require_once('lib/common/init.php'); 
require_once('lib/common/Mail.php');
require_once('lib/common/Pdf.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('trailsignup-function.php'); 

$db = DBI::getInstance($database);  // Db Initialize
$formValues = $_POST['formValues'];     // Get the form post values

if($formValues)
{    

    $first_name   =  $formValues['first_name'];           
    $last_name    =   $formValues['last_name'];
    $email        =   $formValues['email'];
    $company      =   $formValues['company'];
    $zip          =   $formValues['zip'];
   

    $query = "INSERT INTO free_trail_users( `first_name`, `last_name`, `email`, `company`,`zip`) VALUES('$first_name','$last_name','$email','$company','$zip')";

        if($db->execute($query)){
            $trailrecord_id = $db->insertId; 
            $status = '1';
        }
        $db->free_result();

         $uri = Zend_Registry::get('uri');
            if ($uri->sslFlag) {
                $cdn = 'https:' . $uri->cdn;
            } else {
                $cdn = 'http:' . $uri->cdn;
            }

        if($trailrecord_id)
        {
            $url=$cdn.'trailsucess.php?id='. base64_encode($trailrecord_id);
            echo $url;
        }

        //To send a Email to the user

        $fromEmail = 'Alert@MyFulcrum.com';
        $fromName = 'Fulcrum AutoMessage';

        $mailToEmail = $email; 
        $mailToName = $first_name.' '.$last_name; 

        if($mailToName == ' ')
            $mailToName = $mailToEmail;
    //Mail Body 
        $greetingLine = 'Hi '.$mailToName.',<br>';
        $htmlAlertMessageBody = <<<END_HTML_MESSAGE
        <table style="border:1px solid #DBDBDC;width:650px;padding:6px 10px;font-size:14px;"><tr><td>
        $greetingLine
        <p style="margin:2%">Thanks for signing up with Fulcrum. We will set up your account and email your login info shortly.</p>

        <p style="margin:2%">Your 60 day Free Trial will start as soon as your profile is verified and credentials are mailed to you. </p>

        <p style="margin:2%">We value your Suggestions and Feedback.<br>
        Contact us: <a style="text-decoration:none;" href="mailto:info@myfulcrum.com">info@myfulcrum.com</a></p>

        Thanks,<br>
        Team Fulcrum
        </td></tr>
        </table>
END_HTML_MESSAGE;


        ob_start();
        include('templates/mail-template.php');
        $bodyHtml = ob_get_clean();

        $mail = new Mail();
        $mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
        $mail->setFrom($fromEmail, $fromName);
        $mail->addTo($mailToEmail, $mailToName);
        $mail->setSubject("SignUp");
        $mail->send();

          //End To send a Email to the user

        

      //To send a email to a admin
        $fromEmail = 'Alert@MyFulcrum.com';
        $fromName = 'Fulcrum AutoMessage';

        $mailToEmail = "info@myfulcrum.com"; 
       
         //Mail Body 
        $greetingLine = 'Hello Admin,<br>';
        $htmlAlertMessageBody = <<<END_HTML_MESSAGE
        <table style="border:1px solid #DBDBDC;width:650px;padding:6px 10px;font-size:14px;"><tr><td>
        $greetingLine
        <p style="margin:2%">You have received a signup for a 60 day Free Trial. </p>

        <p style="margin:2%">Name  : $mailToName<br>
        Email : <a style="text-decoration:none;" href="mailto:$email">$email</a>,</p>

         <p style="margin:2%">Please verify and send credentials to the email listed above. </p>

        Thanks,<br>
        Team Fulcrum
        </td></tr>
        </table>
END_HTML_MESSAGE;


        ob_start();
        include('templates/mail-template.php');
        $bodyHtml = ob_get_clean();

        $mail = new Mail();
        $mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
        $mail->setFrom($fromEmail, $fromName);
        $mail->addTo($mailToEmail);
        $mail->setSubject("User SignUp");
        $mail->send();

      //End To send a email to a admin


}
?>
