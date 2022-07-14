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
 * Send/receive/process messages via sms.
 *
 *
 * @category   MessageGateway/SMS
 * @package    MessageGateway_Sms
 *
 */

/**
 * MessageGateway
 */
require_once('lib/common/MessageGateway.php');

class MessageGateway_Sms extends MessageGateway
{
	const FROM_PHONE_NUMBER = '';

	public static $arrSmsGateways = array(
		//'Sprint' => '@messaging.sprintpcs.com'

		// AUSTRALIA
		'au T-Mobile/Optus Zoo' => '0#@optusmobile.com.au',

		// AUSTRIA
		'at T-Mobile' => '43676#@sms.t-mobile.at',

		// BULGARIA
		'bg Mtel' => '#@sms.mtel.net',
		'bg Globul' => '#@sms.globul.bg',

		// CANADA
		'ca Aliant' => '#@wirefree.informe.ca',
		'ca Bell Mobility' => '#@txt.bellmobility.ca',
		'ca Fido' => '#@fido.ca',
		'ca MTS Mobility' => '#@text.mtsmobility.com',
		'ca Rogers Wireless' => '#@pcs.rogers.com',
		'ca Sasktel Mobility' => '#@pcs.sasktelmobility.com',
		'ca Telus' => '#@msg.telus.com',
		'ca Virgin Mobile' => '#@vmobile.ca',

		// FRANCE
		'fr Bouygues Télécom' => '#@mms.bouyguestelecom.fr',

		// GERMANY
		'de E-Plus' => '0#@smsmail.eplus.de',
		'de O2' => '0#@o2online.de',
		'de T-Mobile' => '0#@t-d1-sms.de',
		'de Vodafone' => '0#@vodafone-sms.de',

		// ICELAND
		'is OgVodafone' => '#@sms.is',
		'is Siminn' => '#@box.is',

		// INDIA
		'in Andhra Pradesh AirTel' => '91#@airtelap.com',
		'in Andhra Pradesh Idea Cellular' => '9848#@ideacellular.net',
		'in Chennai Skycell / Airtel' => '919840#@airtelchennai.com',
		'in Chennai RPG Cellular' => '9841#@rpgmail.net',
		'in Delhi Airtel' => '919810#@airtelmail.com',
		'in Delhi Hutch' => '9811#@delhi.hutch.co.in',
		'in Gujarat Idea Cellular' => '9824#@ideacellular.net',
		'in Gujarat Airtel' => '919898#@airtelmail.com',
		'in Gujarat Celforce / Fascel' => '9825#@celforce.com',
		'in Goa Airtel' => '919890#@airtelmail.com',
		'in Goa BPL Mobile' => '9823#@bplmobile.com',
		'in Goa Idea Cellular' => '9822#@ideacellular.net',
		'in Haryana Airtel' => '919896#@airtelmail.com',
		'in Haryana Escotel' => '9812#@escotelmobile.com',
		'in Himachal Pradesh Airtel' => '919816#@airtelmail.com',
		'in Karnataka Airtel' => '919845#@airtelkk.com',
		'in Kerala Airtel' => '919895#@airtelkerala.com',
		'in Kerala Escotel' => '9847#@escotelmobile.com',
		'in Kerala BPL Mobile' => '9846#@bplmobile.com',
		'in Kolkata Airtel' => '919831#@airtelkol.com or',
		'in Madhya Pradesh Airtel' => '919893#@airtelmail.com',
		'in Maharashtra Airtel' => '919890#@airtelmail.com',
		'in Maharashtra BPL Mobile' => '9823#@bplmobile.com',
		'in Maharashtra Idea Cellular' => '9822#@ideacellular.net',
		'in Mumbai Airtel' => '919892#@airtelmail.com',
		'in Mumbai BPL Mobile' => '9821#@bplmobile.com',
		'in Punjab Airtel' => '919815#@airtelmail.com',
		'in Pondicherry BPL Mobile' => '9843#@bplmobile.com',
		'in Tamil Nadu Airtel' => '919894#@airtelmail.com',
		'in Tamil Nadu BPL Mobile' => '919843#@bplmobile.com',
		'in Tamil Nadu Aircel' => '9842#@airsms.com',
		'in Uttar Pradesh West Escotel' => '9837#@escotelmobile.com',

		// IRELAND
		'ie Meteor' => '#@sms.mymeteor.ie',

		// ITALY
		'it TIM' => '0#@timnet.com',
		'it Vodafone' => '3**#@sms.vodafone.it',

		// JAPAN
		'jp AU by KDDI' => '#@ezweb.ne.jp',
		'jp NTT DoCoMo' => '#@docomo.ne.jp',
		'jp Vodafone Chuugoku/Western' => '#@n.vodafone.ne.jp',
		'jp Vodafone Hokkaido' => '#@d.vodafone.ne.jp',
		'jp Vodafone Hokuriko/Central North' => '#@r.vodafone.ne.jp',
		'jp Vodafone Kansai/West, including Osaka' => '#@k.vodafone.ne.jp',
		'jp Vodafone Kanto/Koushin/East, including Tokyo' => '#@t.vodafone.ne.jp',
		'jp Vodafone Kyuushu/Okinawa' => '#@q.vodafone.ne.jp',
		'jp Vodafone Shikoku' => '#@s.vodafone.ne.jp',
		'jp Vodafone Touhoku/Niigata/North' => '#@h.vodafone.ne.jp',
		'jp Vodafone Toukai/Central' => '#@c.vodafone.ne.jp',
		'jp Willcom' => '#@pdx.ne.jp',
		'jp Willcom di' => '#@di.pdx.ne.jp',
		'jp Willcom dj' => '#@dj.pdx.ne.jp',
		'jp Willcom dk' => '#@dk.pdx.ne.jp',

		// NETHERLANDS
		'ne T-Mobile' => '31#@gin.nl',
		'ne Orange' => '0#@sms.orange.nl',

		// SINGAPORE
		'sg M1' => '#@m1.com.sg',

		// SOUTH AFRICA
		'za Vodacom' => '#@voda.co.za',

		// SPAIN
		'es Telefonica Movistar' => '0#@movistar.net',
		'es Vodafone' => '0#@vodafone.es',

		// SWEDEN
		'se Tele2' => '0#@sms.tele2.se',

		// UNITED STATES
		'us Alltel' => '#@message.alltel.com',
		'us Ameritech' => '#@paging.acswireless.com',
		'us ATT Wireless' => '#@txt.att.net',
		'us Bellsouth' => '#@bellsouth.cl',
		'us Boost' => '#@myboostmobile.com',
		'us CellularOne' => '#@mobile.celloneusa.com',
		'us Cingular' => '1#@mobile.mycingular.com',
		'us Edge Wireless' => '#@sms.edgewireless.com',
		'us Metro PCS' => '#@mymetropcs.com',
		'us Nextel' => '#@messaging.nextel.com',
		'us O2' => '#@mobile.celloneusa.com',
		'us Orange' => '#@mobile.celloneusa.com',
		'us Qwest' => '#@qwestmp.com',
		'us Rogers Wireless' => '#@pcs.rogers.com',
		// Simple Mobile

		'us Sprint PCS' => '#@messaging.sprintpcs.com',
		'us T-Mobile' => '#@tmomail.net',
		'us Teleflip' => '#@teleflip.com',
		'us Telus Mobility' => '#@msg.telus.com',
		'us US Cellular' => '#@email.uscc.net',
		'us Verizon' => '#@vtext.com',
		'us Virgin Mobile' => '#@vmobl.com',

		// UNITED KINGDOM
		'uk O2 #1' => '44#@mobile.celloneusa.com',
		'uk O2 #2' => '44#@mmail.co.uk',
		'uk Orange' => '0#@orange.net',
		'uk T-Mobile' => '0#@t-mobile.uk.net',
		'uk Virgin Mobile' => '0#@vxtras.com',
		'uk Vodafone' => '0#@vodafone.net',
	);

