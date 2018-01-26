<?php

namespace cubes\notification\mail;

use cubes\notification\template\Template;
use cubes\system\settings\Settings;
use Swift_Attachment;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;

class MailService
{
    /**
     * @var Swift_Transport
     */
    protected $transport;
    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @param Swift_Transport $transport
     * @param Settings $settings
     */
    public function __construct(Swift_Transport $transport, Settings $settings)
    {
        $this->transport = $transport;
        $this->settings = $settings;
    }

    /**
     * @param string $emailTo
     * @param Template $template
     * @param array $vars
     * @param string|null $nameFrom
     * @param string|null $emailFrom
     * @param string|null $bcc
     *
     * @param array $files
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function sendTemplate(
        string $emailTo,
        Template $template,
        array $vars = [],
        string $nameFrom = null,
        string $emailFrom = null,
        string $bcc = null,
        array $files = []
    ):int {
        $nameFrom = $nameFrom ?: $this->settings->get('from_name');
        $emailFrom = $emailFrom ?: $this->settings->get('from_email');
        $bcc = $bcc ?: $this->settings->get('bcc_emails');
        $subject = $template->renderSubject($vars);
        $body = $template->renderBody($vars);
        $bodyText = $this->toText($body);
        return $this->send($nameFrom, $emailFrom, $emailTo, $subject, $body, $bodyText, $bcc, $files);
    }

    /**
     * @param string $nameFrom
     * @param string $emailFrom
     * @param string $emailTo
     * @param string $subject
     * @param string $body
     * @param string $bodyText
     * @param string|null $bcc
     * @param array $files example: ['/some/file1', '/some/file2', 'http://site.tld/logo.png']
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(
        string $nameFrom,
        string $emailFrom,
        string $emailTo,
        string $subject,
        string $body,
        string $bodyText = null,
        string $bcc = null,
        array $files = []
    ): int {
        $message = (new Swift_Message($subject))
            ->setFrom([$emailFrom => $nameFrom])
            ->setTo([$emailTo])
            ->setBody($body, 'text/html')
            ->addPart($bodyText ?: $this->toText($body), 'text/plain');

        if ($bcc) {
            $message->setBcc($bcc);
        }

        foreach ($files as $file) {
            $attachment = Swift_Attachment::fromPath($file);
            $message->attach($attachment);
        }

        $mailer = new Swift_Mailer($this->transport);
        return $mailer->send($message);
    }

    /**
     * @param string $html
     * @return string
     */
    protected function toText(string $html): string
    {
        $result = \str_replace(
            ["\n", '<br>', '<br/>', '<br />', '</div>', '</p>'],
            ['', "\n", "\n", "\n", "</div>\n", "</p>\n"],
            $html
        );
        return \strip_tags($result);
    }
}
