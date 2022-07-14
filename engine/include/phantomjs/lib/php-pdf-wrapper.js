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

function phpPDFWrapper()
{

	this.pdfFilename;
	this.requestPage;
	// this.webHost = 'http://localdev.myfulcrum.com/';
	this.objWebpage = null;
	this.errorHandler = null;
	this._memberArray = {};
	this.options = null;
	this.debugMode = false;
	this.marginTop = '0.5in';
	this.marginLeft = '0.5in';
	this.marginRight = '0.5in';
	this.marginBottom = '0.5in';


	this.setRequiredParams = function () {

		if (typeof(options.request.url) !== 'undefined'  && typeof(options.request.completePdfFilePath) !== 'undefined') {

			this.options = options;
			if (typeof(options.request.debugMode) !== 'undefined' && options.request.debugMode == 1) {
				this.debugMode = true;
				console.log('options:' + JSON.stringify(this.options));
			}

			// set margin if given
			if (
			typeof(options.request.margin) !== 'undefined'
			&&
			typeof(options.request.margin.top) !== 'undefined'
			&&
			typeof(options.request.margin.left) !== 'undefined'
			&&
			typeof(options.request.margin.right) !== 'undefined'
			&&
			typeof(options.request.margin.bottom) !== 'undefined'
			) {
				this.marginTop = options.request.margin.top;
				this.marginLeft = options.request.margin.left;
				this.marginRight = options.request.margin.right;
				this.marginBottom = options.request.margin.bottom;
			}

		} else {
			throw 'missing required parameters: (1) options.request.url and (2) options.request.completePdfFilePath';
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
		if (typeof (this._memberArray[key]) !== 'undefined') {
			return(this._memberArray[key]);
		} else {
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
		this.objWebpage = require('webpage').create();
		this.errorHandler = require('./webpage_error_handler').create();
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

	this.setDefaultViewportSize = function () {
		this.objWebpage.viewportSize = { width: 1024, height: 768 };
	};


	this.setViewportSize = function (width, height) {
		this.objWebpage.viewportSize = { 'width': width, 'height': height };
	};

	this.setPageLayout = function (PDFLayout) {
		if (PDFLayout == 'letter') {
			this.setPDFSizeToLetter();
		} else {
			throw 'only support letter at the moment';
		}
	};
	this.setfooterdynamic=function()
	{
		// if (typeof(options.request.dynamicContent) !== 'undefined') {
			this.objWebpage.dynamicContent = {
				footer: {height: "1.5cm",contents: phantom.callback(function(pageNum, numPages) {
  					  						
  						var today = new Date();
						//var dd = today.getDate();
						var dd = ("0" + today.getDate()).slice(-2);
						//var mm = today.getMonth()+1; //January is 0!
						var mm = ("0"+ (today.getMonth() + 1)).slice(-2); //January is 0!
						var yy = today.getFullYear();
  					return '<div style="display:block;padding:8px;overflow:hidden;text-align:center;clear:both;"><div style="float:left;">printed : '+mm+' / '+dd+' / ' +yy+'</div><div style="display:inline;">'+options.request.dynamicContent+'</div><div style="float:right;"> Page '+pageNum+' of '+numPages+' </div></div>';
  				
  				})}
			};
		// }
	};
	
	/*
	* public setPDFSizeToLetter method
	*
	* set PDF page Size To US Letter
	*/
	this.setPDFSizeToLetter = function () {
		if ( (typeof(options.request.paperSize) !== 'undefined' && typeof(options.request.paperSize.width) !== 'undefined' && typeof(options.request.paperSize.height) !== 'undefined' ) && (options.request.pdfModule != 'DailyLog')) {
			this.objWebpage.paperSize = {
				width: options.request.paperSize.width,
				height: options.request.paperSize.height,
				orientation: 'portrait',
				margin: {
    				top: this.marginTop,
    				left: this.marginLeft,
    				right: this.marginRight,
    				bottom: this.marginBottom
  				},
  				
  				footer: {height: "1.5cm",contents: phantom.callback(function(pageNum, numPages) {
  					  						
  						var today = new Date();
						//var dd = today.getDate();
						var dd = ("0" + today.getDate()).slice(-2);
						//var mm = today.getMonth()+1; //January is 0!
						var mm = ("0"+ (today.getMonth() + 1)).slice(-2); //January is 0!
						var yy = today.getFullYear();
						if(options.request.dynamicContent !== undefined)
						{
							var address=options.request.dynamicContent;
						if(options.request.logoContent !== undefined)
						{
							var logo=options.request.logoContent;
							
							return '<div style="display:block;padding:8px;overflow:hidden;text-align:center;clear:both;font-size:10px;"><div style="float:left;">Printed : '+mm+'/'+dd+'/' +yy+'</div><div style="display:inline;">'+address+'</div><div style="float:right;"><img src='+logo+'></div></div>';
						}else
						{
						
  					return '<div style="display:block;padding:8px;overflow:hidden;text-align:center;clear:both;font-size:10px;"><div style="float:left;">Printed : '+mm+'/'+dd+'/' +yy+'</div><div style="display:inline;">'+address+'</div><div style="float:right;"> Page '+pageNum+' of '+numPages+' </div></div>';
					}
  				}
  					else
  					{
  						return '';
  					}
  				
  				})} 
			};
		} else {
			this.objWebpage.paperSize = {
				format:      'Letter',
				orientation: 'portrait',
				margin: {
    				top: this.marginTop,
    				left: this.marginLeft,
    				right: this.marginRight,
    				bottom: this.marginBottom
  				},
  				footer: {height: "1cm",contents: phantom.callback(function(pageNum, numPages) {
  					  						
  						var today = new Date();
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!
						var yy = today.getFullYear();

						if(options.request.dynamicContent !== undefined)
						{
							var address=options.request.dynamicContent;
						if(pageNum==numPages)
						{
						
  					return '<div style="display:block;padding:8px;overflow:hidden;text-align:center;clear:both;font-size:14px;border-top:1px solid #bbb;"><div style="float:left;color:#a2a2a2;">'+address+'</div></div>';
  				}else
  				{
  					return '';
  				}
  				}
  					else
  						return '';
  				
  				})}
			};
		}
	};

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
			if (test) {
				console.log(args[2] + " is a valid PDF extension");
			} else {
				console.log(args[2] + " is an invalid PDF extension");
				console.log('Example Usage: phantomjs thisScriptname.js unit-test-phantom-pdf.php test.pdf');
				phantom.exit();
			}
			this.set('pageUrl', args[1]);
			this.set('pdfFilename', args[2]);
			return true;
		} else {
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
	this.renderPDF = function() {

		//
		if ((typeof(this.options.request.url) !== 'undefined'  && typeof(this.options.request.completePdfFilePath) !== 'undefined')) {  //

			//var pdfFilename = this.get('pdfFilename');
			//var pageUrl = this.get('pageUrl');

			this.setPDFSizeToLetter();
			var objWebpage = this.objWebpage;

			if (this.debugMode) {
				console.log('pageUrl : ' + this.options.request.url);
				console.log('pdfFilename : ' + this.options.request.completePdfFilePath);
			}
			//console.log('Finished loading PDF Report. Generate report now ...' + );
			//phantom.exit();

			objWebpage.onLoadFinished = function(status) {

				// finish loading file
				if (status === 'success') {
					if (this.debugMode) {
						console.log('Finished loading PDF Report. Generate report now ...' + this.options.request.completePdfFilePath);
					}

					objWebpage.render(this.options.request.completePdfFilePath, { quality: 100 });

					console.log(JSON.stringify({
						success: true,
						response: 'success'
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
	return new phpPDFWrapper();
};