	public static $arrSmsGatewaysDropDownList = array(
		'' => array(
			'' => ''
		),

		// UNITED STATES
		'United States (US) - Mobile Phone Carriers' => array(
			'Alltel' => 'us Alltel',
			'Ameritech' => 'us Ameritech',
			'ATT Wireless' => 'us ATT Wireless',
			'Bellsouth' => 'us Bellsouth',
			'Boost' => 'us Boost',
			'CellularOne' => 'us CellularOne',
			'Cingular' => 'us Cingular',
			'Edge Wireless' => 'us Edge Wireless',
			'Metro PCS' => 'us Metro PCS',
			'Nextel' => 'us Nextel',
			'O2' => 'us O2',
			'Orange' => 'us Orange',
			'Qwest' => 'us Qwest',
			'Rogers Wireless' => 'us Rogers Wireless',
			'Sprint' => 'us Sprint PCS',
			'T-Mobile' => 'us T-Mobile',
			'Teleflip' => 'us Teleflip',
			'Telus Mobility' => 'us Telus Mobility',
			'US Cellular' => 'us US Cellular',
			'Verizon' => 'us Verizon',
			'Virgin Mobile' => 'us Virgin Mobile',
		),

		// AUSTRALIA
		'Australia (AU) - Mobile Phone Carriers' => array(
			'T-Mobile/Optus Zoo' => 'au T-Mobile/Optus Zoo',
		),

		// AUSTRIA
		'Austria (AT) - Mobile Phone Carriers' => array(
			'T-Mobile' => 'at T-Mobile',
		),

		// BULGARIA
		'Bulgaria (BG) - Mobile Phone Carriers' => array(
			'Mtel' => 'bg Mtel',
			'Globul' => 'bg Globul',
		),

		// CANADA
		'Canada (CA) - Mobile Phone Carriers' => array(
			'Aliant' => 'ca Aliant',
			'Bell Mobility' => 'ca Bell Mobility',
			'Fido' => 'ca Fido',
			'MTS Mobility' => 'ca MTS Mobility',
			'Rogers Wireless' => 'ca Rogers Wireless',
			'Sasktel Mobility' => 'ca Sasktel Mobility',
			'Telus' => 'ca Telus',
			'Virgin Mobile' => 'ca Virgin Mobile',
		),

		// FRANCE
		'France (FR) - Mobile Phone Carriers' => array(
			'Bouygues Télécom' => 'fr Bouygues Télécom',
		),

		// GERMANY
		'Germany (DE) - Mobile Phone Carriers' => array(
			'E-Plus' => 'de E-Plus',
			'O2' => 'de O2',
			'T-Mobile' => 'de T-Mobile',
			'Vodafone' => 'de Vodafone',
		),

		// ICELAND
		'Iceland (IS) - Mobile Phone Carriers' => array(
			'OgVodafone' => 'is OgVodafone',
			'Siminn' => 'is Siminn',
		),

		// INDIA
		'India (IN) - Mobile Phone Carriers' => array(
			'Andhra Pradesh AirTel' => 'in Andhra Pradesh AirTel',
			'Andhra Pradesh Idea Cellular' => 'in Andhra Pradesh Idea Cellular',
			'Chennai Skycell / Airtel' => 'in Chennai Skycell / Airtel',
			'Chennai RPG Cellular' => 'in Chennai RPG Cellular',
			'Delhi Airtel' => 'in Delhi Airtel',
			'Delhi Hutch' => 'in Delhi Hutch',
			'Gujarat Idea Cellular' => 'in Gujarat Idea Cellular',
			'Gujarat Airtel' => 'in Gujarat Airtel',
			'Gujarat Celforce / Fascel' => 'in Gujarat Celforce / Fascel',
			'Goa Airtel' => 'in Goa Airtel',
			'Goa BPL Mobile' => 'in Goa BPL Mobile',
			'Goa Idea Cellular' => 'in Goa Idea Cellular',
			'Haryana Airtel' => 'in Haryana Airtel',
			'Haryana Escotel' => 'in Haryana Escotel',
			'Himachal Pradesh Airtel' => 'in Himachal Pradesh Airtel',
			'Karnataka Airtel' => 'in Karnataka Airtel',
			'Kerala Airtel' => 'in Kerala Airtel',
			'Kerala Escotel' => 'in Kerala Escotel',
			'Kerala BPL Mobile' => 'in Kerala BPL Mobile',
			'Kolkata Airtel' => 'in Kolkata Airtel',
			'Madhya Pradesh Airtel' => 'in Madhya Pradesh Airtel',
			'Maharashtra Airtel' => 'in Maharashtra Airtel',
			'Maharashtra BPL Mobile' => 'in Maharashtra BPL Mobile',
			'Maharashtra Idea Cellular' => 'in Maharashtra Idea Cellular',
			'Mumbai Airtel' => 'in Mumbai Airtel',
			'Mumbai BPL Mobile' => 'in Mumbai BPL Mobile',
			'Punjab Airtel' => 'in Punjab Airtel',
			'Pondicherry BPL Mobile' => 'in Pondicherry BPL Mobile',
			'Tamil Nadu Airtel' => 'in Tamil Nadu Airtel',
			'Tamil Nadu BPL Mobile' => 'in Tamil Nadu BPL Mobile',
			'Tamil Nadu Aircel' => 'in Tamil Nadu Aircel',
			'Uttar Pradesh West Escotel' => 'in Uttar Pradesh West Escotel',
		),

		// IRELAND
		'Ireland (IE) - Mobile Phone Carriers' => array(
			'Meteor' => 'ie Meteor',
		),

		// ITALY
		'Italy (IT) - Mobile Phone Carriers' => array(
			'it TIM' => 'it TIM',
			'it Vodafone' => 'it Vodafone',
		),

		// JAPAN
		'Japan (JP) - Mobile Phone Carriers' => array(
			'AU by KDDI' => 'jp AU by KDDI',
			'NTT DoCoMo' => 'jp NTT DoCoMo',
			'Vodafone Chuugoku/Western' => 'jp Vodafone Chuugoku/Western',
			'Vodafone Hokkaido' => 'jp Vodafone Hokkaido',
			'Vodafone Hokuriko/Central North' => 'jp Vodafone Hokuriko/Central North',
			'Vodafone Kansai/West, including Osaka' => 'jp Vodafone Kansai/West, including Osaka',
			'Vodafone Kanto/Koushin/East, including Tokyo' => 'jp Vodafone Kanto/Koushin/East, including Tokyo',
			'Vodafone Kyuushu/Okinawa' => 'jp Vodafone Kyuushu/Okinawa',
			'Vodafone Shikoku' => 'jp Vodafone Shikoku',
			'Vodafone Touhoku/Niigata/North' => 'jp Vodafone Touhoku/Niigata/North',
			'Vodafone Toukai/Central' => 'jp Vodafone Toukai/Central',
			'Willcom' => 'jp Willcom',
			'Willcom di' => 'jp Willcom di',
			'Willcom dj' => 'jp Willcom dj',
			'Willcom dk' => 'jp Willcom dk',
		),

		// NETHERLANDS
		'Netherlands (NE) - Mobile Phone Carriers' => array(
			'T-Mobile' => 'ne T-Mobile',
			'Orange' => 'ne Orange'
		),

		// SINGAPORE
		'Singapore (SG) - Mobile Phone Carriers' => array(
			'M1' => 'sg M1',
		),

		// SOUTH AFRICA
		'South Africa (ZA) - Mobile Phone Carriers' => array(
			'za Vodacom' => 'za Vodacom',
		),

		// SPAIN
		'Spain (ES) - Mobile Phone Carriers' => array(
			'Telefonica Movistar' => 'es Telefonica Movistar',
			'Vodafone' => 'es Vodafone',
		),

		// SWEDEN
		'Sweden (SE) - Mobile Phone Carriers' => array(
			'Tele2' => 'se Tele2',
		),

		// UNITED KINGDOM
		'United Kingdom (UK) - Mobile Phone Carriers' => array(
			'O2' => 'uk O2 #1',
			//'uk O2 #2' => 'uk O2 #2',
			'Orange' => 'uk Orange',
			'T-Mobile' => 'uk T-Mobile',
			'Virgin Mobile' => 'uk Virgin Mobile',
			'Vodafone' => 'uk Vodafone',
		)
	);

