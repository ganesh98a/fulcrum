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

function phpPhantomContentsWrapper() {

	this.requestPage;
	// this.webHost = 'http://localdev.myfulcrum.com/';
	this.objWebpage = null;
	this.errorHandler = null;
	this._memberArray = {};
	this.options = null;
	this.debugMode = false;

	this.setRequiredParams = function () {

		if (typeof(options.request.url) !== 'undefined') {
			this.options = options;
			if (typeof(options.request.debugMode) !== 'undefined' && options.request.debugMode == 1) {
				this.debugMode = true;
				console.log("options:" + JSON.stringify(this.options));
			}
			this.initializeWebpage();
		}
		else {
			throw 'missing required parameters: (1) options.request.url';
		}
	};

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

	this.initializeWebpage = function () {
		this.objWebpage    = require('webpage').create();
		this.errorHandler = require("./webpage_error_handler").create();
		this.objWebpage.onError = this.errorHandler.onError;
	};

	/*
	* public renderLetter method
	*
	* 1. get member properties
	* 2. assign pdf redender function to onLoadFinished event
	* 3. load and open request url
	*/
	this.getContents = function() {

		//
		if (typeof(this.options.request.url) !== 'undefined') {  //

			var objWebpage = this.objWebpage;

			if(this.debugMode) {
				console.log('pageUrl : ' + this.options.request.url);
			}


			objWebpage.onLoadFinished = function(status) {
				// finish loading file
				if ( status === "success" ) {
					var content = objWebpage.content;
					console.log(JSON.stringify({
						success: true,
						response: content
					}));

					phantom.exit();
				}
			};
			objWebpage.open(this.options.request.url);
		}
	};

	/** reserved for later as private function
	var _privateFunction = function (key, value) {

	}
	*/
}

// this is way how phantomJS to create custom module
exports.create = function(){
	return new phpPhantomContentsWrapper();
};