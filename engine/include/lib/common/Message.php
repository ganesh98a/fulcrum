<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * Message Class for uniform error and message presentation.
 *
 * Manipulate all HTML messages in one place via a message queue.
 * Message-passing occurs between action and display scripts via the session.
 * Message queue holds messages of all types.
 *
 * Types:
 * 	1) generic (message)
 *	2) confirmation (confirm),
 *	3) error (error)
 *	4) information (info)
 *
 * PHP version 5
 *
 * @category	HTML Genereration
 * @package		Message
 * @uses		Session.php
 *
 */

require_once('lib/common/Session.php');

class Message
{
	/**
	 * Attribute $queue holds all messages (content strings) for all types (confirmation, error, information, etc.)
	 * $queue is an assocative array of arrays with keys corresponding to message type
	 *
	 * @var array
	 */
	protected $queue = null;

	/**
	 * Indicator for a message's location on an HTML page, e.g. "top".
	 *
	 * @var string
	 */
	protected $messageLocation;

	/**
	 * Session class reference for persistence of message queue across pages.
	 *
	 * @var object reference
	 */
	protected $session = null;

	/**
	 * Static Singleton instance variable
	 *
	 * @var Message Object reference
	 */
	private static $_instance;

	/**
	 * Static factory method to return an instance of the object.
	 *
	 * @param Static object reference
	 * @return Singleton object reference
	 */
	public static function getInstance($scope = null)
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new Message($scope);
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Constructor
	 * Input: None
	 * Output: None
	 * Action: Grab instance of object
	 * Please use singleton where possible
	 *
	 * @param string $scope
	 */
	public function __construct($scope = null) {
		// set message scope if provided
		$this->session = Session::getInstance($scope);

		$queue = $this->session->getMessageQueue();

		// returns indexed array with scope or without
		if (isset($queue)) {
			$this->setQueue($queue);
		}
	}

	/**
	 * Get an instance of the Session object
	 *
	 * @return Session object
	 */
	public function getSession()
	{
		return $this->session;
	}

	/**
	 * Get the messageLocation string
	 * --> intended for including additional information about where a message should be displayed on a page
	 *
	 * Input: None
	 * Output: $messageLocation
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return string location
	 */
	public function getMessageLocation($messageScope = 'default') {
		$return = isset($this->queue[$messageScope]['messageLocation']) ? $this->queue[$messageScope]['messageLocation'] : null;
		return $return;
	}

	/**
	 * Set the messageLocation string.
	 * --> intended for including additional information about where a message should be displayed on a page
	 *
	 * ALWAYS CALL setMessageLocation before sessionPut (this sets scope)
	 *
	 * Input: String
	 * Output: None
	 * Action: Set the value of $this->messageLocation
	 *
	 * @param string $input
	 * @param string $messageScope
	 */
	public function setMessageLocation($input = null, $messageScope = 'default') {
		$this->queue[$messageScope]['messageLocation'] = $input;
	}

	/**
	 * Place message queue in the session layer
	 * Input: None
	 * Output: None
	 * Action: Set session messageQueue attribute
	 */
	public function sessionPut() {
		$queue = $this->getQueue();
		$session = $this->getSession();
		$session->setMessageQueue($queue);
	}

	/**
	 * Place message queue in the session layer
	 * Input: None
	 * Output: None
	 * Action: Set session messageQueue attribute
	 */
	public function sessionClear() {
		// wipe out entire queue
		$this->session->setMessageQueue(null);
	}

	/**
	 * Reset the message queue
	 * Input: None
	 * Output: None
	 * Action: Reset message queue instance data to the default of an empty array
	 *
	 * @param string $messageScope
	 */
	public function reset($messageScope = null) {
		if (isset($messageScope)) {
			if (isset($this->queue[$messageScope])) {
				unset($this->queue[$messageScope]);
			}
		}
		else {
			// wipe out the whole thing
			$this->queue = null;
		}
	}

	/**
	 * Reset all the message queues
	 * Input: None
	 * Output: None
	 * Action: Reset message queue instance data to the default of an empty array
	 *
	 */
	public function resetAll() {
		// wipe out the whole thing
		$this->queue = null;
	}