	protected $message;

	public function getMessage()
	{
		return $this->message;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}
	//To implement Twilio
	public static function TwilioSmsMessage($mobile_phone_number, $subject, $message)
	{
		$mobile_phone_number='+91'.$mobile_phone_number;
		// echo "come".$mobile_phone_number." ".$subject." 1 :".$message ;
		require_once("twilio-php/Services/Twilio.php");
		$AccountSid = "ACc19bfa23f4260eb50e0ccc1f98814443"; 
		$AuthToken = "ece2dd90c747e6a0db843e4d4286a2f7";
		$body=$subject.$message;
		$client = new Services_Twilio($AccountSid, $AuthToken);
		try{
			$message = $client->account->messages->create(
				array(
					"From" => "+16177492903",
					"To" => $mobile_phone_number,
					"Body" => $body
					)
				);
		}catch (Services_Twilio_RestException $e) {
			echo $e->getMessage();
		}
		catch (TwilioException $e) {
			echo $e->getMessage();
		}
		catch(Exception $e)
		{
		}
	// Display a confirmation message on the screen
		echo "{$message->sid}";
		// exit;
	}
	public static function sendSmsMessage($mobile_phone_number, $mobile_network_carrier_id, $toName, $fromEmail, $fromName, $subject, $message)
	{
		$smsGateway = self::findCarrierByid($mobile_network_carrier_id);

		// Confirm that a non-empty string was returned.
		// e.g. #@messaging.sprintpcs.com
		if (empty($smsGateway) || (!empty($smsGateway) && !is_int(strpos($smsGateway, '#'))) ) {
			return;
		}

		// Confirm the domain format
		$arrTmp = explode('@', $smsGateway);
		if (isset($arrTmp) && is_array($arrTmp) && !empty($arrTmp)) {
			$domain = array_pop($arrTmp);
		} else {
			return;
		}

		/*
		// DNS lookup verification
		if (isset($domain) && !empty($domain)) {
			$validMxDomain = checkdnsrr($domain,"MX");
			$validADomain = checkdnsrr($domain,"A");

			if (!$validMxDomain && !$validADomain) {
				return;
			}
		} else {
			return;
		}
		*/

		$to = str_replace('#', $mobile_phone_number, $smsGateway);

		$mail = new Mail();
		$mail->setBodyText($message);
		//$mail->setBodyHtml('<h2>'.$message.'</h2>');
		$mail->setFrom($fromEmail, $fromName);
		$mail->addTo($to, $toName);
		$mail->setSubject($subject);
		$mail->send();
	}

