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
 * Timer manipulation class.
 *
 * Timers and time manipulation.
 *
 * @category	Time/Calendar Management
 * @package		Timer
 *
 */

/**
 * AbstractWebToolkit
 */
//Already Included...commented out for performance gain
//require_once('lib/common/AbstractWebToolkit.php');

class Timer extends AbstractWebToolkit
{
	/**
	 * Start time.
	 *
	 * @var string
	 */
	protected $startTime = null;

	/**
	 * End time.
	 *
	 * @var string
	 */
	protected $stopTime = null;

	/**
	 * Current time.
	 *
	 * @var string
	 */
	protected $time = null;

	/**
	 * Years.
	 *
	 * @var string
	 */
	protected $years = null;

	/**
	 * Months.
	 *
	 * @var string
	 */
	protected $months = null;

	/**
	 * Weeks.
	 *
	 * @var string
	 */
	protected $weeks = null;

	/**
	 * Days.
	 *
	 * @var string
	 */
	protected $days = null;

	/**
	 * Hours.
	 *
	 * @var string
	 */
	protected $hours = null;

	/**
	 * Minutes.
	 *
	 * @var string
	 */
	protected $minutes = null;

	/**
	 * Seconds.
	 *
	 * @var string
	 */
	protected $seconds = null;

	/**
	 * Microseconds.
	 *
	 * @var string
	 */
	protected $microseconds = null;

	/**
	 * Static Singleton instance variable
	 *
	 * @var unknown_type
	 */
	private static $_instance;

	/**
	 * Static factory method to return an instance of the object.
	 *
	 * @param boolean $setTime
	 * @return Singleton object reference
	 */
	public static function getInstance($setTime = false)
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new Timer($setTime);
			self::$_instance = $instance;
		} else {
			if ($setTime) {
				$instance->initializeTime();
			}

			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Constructor.
	 *
	 * @return unknown
	 */
	function __construct($setTime = false)
	{
		if ($setTime) {
			$this->initializeTime();
		}
	}

	public function getStartTime()
	{
		return $this->startTime;
	}

	public function setStartTime($time)
	{
		$this->startTime = $time;
	}

	public function getStopTime()
	{
		return $this->stopTime;
	}

	public function setStopTime($time)
	{
		$this->stopTime = $time;
	}

	/**
	 * Get a formatted timer result.
	 *
	 *
	 *
	 */
	public function fetchFormattedTimerOutput()
	{
		$time = $this->stopTime - $this->startTime;
		$time = (float) sprintf("%01.2f", $time);
		$output = '';

		//Days
		if ($time > 86400) {
			$days = $time / 86400;
			$days = floor($days);
			$subtract = $days * 86400;
			$time = $time - $subtract;
			if ($days == 1) {
				$daysDisplay = 'day';
			} else {
				$daysDisplay = 'days';
			}
			$output .= "$days $daysDisplay, ";
		}
		//Hours
		if ($time > 3600) {
			$hours = $time / 3600;
			$hours = floor($hours);
			$subtract = $hours * 3600;
			$time = $time - $subtract;
			if ($hours == 1) {
				$hoursDisplay = 'hour';
			} else {
				$hoursDisplay = 'hours';
			}
			$output .= "$hours $hoursDisplay, ";
		}
		//Minutes
		if ($time > 60) {
			$minutes = $time / 60;
			$minutes = floor($minutes);
			$subtract = $minutes * 60;
			$time = $time - $subtract;
			if ($minutes == 1) {
				$minutesDisplay = 'minute';
			} else {
				$minutesDisplay = 'minutes';
			}
			$output .= "$minutes $minutesDisplay, ";
		}
		//Seconds
		if ($time >= 0) {
			$seconds = sprintf("%01.2f", $time);
			if ($seconds == 1) {
				$secondsDisplay = 'second';
			} else {
				$secondsDisplay = 'seconds';
			}
			$output .= "$seconds $secondsDisplay";
		}

		$output = preg_replace('/, $/', '', $output);

		return $output;
	}

	/**
	 * Start the timer.
	 *
	 */
	public function startTimer()
	{
		$this->startTime = $this->fetchMicroTimestamp();
	}

	/**
	 * Stop the timer.
	 *
	 */
	public function stopTimer()
	{
		$this->stopTime = $this->fetchMicroTimestamp();
	}

	/**
	 * Set the latest microtimestamp.
	 *
	 */
	public function initializeTime()
	{
		$this->time = $this->fetchMicroTimestamp();
	}

	/**
	 * Retrieve the latest microtimestamp.
	 *
	 */
	public function fetchMicroTimestamp()
	{
		$microtimestamp = microtime(true);
		return $microtimestamp;
	}

	/**
	 * Get the current value of time.
	 *
	 */
	public function getTime()
	{
		return $this->time;
	}

	/**
	 * Set the current value of time to an arbitrary value.
	 *
	 */
	public function setTime($input)
	{
		if (isset($input) && !empty($input)) {
			$this->time = $input;
		}
	}

	/**
	 * Reset the instance data.
	 *
	 */
	public function reset()
	{
		foreach ($this as $var) {
			if ($var != 'instance') {
				$this->$var = null;
			}
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
