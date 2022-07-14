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

function parseInputToInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	if (input.length == 0) {
		return defaultValue;
	}

	// convert type to string
	var input = input + '';

	// Possible Javascript Types: "boolean", null, "number", "object", "string", "undefined"
	// Not possible to perform replace on other types, so just parseInt()
	if (typeof(input) != 'string') {
		var parsedInteger = parseInt(input);
		return parsedInteger;
	}

	// Replace everything other than 0-9 or - (allow positive or negative numbers)
	var tmpValue = input.replace(/[^-0-9]+/g, '');
	// Replace repeating - with just one -
	tmpValue = tmpValue.replace(/[-]+/g, '-');
	// Replace everything at the end of the input with just numbers 0-9: this removes a single "-" that was at the end of the input
	tmpValue = tmpValue.replace(/[^0-9]+$/g, '');

	if (tmpValue.length == 0) {
		return defaultValue;
	}

	if ((tmpValue !== '') && (isNaN(tmpValue) == false)) {

		// Debug
		//alert(tmpValue);

		// convert to integer
		var value = parseInt(tmpValue);

		// Debug
		//alert(value);

	} else {

		var value = defaultValue;

	}

	return value;

}

function parseInputToDigits(input, defaultValue)
{
	// Possible default values: "", 000, 01, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	if (input.length == 0) {
		return defaultValue;
	}

	// convert type to string
	var input = input + '';

	// Possible Javascript Types: "boolean", null, "number", "object", "string", "undefined"
	// Not possible to perform replace on other types, so just parseInt()
	if (typeof(input) != 'string') {
		return defaultValue;
	}

	// Replace everything other than 0-9 (digits only)
	var value = input.replace(/[^0-9]+/g, '');

	if (value.length == 0) {
		return defaultValue;
	}

	return value;

}

function parseInputToFloat(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	if (typeof defaultValue == 'undefined') {
		var defaultValue = parseFloat(0.00);
		defaultValue = defaultValue.toFixed(2);
	}

	if (!input) {
		return defaultValue;
	}

	// Possible Javascript Types: "boolean", null, "number", "object", "string", "undefined"
	// Not possible to perform replace on other types, so just parseInt()
	if (typeof(input) != 'string') {
		var parsedFloat = parseFloat(input);
		return parsedFloat;
	}

	if (input.length == 0) {
		return defaultValue;
	}

	// Replace everything other than 0-9 or - or . (allow positive or negative floating point numbers)
	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
	// Replace repeating - with just one -
	tmpValue = tmpValue.replace(/[-]+/g, '-');
	// Replace everything at the end of the input with just numbers 0-9: this removes a single "-" that was at the end of the input
	tmpValue = tmpValue.replace(/[^0-9]+$/g, '');

	if (tmpValue.length == 0) {
		return defaultValue;
	}

	if ((tmpValue !== '') && (isNaN(tmpValue) == false)) {

		// Debug
		//alert(tmpValue);

		// convert to floating point number
		var value = parseFloat(tmpValue);

		// Debug
		//alert(value);

	} else {

		var value = defaultValue;

	}

	return value;

}

function parseInputToMySQLTinyInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (input < -128) {
		throw new UserException("must be greater than -128");
	}

	// Validation: max
	if (input > 127) {
		throw new UserException("must be less than or equal to 127");
	}

	return parsedInt;
}

function parseInputToMySQLUnsignedTinyInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < 0) {
		throw new UserException("must be greater than or equal to 0");
	}

	// Validation: max
	if (parsedInt > 256) {
		throw new UserException("must be less than or equal to 256");
	}

	return parsedInt;
}

function parseInputToMySQLSmallInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < -32768) {
		throw new UserException("must be greater than -32,768");
	}

	// Validation: max
	if (parsedInt > -32767) {
		throw new UserException("must be less than or equal to 32,767");
	}

	return parsedInt;
}

function parseInputToMySQLUnsignedSmallInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < 0) {
		throw new UserException("must be greater than or equal to 0");
	}

	// Validation: max
	if (parsedInt > 65535) {
		throw new UserException("must be less than or equal to 65,535");
	}

	return parsedInt;
}

function parseInputToMySQLMediumInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < -8388608) {
		throw new UserException("must be greater than -8,388,608");
	}

	// Validation: max
	if (parsedInt > 8388607) {
		throw new UserException("must be less than or equal to 8,388,607");
	}

	return parsedInt;
}

function parseInputToMySQLUnsignedMediumInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < 0) {
		throw new UserException("must be greater than or equal to 0");
	}

	// Validation: max
	if (parsedInt > 16777215) {
		throw new UserException("must be less than or equal to 16,777,215");
	}

	return parsedInt;
}

function parseInputToMySQLInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < -2147483648) {
		throw new UserException("must be greater than -2,147,483,648");
	}

	// Validation: max
	if (parsedInt > 2147483647) {
		throw new UserException(input + " must be less than or equal to 2,147,483,647");
	}

	return parsedInt;
}

function parseInputToMySQLUnsignedInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < 0) {
		throw new UserException("must be greater than or equal to 0");
	}

	// Validation: max
	if (parsedInt > 4294967295) {
		throw new UserException(input + " must be less than or equal to 4,294,967,295");
	}

	return parsedInt;
}

function parseInputToMySQLBigInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < -9223372036854775808) {
		throw new UserException("must be greater than -9,223,372,036,854,775,808");
	}

	// Validation: max
	if (parsedInt > 9223372036854775807) {
		throw new UserException("must be less than or equal to 9,223,372,036,854,775,807");
	}

	return parsedInt;
}

function parseInputToMySQLUnsignedBigInt(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	var parsedInt = parseInputToInt(input);

	// Validation: min
	if (parsedInt < 0) {
		throw new UserException("must be greater than or equal to 0");
	}

	// Validation: max
	if (parsedInt > 18446744073709551615) {
		throw new UserException("must be less than or equal to 18,446,744,073,709,551,615");
	}

	return parsedInt;
}

function parseInputToMySQLDate(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	// Possible Javascript Types: "boolean", null, "number", "object", "string", "undefined"
	if (typeof(input) != 'string') {
		return defaultValue;
	}

	if (input.length == 0) {
		return defaultValue;
	}

	// 'min' => '1000-01-01 00:00:00',
	// 'max' => '9999-12-31 23:59:59',
	// 'regex' => '/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])$/',

	var value = input.replace(/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])$/g, '');

	if (value.length == 0) {
		return defaultValue;
	}

	return value;
}

function parseInputToMySQLDatetime(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	// Possible Javascript Types: "boolean", null, "number", "object", "string", "undefined"
	if (typeof(input) != 'string') {
		return defaultValue;
	}

	if (input.length == 0) {
		return defaultValue;
	}

	// 'min' => '1000-01-01 00:00:00',
	// 'max' => '9999-12-31 23:59:59',
	// 'regex' => '/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/',

	var value = input.replace(/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/g, '');

	if (value.length == 0) {
		return defaultValue;
	}

	return value;
}

function parseInputToMySQLTimestamp(input, defaultValue)
{
	// Possible default values: "", 0, 1, etc.
	// If the defaultValue variable was not passed as an argument, create it here.
	var defaultValue = defaultValue || '';

	if (!input) {
		return defaultValue;
	}

	// Possible Javascript Types: "boolean", null, "number", "object", "string", "undefined"
	if (typeof(input) != 'string') {
		return defaultValue;
	}

	if (input.length == 0) {
		return defaultValue;
	}

	// @todo Check min / max values
	// 'min' => '1970-01-01 00:00:01', // UTC
	// 'max' => '2038-01-19 03:14:07', // UTC
	// 'regex' => '/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/',

	var value = input.replace(/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/g, '');

	if (value.length == 0) {
		return defaultValue;
	}

	return value;
}