	public static function generateSmsGatewayList($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `mobile_network_carriers`
WHERE `carrier` <> ''
ORDER BY country ASC,carrier_display_name ASC
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrSmsGateways = array();

		$arrUsSmsGateways = array();
		$currentCountry = '';
		$counter = 1;
		while($row = $db->fetch()) {
			$id  = $row['id'];
			$carrier = $row['carrier'];
			$carrier_display_name = $row['carrier_display_name'];
			$sms_email_gateway = $row['sms_email_gateway'];
			$country = $row['country'];

			if ($currentCountry != $country) {
				$currentCountry = $country;
				$countryAbbreviation = substr($carrier, 0, 2);
				$countryAbbreviation = strtoupper($countryAbbreviation);
				$displayCountry = $currentCountry.' ('.$countryAbbreviation.') - Mobile Phone Carriers';
			}

			if ($currentCountry == 'United States') {
				$arrUsSmsGateways[$displayCountry][$carrier_display_name] = $id;
			} else {
				$arrSmsGateways[$displayCountry][$carrier_display_name] = $id;
			}

//			'Spain (ES) - Mobile Phone Carriers' => array(
//				'Telefonica Movistar' => 'es Telefonica Movistar',
//				'Vodafone' => 'es Vodafone',
//			),

			$counter++;
		}
		$db->free_result();

		$arrEmpty = array(
			'' => array(
				'' => ''
			)
		);
		$arrSmsGateways = array_merge($arrEmpty, $arrUsSmsGateways, $arrSmsGateways);

		return $arrSmsGateways;
	}

	public static function findCarrierByid($mobile_network_carrier_id)
	{
		$db = DBI::getInstance('axis');
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `sms_email_gateway`
FROM `mobile_network_carriers`
WHERE `id` = ?
";
		$arrValues = array($mobile_network_carrier_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row)) {
			$sms_email_gateway = $row['sms_email_gateway'];
		} else {
			$sms_email_gateway = '';
		}

		return $sms_email_gateway;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
