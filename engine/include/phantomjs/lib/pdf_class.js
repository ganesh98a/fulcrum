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
 * PDFClass wrapper to generate phantom PDF document
 *
 */

function PDFClass() {


	this.pdfFilename;
	this.requestPage;
	this.webHost = 'http://localdev.myfulcrum.com/';
	this.objWebpage = null;
	this.errorHandler = null;
	this._memberArray = {};

	/*
	 * public set method
	 */
	this.set = function (key, value) {
		this._memberArray[key] = value;
	};

	/*
	 * public get method
	 */
	this.get = function (key) {
		if(typeof (this._memberArray[key]) !== 'undefined') {
			return(this._memberArray[key]);
		}
		else {
			return;
		}
	};

	/*
	 * public initializeWebpage method
	 *
	 * 1. initialize webpage object
	 * 2. initialize error handler object
	 * 3. assign error handler for webpage object
	 */
	this.initializeWebpage = function () {
		 this.objWebpage    = require('webpage').create();
		 this.errorHandler = require("./webpage_error_handler").create();
		 this.objWebpage.onError = this.errorHandler.onError;
	};

	/*
	 * public setWebpageProperties method
	 *
	 * setWebpageProperties for certain default properties
	 */
	this.setWebpageProperties = function () {
		this.objWebpage.viewportSize = { width: 1024, height: 768 };
	};

	/*
	 * public setPDFSizeToLetter method
	 *
	 * set PDF page Size To US Letter
	 */
	this.setPDFSizeToLetter = function () {
		console.log('call setPDFSizeToLetter');

		this.objWebpage.paperSize = {
			format:      'Letter',
			orientation: 'portrait',
			border:      '0.5in'
		};
	}

	/*
	 * public checkArguments method
	 *
	 * check arguments passing in to program
	 */
	this.checkArguments = function(args) {
		if (typeof(args[1]) !== undefined  && args.length > 2) {
			//console.log("it is " + args.length);

			var fileNameRegular = /\w+\.pdf$/;
			var test = fileNameRegular.test(args[2]);
			if(test) {
				console.log(args[2] + " is a valid PDF extension");
			}
			else {
				console.log(args[2] + " is an invalid PDF extension");
				console.log('Example Usage: phantomjs thisScriptname.js unit-test-phantom-pdf.php test.pdf');
				phantom.exit();
			}
			this.set("pageUrl", this.webHost + args[1]);
			this.set("pdfFilename", args[2]);
			return true;
		}
		else {
			console.log("No (1) file name nor (2) script name given. Please pass in both.\nExit.");
			console.log('Example Usage: phantomjs thisScriptname.js unit-test-phantom-pdf.php test.pdf');

			phantom.exit();
		}
	};


	/*
	 * public renderLetter method
	 *
	 * 1. get member properties
	 * 2. assign pdf redender function to onLoadFinished event
	 * 3. load and open request url
	 */
	this.renderLetter = function() {

		//
		var pdfFilename = this.get('pdfFilename');
		var pageUrl = this.get('pageUrl');

		this.setPDFSizeToLetter();
		var objWebpage = this.objWebpage;


		console.log('pageUrl ee: ' + this.objWebpage);
		console.log('pdfFilename ee: ' + pdfFilename);
		//console.log('Finished loading PDF Report. Generate report now ...' + );
		//phantom.exit();

		objWebpage.onLoadFinished = function(status) {
			// finish loading file
			if ( status === "success" ) {
				console.log('Finished loading PDF Report. Generate report now ...' + pdfFilename);
				objWebpage.render(pdfFilename, { quality: 100 });
				phantom.exit();
			}
		};

		objWebpage.open(pageUrl);
	};

	/** reserved for later as private function
	var _privateFunction = function (key, value) {

	}
	*/
}

// this is way how phantomJS to create custom module
exports.create = function(){
	return new PDFClass();
};