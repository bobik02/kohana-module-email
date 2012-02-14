<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	/**
	 * SwiftMailer driver, used with the email module.
	 *
	 * Valid drivers are: native, sendmail, smtp
	 */
	'driver' => 'native',

	/**
	 * To use secure connections with SMTP, set "port" to 465 instead of 25.
	 * To enable TLS, set "encryption" to "tls".
	 *
	 * Note for SMTP, 'auth' key no longer exists as it did in 2.3.x helper
	 * Simply specifying a username and password is enough for all normal auth methods
	 * as they are autodeteccted in Swiftmailer 4
	 *
	 * PopB4Smtp is not supported in this module as I had no way to test it but
	 * SwiftMailer 4 does have a PopBeforeSMTP plugin so it shouldn't be hard to implement
	 *
	 * Encryption can be one of 'ssl' or 'tls' (both require non-default PHP extensions
	 *
	 * Driver options:
	 * @param  null    native: no options
	 * @param  string  sendmail: executable path, with -bs or equivalent attached
	 * @param  array   smtp: hostname, (username), (password), (port), (encryption)
	 */
	'options' => NULL,

	/**
	 * Email spooling allows you to enqueue emails into
	 * a queue instead of sending off the email in real time
	 * using the transport driver specified above. This can be
	 * usefull when your SMPT server limits the number of emails
	 * you can send over a certian ammount of time
	 *
	 * Note: When using spooling you must call Email::flush_spool()
	 * to send off the emails in the queue. It's advisable to do this
	 * using a CRON job
	 *
	 * Valid drivers are: disabled, file, database
	 */
	'spool_driver' => 'disabled',

	/**
	 * Spool driver options:
	 *
	 * @param  null    disabled: no options
	 * @param  string  database: The table name to spool into
	 * @param  string  file: The directory to spool files into
	 */
	'spool_options' => NULL,
);