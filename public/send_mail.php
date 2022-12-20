<?php

declare(strict_types=1);

require '../../../htdocs/tutorials/send_mail/vendor/autoload.php';

use \SendGrid\Mail\Mail;

$email = new \SendGrid\Mail\Mail();
$email->setFrom("s1190870@student.windesheim.nl", "root");
$email->setSubject("NerdyGadgets nieuwsbrief confirmation");
$email->addTo('vaanderking@hotmail.com', 'Jesse');
$email->addContent(
    "text/html", '<strong>Beste Meneer/Mevrouw,<br><br>
er is met uw e-mail ingelogd bij onze nieuwsbrief.<br>
 Bent u dit niet, negeer dan deze mail.<br>
 Bent u dit wel, klikt u dan op de link hieronder.</strong><br>
<a href="mailconf.php" class="btn btn--order"> Bevestigen</a>'
);
$sendgrid = new \SendGrid('');
