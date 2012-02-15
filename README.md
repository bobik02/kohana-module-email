# Email Module For Kohana 3.x

Factory-based email class. This class is a simple wrapper around [Swiftmailer](http://github.com/swiftmailer/swiftmailer).

## Usage

Create new messages using the `Email::factory($subject, $message)` method. Add recipients, add sender, send message:

    $email = Email::factory('Hello, World', 'This is my body, it is nice.')
        ->to('person@example.com')
        ->from('you@example.com', 'My Name')
        ->send()
        ;

You can also add HTML to your message:

    $email->message('<p>This is <em>my</em> body, it is <strong>nice</strong>.</p>', 'text/html');

Additional recipients can be added using the `to()`, `cc()`, and `bcc()` methods.

Additional senders can be added using the `from()` and `reply_to()` methods. If multiple sender addresses are specified, you need to set the actual sender of the message using the `sender()` method. Set the bounce recipient by using the `return_path()` method.

To access and modify the [Swiftmailer message](http://swiftmailer.org/docs/messages) directly, use the `raw_message()` method.

### Email Spooling

Email spooling allows you to enqueue emails into a queue instead of sending off the email in realtime. This can be usefull when your SMPT server limits the number of emails you can send over a certian ammount of time.

Currently two types of email spooling drivers are supported.

 * **Database Spooling:** This will enqueue the email into a database table (This driver requires the `Database` module)
 * **File Spooling:** This will enqueue the email into a file under a specified directory

When you are ready to send emails from the spool you may use `Email::flush_spool($max)` Where `$max` is the maximum number of emails to flush. It is recomended to use a CRON job or some other type of task to empty the spool.

## Configuration

Configuration is stored in `config/email.php`. Options are dependant upon transport method used. Consult the Swiftmailer documentation for options available to each transport.
