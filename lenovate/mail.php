<?php
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-3c8251e050a082bcec766f28913b6867');
$domain = "sandbox9739d5153f244dd78035b35884147c3c.mailgun.org";

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
                  array('from'    => 'Mailgun Sandbox <postmaster@sandbox9739d5153f244dd78035b35884147c3c.mailgun.org>',
                        'to'      => 'archit <architdhingra21@yahoo.com>',
                        'subject' => 'Hello archit',
                        'text'    => 'Congratulations archit, you just sent an email with Mailgun!  You are truly awesome!  You can see a record of this email in your logs: https://mailgun.com/cp/log .  You can send up to 300 emails/day from this sandbox server.  Next, you should add your own domain so you can send 10,000 emails/month for free.'));
    
?>