function convertDateToMySQLFormat(input, defaultValue)
{
	try {

		// Possible default values: "", 0, 1, etc.
		// If the defaultValue variable was not passed as an argument, create it here.
		var defaultValue = defaultValue || '';

		if (!input) {
			return defaultValue;
		}

		if ((typeof input == 'undefined') || (input.length == 0)) {
			return defaultValue;
		}

		var date = new Date(input);

		var year = date.getFullYear();
		if (isNaN(year)) {
			return defaultValue;
		}
		var month = (date.getMonth() + 1);
		if (isNaN(month)) {
			return defaultValue;
		}
		var day = date.getDate();
		if (isNaN(day)) {
			return defaultValue;
		}
		if (month < 10) {
			month = '0' + month;
		}
		if (day < 10) {
			day = '0' + day;
		}

		// Check for Feb 29 on a leap year
		if (month == '02') {
			var leapYear = ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
			if (leapYear) {
				var tmp = input.replace(year, '');
				var index = tmp.indexOf('29');
				if (index > -1) {
					day = 29;
				}
			}
		}

		var mysqlDate = '' + year + '-' + month + '-' + day;

		return mysqlDate;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function convertTimeToMySQLFormat(input, defaultValue)
{
	try {

		// Possible default values: "", 0, 1, etc.
		// If the defaultValue variable was not passed as an argument, create it here.
		var defaultValue = defaultValue || '';

		if (!input) {
			return defaultValue;
		}

		if ((typeof input == 'undefined') || (input.length == 0)) {
			return defaultValue;
		}

		var tokens = input.split(':');
		var suffix1 = input.substring(input.length-1);
		var suffix2 = input.substring(input.length-2);
		suffix1 = suffix1.toLowerCase();
		suffix2 = suffix2.toLowerCase();
		if (suffix1 == 'p' || suffix2 == 'pm') {
			var hourString = tokens[0];
			var hourInt = parseInt(hourString);
			if (isNaN(hourInt)) {
				return defaultValue;
			}
			if (hourInt > 0 && hourInt < 12) {
				hourInt += 12;
			}
			hourString = hourInt.toString();
			tokens[0] = hourString;
		}

		for (var i = 0; i < tokens.length; i++) {
			var tokenString = tokens[i];
			if (tokenString.length > 2) {
				tokenString = tokenString.substring(0, 2);
			}
			var tokenInt = parseInt(tokenString);
			if (isNaN(tokenInt)) {
				return defaultValue;
			}
			tokenString = tokenInt.toString();
			if (tokenString.length == 1) {
				tokenString = '0' + tokenString;
			}
			tokens[i] = tokenString;
		}

		var time = tokens.join(':');
		time += ':00';

		return time;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return defaultValue;
		}

	}

	return defaultValue;

}

function convertDatetimeToMySQLFormat(input, defaultValue, timePortion)
{
	try {

		// Possible default values: "", '0000-00-00 00:00:00', etc.
		// If the defaultValue variable was not passed as an argument, create it here.
		var defaultValue = defaultValue || '0000-00-00 00:00:00';
		var timePortion = timePortion || '00:00:00';

		if (!input) {
			return defaultValue;
		}

		if ((typeof input == 'undefined') || (input.length == 0)) {
			return defaultValue;
		}

		var mysqlDatetime = convertTimestampToMySQLFormat(input, defaultValue, timePortion);

		return mysqlDatetime;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * @var timePortion can be:
 *  Ommitted and will default to: '00:00:00'
 *  The actual time value itself.
 *  'useNowAsTimePortion' to use "now"
 *  'deriveFromInput' to use the input to derive time
 *
 */
function convertTimestampToMySQLFormat(input, defaultValue, timePortion)
{
	try {

		// Possible default values: "", '0000-00-00 00:00:00', etc.
		// If the defaultValue variable was not passed as an argument, create it here.
		var defaultValue = defaultValue || '0000-00-00 00:00:00';
		var timePortion = timePortion || '00:00:00';

		if (!input) {
			return defaultValue;
		}

		if ((typeof input == 'undefined') || (input.length == 0)) {
			return defaultValue;
		}

		var date = new Date(input);

		var year = date.getFullYear();
		if (isNaN(year)) {
			return defaultValue;
		}
		var month = (date.getMonth() + 1);
		if (isNaN(month)) {
			return defaultValue;
		}
		var day = date.getDate();
		if (isNaN(day)) {
			return defaultValue;
		}
		if (month < 10) {
			month = '0' + month;
		}
		if (day < 10) {
			day = '0' + day;
		}

		if (timePortion == 'deriveFromInput') {
			var timePortion = date.getTime();
		} else if (timePortion == 'useNowAsTimePortion') {
			var tmpDate = new Date();
			var timePortion = tmpDate.getTime();
			//var unixTimestamp = Date.now(); // in milliseconds
		}

		var mysqlTimestamp = '' + year + '-' + month + '-' + day + ' ' + timePortion;

		return mysqlTimestamp;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function parsePhoneNumber(phoneNumber)
{
	try {

		// Bulletproof this function some more.
		phoneNumber = phoneNumber.replace(/\D/g, '');
		var area_code = phoneNumber.substring(0, 3);
		var prefix = phoneNumber.substring(3, 6);
		var number = phoneNumber.substring(6, 10);

		return [ area_code, prefix, number ];

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function parseInputToCurrency(input, defaultValue)
{
	// If the defaultValue variable was not passed as an argument, create it here.
	if (typeof defaultValue == 'undefined') {
		var defaultValue = parseFloat(0.00);
		defaultValue = defaultValue.toFixed(2);
	}

	if ((input == '') || (input == 0.00) || (input == '$0.00') || (input === false)) {
		//return '';
		return defaultValue;
	}

	// convert type to string
	var input = input + '';

	// strip out all non-numeric values
	//var tmpValue = accounting.unformat(input);

	// Replace everything other than 0-9 or - or .
	var tmpValue = input.replace(/[^-0-9\.]+/g, '');

	// Replace repeating - with just one -
	tmpValue = tmpValue.replace(/[-]+/g, '-');

	// Replace everything at the end of the input with just numbers 0-9: this removes a single "-" that was at the end of the input
	tmpValue = tmpValue.replace(/[^0-9]+$/g, '');

	if (tmpValue.length == 0) {
		return defaultValue;
	}

	if ((tmpValue !== '') && (isNaN(tmpValue) == false)) {

		// Debug
		//alert(tmpValue);

		// convert to floating point number
		var value = parseFloat(tmpValue);

		// Debug
		//alert(value);

		// Format as money
		value = accounting.toFixed(value, 2);

		// Debug
		//alert(value);

		// convert to floating point number
		value = parseFloat(value);
		value = value.toFixed(2);

	} else {

		var value = defaultValue;

	}

	return value;

}

function formatDollar(num)
{
	result = accounting.formatMoney(num, {
		symbol: "$",
		decimal : ".",
		thousand: ",",
		precision: 2,
		format: {
			pos : "%s%v",
			neg : "-%s%v",
			//neg : "(%s%v)",
			//zero: "%s --"
			zero: "%s0.00"
		}
	});

	return result;

	/*
	var p = num.toFixed(2).split(".");
	return "$" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
		return num + (i && !(i % 3) ? "," : "") + acc;
	}, "") + "." + p[1];
	*/
}

Number.prototype.formatMoney = function(c, d, t)
{
	var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : '', i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + '', j = (j = i.length) > 3 ? j % 3 : 0;
	var newString = s + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');

	return formatNegativeNumber(newString);
};

function formatNegativeNumber(amt)
{
	var newAmt = amt;
	if (amt.charAt(0) == '-') {
		newAmt = newAmt.replace('-', '(');
		newAmt = newAmt.toString() + ')';
	}

	return newAmt;
}

//If single digit add zero.
function pad2(number) {   
     return (number < 10 ? '0' : '') + number   
}

function convertStringToDate(stringDate){

	var newDate = new Date(stringDate);

	var date = newDate.getDate();
	var month = newDate.getMonth()+1;
	var year = newDate.getFullYear();

	date = pad2(date);month = pad2(month);

	var convertDate = month+'/'+date+'/'+year;

	return convertDate;
}
