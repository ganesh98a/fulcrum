// exampel to call this js
// phantomjs.exe phantom\unittest-pdf.js unit-test-phantom-pdf.php testletter1.pdf

// get system object to handle argument
var args = require('system').args;

// create an instance libPDF object
var objPDF = require("./lib/pdf_class").create();

// check argument
objPDF.checkArguments(args);

// initialize phantomjs webpage object
objPDF.initializeWebpage();

// set up properties for the webpage object
objPDF.setWebpageProperties();

// render the PDF as letter
objPDF.renderLetter();






