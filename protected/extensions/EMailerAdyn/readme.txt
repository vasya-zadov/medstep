In config main.php

'import'=>array(
	'application.extensions.EMailerAdyn.EMailerAdyn',
),

In controller

$mail=EMailerAdyn::getInstance();
$mail->send('your@mail.com', 'subject', 'message');