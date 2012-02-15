<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Email_Spool_Database extends Swift_ConfigurableSpool {

	/**
	 * The name of the database table
	 * @var  string
	 */
	protected $_table_name;

	/**
	 * Create the new Database Spool
	 *
	 * @param   type  $table_name  the name of the table to spool to
	 * @return  type
	 */
	public function __construct($table_name)
	{
		$this->_table_name = $table_name;
	}

	/**
	 * Tests if this Spool mechanism has started.
	 *
	 * @return  boolean
	 */
	public function isStarted()
	{
		return TRUE;
	}

	/**
	 * Starts this Spool mechanism.
	 */
	public function start() {}

	/**
	 * Stops this Spool mechanism.
	 */
	public function stop() {}

	/**
	 * Queues a message.
	 *
	 * @param   Swift_Mime_Message  $message  The message to store
	 * @return  boolean
	 */
	public function queueMessage(Swift_Mime_Message $message)
	{

	}

	/**
	 * Sends messages using the given transport instance.
	 *
	 * @param   Swift_Transport  $transport          A transport instance
	 * @param   array            $failed_recipients  An array of failures by-reference
	 * @return  int  The number of sent emails
	 */
	public function flushQueue(Swift_Transport $transport, & $failed_recipients = NULL)
	{
		// Connect with the transport service
		if ( ! $transport->isStarted())
		{
			$transport->start();
		}

		var_dump($transport);
	}

}