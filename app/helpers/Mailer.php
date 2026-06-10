<?php
class Mailer
{
    private static string $host = '';
    private static int $port = 587;
    private static string $user = '';
    private static string $pass = '';
    private static string $fromEmail = 'noreply@nusadataindonesia.com';
    private static string $fromName = 'Nusa Data Indonesia';
    private static string $adminEmail = 'hello@nusadataindonesia.com';

    public static function configure(array $config): void
    {
        if (isset($config['host'])) self::$host = $config['host'];
        if (isset($config['port'])) self::$port = (int)$config['port'];
        if (isset($config['user'])) self::$user = $config['user'];
        if (isset($config['pass'])) self::$pass = $config['pass'];
        if (isset($config['from_email'])) self::$fromEmail = $config['from_email'];
        if (isset($config['from_name'])) self::$fromName = $config['from_name'];
        if (isset($config['admin_email'])) self::$adminEmail = $config['admin_email'];
    }

    public static function send(string $to, string $subject, string $body): bool
    {
        if (empty(self::$host)) return false;

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=utf-8',
            'From: ' . self::$fromName . ' <' . self::$fromEmail . '>',
            'Reply-To: ' . $to,
            'X-Mailer: PHP/' . phpversion(),
        ];

        return mail($to, $subject, $body, implode("\r\n", $headers));
    }

    public static function sendContactNotification(string $name, string $email, string $subject, string $message): bool
    {
        $body = "New contact form submission:\n\n"
              . "Name: $name\n"
              . "Email: $email\n"
              . "Subject: $subject\n"
              . "Message:\n$message\n";

        return self::send(self::$adminEmail, "[NDI Contact] $subject", $body);
    }
}