	/**
	 * Determine if the message queue is empty (returns true if empty)
	 * Input: None
	 * Output: True or false (boolean)
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return boolean
	 */
	public function queueEmpty($messageScope = null) {
		if (isset($messageScope)) {
			if (isset($this->queue[$messageScope]) && (is_array($this->queue[$messageScope]))) {
				$arrQueue = $this->queue[$messageScope];
				if (count($arrQueue) > 0) {
					return false;
				}
			}
		} else {
			if (isset($this->queue) && is_array($this->queue)) {
				if (count($this->queue) > 0) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Get the queue (array).
	 *
	 * @return array	queue (or portion of queue)
	 */
	public function getQueue($messageScope=null, $messageType=null) {
		$queue = $this->queue;
		$return = $queue;

		if (isset($messageScope) && isset($messageType)) {
			if (isset($queue[$messageScope][$messageType])) {
				$return = $queue[$messageScope][$messageType];
			} else {
				$return = null;
			}
		} elseif (isset($messageScope) && !isset($messageType)) {
			if (isset($queue[$messageScope])) {
				$return = $queue[$messageScope];
			} else {
				$return = null;
			}
		} elseif (!isset($messageScope) && isset($messageType)) {
			if (isset($queue['default'][$messageType])) {
				$return = $queue['default'][$messageType];
			} else {
				$return = null;
			}
		}

		return $return;
	}

	/**
	 * Assign an entire array to overwrite the whole queue.
	 *
	 * @param array $input
	 */
	public function setQueue($input = null ) { $this->queue = $input; }

	/**
	 * Base method for loading messages into queue.
	 *
	 * @param string $input
	 * @param string $messageType
	 * @param string $messageScope
	 */
	protected function enqueueFactory($input, $messageType, $messageScope) {
		// use scope if it has it
		if (is_array($input)) {
			// array input type sets whole message queue at once
			$this->queue[$messageScope][$messageType] = $input;
		} else {
			// non-array input type enqueuees single value onto message queue
			$this->queue[$messageScope][$messageType][] = $input;
		}
	}

	/**
	 * Base method for loading first message out of the queue.
	 *
	 * @param	string $messageType
	 * @param	string $messageScope
	 * @return	string "message"
	 */
	protected function dequeueFactory($messageType = 'error', $messageScope) {
		if (isset($this->queue[$messageScope][$messageType])) {
			$return = array_shift($this->queue[$messageScope][$messageType]);
			return $return;
		}
	}

	/**
	 * Base method for loading first message out of the queue without removing it.
	 *
	 * @param	string $messageType
	 * @param	string $messageScope
	 * @return	string "Message"
	 */
	protected function staticDequeueFactory($messageType = 'error', $messageScope) {
		if (isset($this->queue[$messageScope][$messageType][0])) {
			$return = $this->queue[$messageScope][$messageType][0];
			return $return;
		}
	}

	/**
	 * Enqueue a message (5 types)
	 *
	 * @param string $input
	 * @param string $messageScope
	 */
	public function enqueueError($input = null, $messageScope = 'default') {
		$this->enqueueFactory($input, 'error', $messageScope);
	}

	public function enqueueSuccess($input = null, $messageScope = 'default') {
		$this->enqueueFactory($input, 'success', $messageScope);
	}

	public function enqueueConfirm($input = null, $messageScope = 'default') {
		$this->enqueueFactory($input, 'confirm', $messageScope);
	}

	public function enqueueInfo($input = null, $messageScope = 'default') {
		$this->enqueueFactory($input, 'info', $messageScope);
	}

	public function enqueueMessage($input = null, $messageScope = 'default') {
		$this->enqueueFactory($input, 'message', $messageScope);

	}

	/**
	 * Dequeue a message (4 types)
	 * Input: message string
	 * Output: First element in the queue (front element)
	 * Action: queue is decremented by one in size
	 *
	 * @param string $messageScope
	 * @return Error Message
	 */
	public function dequeueError($messageScope = 'default') {
		$return = $this->dequeueFactory('error', $messageScope);
		return $return;
	}

	/**
	 * Dequeue a message (4 types)
	 * Input: message string
	 * Output: First element in the queue (front element)
	 * Action: queue is decremented by one in size
	 *
	 * @param string $messageScope
	 * @return Confirmation Message
	 */
	public function dequeueConfirm($messageScope = 'default') {
		$return = $this->dequeueFactory('confirm', $messageScope);
		return $return;
	}

	/**
	 * Dequeue a message (4 types)
	 * Input: message string
	 * Output: First element in the queue (front element)
	 * Action: queue is decremented by one in size
	 *
	 * @param string $messageScope
	 * @return Informational Message
	 */
	public function dequeueInfo($messageScope = 'default') {
		$return = $this->dequeueFactory('info', $messageScope);
		return $return;
	}

	/**
	 * Dequeue a message (4 types)
	 * Input: message string
	 * Output: First element in the queue (front element)
	 * Action: queue is decremented by one in size
	 *
	 * @param string $messageScope
	 * @return Standard Message
	 */
	public function dequeueMessage($messageScope = 'default') {
		$return = $this->dequeueFactory('message', $messageScope);
		return $return;
	}

	/**
	 * Retrieve the front queue element without dequeueing it (the element is not removed from the queue)
	 * Input: None
	 * Output: First element in the queue (front element)
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return Error Message
	 */
	public function frontError($messageScope = 'default') {
		$return = $this->staticDequeueFactory('error', $messageScope);
		return $return;
	}

	/**
	 * Retrieve the front queue element without dequeueing it (the element is not removed from the queue)
	 * Input: None
	 * Output: First element in the queue (front element)
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return Confirmation Message
	 */
	public function frontConfirm($messageScope = 'default') {
		$return = $this->staticDequeueFactory('confirm', $messageScope);
		return $return;
	}

	/**
	 * Retrieve the front queue element without dequeueing it (the element is not removed from the queue)
	 * Input: None
	 * Output: First element in the queue (front element)
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return Informational Message
	 */
	public function frontInfo($messageScope = 'default') {
		$return = $this->staticDequeueFactory('info', $messageScope);
		return $return;
	}

	/**
	 * Retrieve the front queue element without dequeueing it (the element is not removed from the queue)
	 * Input: None
	 * Output: First element in the queue (front element)
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return Standard Message
	 */
	public function frontMessage($messageScope = 'default') {
		$return = $this->staticDequeueFactory('message', $messageScope);
		return $return;
	}

	/**
	 * Retrieve the contents of the message queue properly formatted as html
	 * Input: None
	 * Output: Entire message queue properly formatted as html
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return string Formatted HTML Messages
	 */
	public function getFormattedHtmlMessages($messageScope = 'default') {
		if ($this->queueEmpty($messageScope)) {
			return false;
		}

		//build html message block with appropriate formatting
		$html = '';

		// 1) error messages
		if (isset($this->queue[$messageScope]['error'])) {

			$errorMessages = $this->queue[$messageScope]['error'];

			$html .= '<div class="messageQueueErrorBlockContainer">';

			if (count($errorMessages) <= 5 ) {
				//error message block header if any can go here:
				//$html .= '<div class="messageQueueErrorHeader">The following errors occurred:</div>';
				//format specific errors
				$errorCount = 0;
				foreach ($errorMessages as $v ) {
					if ($errorCount == 0) {
						$html .= '<div class="messageQueueErrorHeader">' . $v . '</div>';
					} else {
						$html .= '<div class="messageQueueErrorText">' . $v . '</div>';
					}
					$errorCount++;
				}
			} else {
				// display generic message
				$html .= '<div class="messageQueueErrorHeader">Please enter the required fields.</div>';
			}

			$html .= '</div>';
		}

		// 2) confirmation messages
		if (isset($this->queue[$messageScope]['confirm'])) {
			$confirmationMessages = $this->queue[$messageScope]['confirm'];

			$html .= '<div class="messageQueueConfirmBlockContainer">';

			//format confirmation messages
			foreach ($confirmationMessages as $v ) {
				$html .= '<div class="messageQueueConfirm">' . $v . '</div>';
			}

			$html .= '</div>';
		}

		// 3) information messages
		if (isset($this->queue[$messageScope]['info'])) {
			$informationMessages = $this->queue[$messageScope]['info'];

			$html .= '<div class="messageQueueInfoBlockContainer">';

			//format information messages
			foreach ($informationMessages as $v ) {
				$html .= '<div class="messageQueueInfo">' . $v . '</div>';
			}

			$html .= '</div>';
		}

		// 4) generic messages
		if (isset($this->queue[$messageScope]['message'])) {
			$genericMessages = $this->queue[$messageScope]['message'];

			//format general messages
			foreach ($genericMessages as $v ) {
				$html .= '<div class="messageQueuePlain">' . $v . '</div>';
			}
		}

		// 5) success messages
		if (isset($this->queue[$messageScope]['success'])) {

			$successMessages = $this->queue[$messageScope]['success'];

			$html .= '<div class="messageQueueSuccessBlockContainer">';

			if (count($successMessages) <= 5 ) {
				//success message block header if any can go here:
				//$html .= '<div class="messageQueueSuccessHeader">The following success occurred:</div>';
				//format specific success
				$successCount = 0;
				foreach ($successMessages as $v ) {
					if ($successCount == 0) {
						$html .= '<div class="messageQueueSuccessHeader">' . $v . '</div>';
					} else {
						$html .= '<div class="messageQueueSuccessText">' . $v . '</div>';
					}
					$successCount++;
				}
			} else {
				// display generic message
				$html .= '<div class="messageQueueSuccessHeader">Success.</div>';
			}

			$html .= '</div>';
		}
		// reset messageQueue
		$this->reset($messageScope);
		$this->sessionClear();
		return $html;
	}
	/**
	 * Retrieve the contents of the message queue properly formatted as html
	 * Input: Username
	 * Output: Entire message queue properly formatted as html
	 * Action: None
	 *
	 * @param string $messageScope
	 * @return string Formatted HTML Messages
	 */
	public function getFormattedHtmlMessagesForLogin($messageScope = 'default') {
		if ($this->queueEmpty($messageScope)) {
			return false;
		}

		//build html message block with appropriate formatting
		$html = array();
		// 1) error messages
		if (isset($this->queue[$messageScope]['error'])) {

			$errorMessages = $this->queue[$messageScope]['error'];
			// $html= '<div class="messageQueueErrorBlockContainer">';
			if (count($errorMessages) <= 5 ) {
				//error message block header if any can go here:
				//$html .= '<div class="messageQueueErrorHeader">The following errors occurred:</div>';
				//format specific errors
				$errorCount = 0;
				foreach ($errorMessages as $v ) {
					$userpos = strpos($v, 'username');
					$pwdpos = strpos($v, 'password');
					$invalidpos = strpos($v, 'Invalid');
					$sessionpos = strpos($v, 'expired');
					/*username error input msg*/
					if($userpos == true)
						$html['username']=$v;
					/*Password error input msg*/
					if($pwdpos == true)
						$html['password']=$v;
					/*invalid error msg || session expired*/
					if($v == "Invalid security information")
						$html['generic']=$v;
					if($sessionpos == true)
						$html['generic']=$v;
					if($v == "Please login to access your account.")
						$html['generic']=$v;
					if ($v == "Please contact admin for Login...") 
						$html['generic']=$v;
					$errorCount++;
				}
			} else {
				// display generic message
				$html['generic']= 'Please enter the required fields.';
			}

			// $html .= '</div>';
		}

		// 2) confirmation messages
		if (isset($this->queue[$messageScope]['confirm'])) {
			$confirmationMessages = $this->queue[$messageScope]['confirm'];
			//format confirmation messages
			foreach ($confirmationMessages as $v ) {
				if($v == "You have successfully logged out.")
					$html['genericSuccess']=$v;
				if($v == "You have successfully reset the form.")
					$html['genericSuccess']=$v;				
			}
		}

		// reset messageQueue
		$this->reset($messageScope);
		$this->sessionClear();
		return $html;
	}
}
/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
