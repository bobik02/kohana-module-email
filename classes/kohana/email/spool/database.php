<?php defined('SYSPATH') OR die('No direct script access.');

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
		// Insert the message into the table
		DB::Insert($this->_table_name, array('message'))
			->values(array(serialize($message)))
			->execute();
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
		// Keep a count of how many messages were sent
		$count = 0;

		// Setup the selection query
		$query = DB::Select()
			->from($this->_table_name)
			->order_by('id', 'ASC');

		// Limit the number of emails to dequeue from the spool
		if ($this->getMessageLimit() !== NULL)
		{
			$query->limit($this->getMessageLimit());
		}

		$messages = $query->execute();

		// Check that there are emails to be sent
		if(count($messages) > 0)
		{
			// Connect with the transport service
			if ( ! $transport->isStarted())
			{
				$transport->start();
			}

			$time = time();

			foreach ($messages as $email_message)
			{
				// Get the deserialized message
				$message = unserialize($email_message['message']);

				// Send the message
				$count += $transport->send($message, $failed_recipients);

				// Delete the send email from the table
				DB::Delete($this->_table_name)
					->where('id', '=', $email_message['id'])
					->execute();

				// Make sure we haven't reached the time limit
				if ($this->getTimeLimit() AND (time() - $time) >= $this->getTimeLimit())
					break;
			}
		}

		return $count;
	}

}