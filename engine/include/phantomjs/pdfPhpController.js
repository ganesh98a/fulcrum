
// get system object to handle argument
var system = require('system');

var args = require('system').args;

// create an instance libPDF object
var objPDF = require('./lib/php-pdf-wrapper').create();

function errorHandler(e)
{
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
		//console.log(args[1]);
		//console.log(options.request.url);

		console.log("\n\n");
		system.args.forEach(function (arg, i) {
			console.log("\n" + i + ': ' + arg);
		});
		console.log("\n\n");
	}

	objPDF.setRequiredParams(options);

	// initialize phantomjs webpage object
	objPDF.initializeWebpage();

	// set up ViewportSize for the webpage object
	objPDF.setDefaultViewportSize();

	// render the PDF as letter
	if (typeof(options.request.pageLayout) !== 'undefined') {
		objPDF.setPageLayout(options.request.pageLayout);
	} else {
		objPDF.setPageLayout('letter');
	}
	objPDF.setfooterdynamic();

	objPDF.renderPDF();

} catch (e) {
	errorHandler(e);
}
