<?php

namespace cubes\notification\mail\tests;

use cubes\notification\mail\MailService;
use cubes\notification\template\Template;
use cubes\system\settings\Settings;

class MailServiceTest extends \AppTestCase
{
    public function testSend()
    {
        $settings = $this->container->get(Settings::class);

//        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
//            ->setUsername('username')
//            ->setPassword('***');

//        $transport = (new \Swift_SmtpTransport('smtp.yandex.ru', 465, 'ssl'))
//            ->setUsername('username')
//            ->setPassword('***');

//        $transport = new \Swift_SendmailTransport('/usr/sbin/sendmail -bs');

        $transport = new \Swift_Transport_NullTransport(new \Swift_Events_SimpleEventDispatcher());
        $service = new MailService($transport, $settings);
        $template = new Template();
        $template->subject = 'Test email';
        $template->body = '<h1>Test email body</h1>';
        $count = $service->sendTemplate(
            'mvkasatkin@gmail.com',
            $template,
            [],
            'Maxim Kasatkin',
            'mvkasatkin@yandex.ru',
            null,
            []
        );
        $this->assertEquals(1, $count);
    }
}