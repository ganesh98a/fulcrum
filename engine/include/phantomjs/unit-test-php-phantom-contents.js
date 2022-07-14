// example to call this js
// phantomjs.exe phantom\unittest-pdf.js unit-test-phantom-pdf.php testletter1.pdf



// get system object to handle argument
var args = require('system').args;


// create an instance libPDF object
var objPhpPhantomContentsWrapper = require("./lib/php-phantom-contents-wrapper").create();

function errorHandler(e) {
	console.log(JSON.stringify({
		success: false,
		response: e.toString()
	}));
	// Stop the script
	phantom.exit(0);
}
try {
	if (args.length < 2) {
		throw 'You must pass the URI and the Destination param!';
	}
	var options = JSON.parse(args[1]);
	if (typeof(options.request.debugMode) !== 'undefined' && options.request.debugMode == 1) {
		console.log(args[1]);
		console.log(options.request.url);
	}

	objPhpPhantomContentsWrapper.setRequiredParams(options);

	objPhpPhantomContentsWrapper.getContents();

} catch (e) {
	errorHandler(e);
}

