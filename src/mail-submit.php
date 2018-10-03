<?php
/*
 * mail-submit.php - submit a mail
 * 
 * parameter:
 *	mailbody ... str.
 */
require_once('lib/lib.php');

$param = get_param(array('mailbody' => 'S'));

 
define("MAIL_TO", "t.ikeda@csys.co.jp");

mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to      = MAIL_TO;
$message = $param['mailbody'];
$subject = first_line($message);	# use the first line of a mail body.

# if $subject is Markdown Header line, remove leading '#' and spaces.
$subject = mb_ereg_replace('^#* *', '', $subject);

/*
 * When sending mail, the mail must contain a From header. This can be set with * * the additional_headers parameter, or a default can be set in php.ini. 
 *
 * cf. http://php.net/manual/en/function.mb-send-mail.php
*/
$headers = 'From: ' . MAIL_TO . "\r\n";

/*
 * 7.2.0 	The additional_headers parameter now also accepts an array. 
 *
 * cf. http://php.net/manual/en/function.mb-send-mail.php
 */
/*
$headers = array(
	# headers, optional
	# HEADER => VALUE
	'From' => MAIL_TO,
);
*/

/* NOT MVC model, in a hurry 
 * ToDo: use MVC model.
 *
 * ->Model
 */

mb_send_mail($to, $subject, $message, $headers);

/* NOT MVC model, in a hurry 
 * ToDo: use MVC model.
 *
 * ->View
 */
header('Location: /mailform/form.php');