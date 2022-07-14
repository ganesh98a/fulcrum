(function($) {
	$(document).ready(function() {

$('#darkTheme').click(function(){
		$("body").css('background-color', '#222222');
		$('#primary_background_color').spectrum('set','#222222');
		$("body").css('color', '#f0f0f0');
		$('#primary_font_color').spectrum('set','#f0f0f0');
		$(".ddlPrimaryTextFontFamily").css('background-color', '#222222');
		$(".ddlPrimaryTextFontFamily").css('color', '#f0f0f0');
		$(".bgGray").css('background-color', 'rgb(50, 50, 50)');
		$("#footer").css('background-color', 'rgb(50, 50, 50)');
		//$('#header_background_color').spectrum('set','rgb(50, 50, 50)');
});

$('#lightTheme').click(function(){
		$("body").css('background-color', '#ffffff');
		$("body").css('color', '#000000');
		$(".ddlPrimaryTextFontFamily").css('background-color', '#ffffff');
		$(".ddlPrimaryTextFontFamily").css('color', '#000000');
		$(".bgGray").css('background-color', '#f0f0f0');
		$("#footer").css('background-color', '#ffffff');
});

var changeFunction = function(color) {
        switch($(this).attr('id')){
        	case 'primary_background_color':
				$("body").css('background-color', color.toHexString());
				//$(".ddlPrimaryTextFontFamily").css('background-color', color.toHexString());
				break;
			case 'primary_font_color':
				$("body").css('color', color.toHexString());
				//$(".ddlPrimaryTextFontFamily").css('color', color.toHexString());
				break;
			case 'left_vertical_navigation_background_color':
				$(".leftNavSpacer, #leftNavBottomDiv, #logo").css('background-color', color.toHexString());
				break;
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//
			case 'left_vertical_navigation_header_color':
			case 'left_vertical_navigation_item_color':
			case 'left_vertical_navigation_highlight_color':

				var color2 = $('#left_vertical_navigation_header_color').spectrum('get').toHexString();
				var color3 = $('#left_vertical_navigation_item_color').spectrum('get').toHexString();
				var color4 = $('#left_vertical_navigation_highlight_color').spectrum('get').toHexString();
				var color4rgb = $('#left_vertical_navigation_highlight_color').spectrum('get').toRgb();

				$(".arrowlistmenu ul li a").css('background-color', color3);
				$(".arrowlistmenu ul li a").mouseout(function() {
					$(this).css('background-color', color3);
				});

				$(".arrowlistmenu ul li a").mouseover(function()
			    {
					$(this).css('background-color', color4);//.css('cssText', 'background-color:' + color.toHexString() + '!important;');
				});
				$(".arrowlistmenu ul li a").mouseout(function()
				{
					$(this).css('background-color', color3);//.css('cssText', 'background-color:' + color.toHexString() + '!important;');
				});

				$(".menuheader").css('background-color', color2);

				$(".moduleNavBox .menuheader").mouseover(function()
				{
					$(this).css('background-color', color4);
				});
				$(".moduleNavBox .menuheader").mouseout(function()
				{
					$(this).css('background-color', color2);
				});

				$(".moduleNavBox .menuheader").click(function()
				{
					$('.moduleNavBox .menuheader').css('background-color', color2);
					$(this).css('background-color', color4);
					$(".moduleNavBox .menuheader").mouseover(function()
					{
						$(this).css('background-color', color4);
					});
					$(".moduleNavBox .menuheader").mouseout(function()
					{
						$(this).css('background-color', color2);
					});
					$(this).mouseover(function()
					{
						$(this).css('background-color', color4);
					});
					$(this).mouseout(function()
					{
						$(this).css('background-color', color4);
					});
				});

				$('.projectNavBox .menuheader').mouseover(function()
				{
					$(this).css('background-color', color4);
				});
				$('.projectNavBox .menuheader').mouseout(function()
				{
					$(this).css('background-color', color2);
				});

				$('.projectNavBox .menuheader').click(function()
				{
					$('.projectNavBox .menuheader').css('background-color', color2);
					$(this).css('background-color', color4);
					$('.projectNavBox .menuheader').mouseover(function()
					{
						$(this).css('background-color', color4);
					});
					$('.projectNavBox .menuheader').mouseout(function()
					{
						$(this).css('background-color', color2);
					});
					$(this).mouseover(function()
					{
						$(this).css('background-color', color4);
					});
					$(this).mouseout(function()
					{
						$(this).css('background-color', color4);
					});
				});

				$(".openheader, .openheader2, .selectedProject").css('background-color', color4);
				$(".openheader, .openheader2, .selectedProject").mouseover(function()
				{
					$(this).css('background-color', color4);
				});
				$(".openheader, .openheader2, .selectedProject").mouseout(function()
				{
					$(this).css('background-color', color4);
				});


				$(".selectedFunction").css('cssText', 'background-color:' + color4 + '!important;');//.css('background-color', color.toHexString());
				$(".selectedFunction").mouseover(function() {
					$(this).css('cssText', 'background-color:' + color4 + '!important;');
				});
				$(".selectedFunction").mouseout(function() {
					$(this).css('cssText', 'background-color:' + color4 + '!important;');
				});

    			function arrowColor()
				{
				  var image = document.querySelector(".arrowlistmenu ul li img, .selectedProject img");

				  var myCanvas = document.createElement("canvas");
				  var myCanvasContext = myCanvas.getContext("2d");

			  	  var imgWidth=image.width;
				  var imgHeight=image.height;
				  // You'll get some string error if you fail to specify the dimensions
				  myCanvas.width= imgWidth;
				  myCanvas.height=imgHeight;

				  myCanvasContext.drawImage(image, 0, 0);

				  // This function cannot be called if the image is not from the same domain.
				  // You'll get security error if you do.
				  var imageData = myCanvasContext.getImageData(0, 0, imgWidth, imgHeight);

				  // This loop gets every pixels on the image
				    for ( var i=0; i<imageData.height; i++)
				    {
				      for (var j=0; j<imageData.width; j++)
				      {
				         var index=(i*4)*imageData.width+(j*4);
				         var red=imageData.data[index];
				         var green=imageData.data[index+1];
				         var blue=imageData.data[index+2];
				         //var alpha=imageData.data[index+3];
				         var average=(red+green+blue)/3;
				   	     imageData.data[index]=color4rgb.r;
				         imageData.data[index+1]=color4rgb.g;
				         imageData.data[index+2]=color4rgb.b;
				         //imageData.data[index+3]=alpha;
				       }
				     }
				     myCanvasContext.putImageData(imageData, 0, 0);
				     //document.body.appendChild(myCanvas);
					 var source = myCanvas.toDataURL("image/png");
					 var imageList = document.querySelectorAll(".arrowlistmenu ul li img, .selectedProject img");
				  	 for(var i = 0; i < imageList.length; i++){
				  	   imageList[i].src = source;
				  	 }
					 return myCanvas.toDataURL();
				};
				arrowColor();

				break;
			case 'left_vertical_navigation_header_font_color':
				$(".openheader, .openheader2, .moduleNavBox .menuheader, .projectNavBox .menuheader").css('color', color.toHexString());
				break;
			case 'left_vertical_navigation_item_font_color':
				$(".arrowlistmenu ul li a, .selectedProject, .selectedfunction").css('color', color.toHexString());
				break;
			case 'headers_font_color':
				$("#softwareModuleHeadline").css('color', color.toHexString());
				break;
			case 'header_background_color':
				//$("#softwareModuleHeadline").css('background-color', color.toHexString());
				$(".bgGray").css('background-color', color.toHexString());
				$("#footer").css('background-color', color.toHexString());
				break;
			case 'link_font_color':
				$("a:not(#contentAreaLeft a)").css('color', color.toHexString());
				break;
			case 'button_top_color':
			case 'button_bottom_color':
			    var original = $("input[type='button']").css('background');
			    //alert(original);//rgba(0, 0, 0, 0)     linear-gradient(rgb(255, 255, 0) 0%, rgb(2, 109, 174) 100%)repeat scroll 0% 0% / auto padding-box border-box
			    //inspect element says --> background: linear-gradient(rgb(255, 255, 0) 0%, rgb(2, 109, 174) 100%);
				$("input[type='button']:hover, input[type='submit']:hover, input[type='reset']:hover").css('background', 'none repeat scroll 00 #58b4f1');
				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', color.toHexString());
				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', '-moz-linear-gradient(center top , '+$('#button_top_color').spectrum("get")+' 0%, '+$('#button_bottom_color').spectrum("get")+' 100%) repeat scroll 0 0 transparent');
				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', '-webkit-gradient(linear, left top, left bottom, color-stop(0%, '+$('#button_top_color').spectrum("get")+'), color-stop(100%, '+$('#button_bottom_color').spectrum("get")+'))');
				//                                                                             rgba(0, 0, 0, 0) linear-gradient(rgb(255, 255, 0) 0%, rgb(2, 109, 174) 100%)repeat scroll 0% 0% / auto padding-box border-box
			    //                                                         inspect element says --> background: linear-gradient(rgb(255, 255, 0) 0%, rgb(2, 109, 174) 100%);

				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', '-webkit-linear-gradient(top, '+$('#button_top_color').spectrum("get")+' 0%, '+$('#button_bottom_color').spectrum("get")+' 100%)');
				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', '-o-linear-gradient(top, '+$('#button_top_color').spectrum("get")+' 0%, '+$('#button_bottom_color').spectrum("get")+' 100%)');
				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', '-ms-linear-gradient(top, '+$('#button_top_color').spectrum("get")+' 0%, '+$('#button_bottom_color').spectrum("get")+' 100%)');
				$("input[type='button'], input[type='submit'], input[type='reset']").css('background', 'linear-gradient(to bottom, '+$('#button_top_color').spectrum("get")+' 0%, '+$('#button_bottom_color').spectrum("get")+' 100%)');
				$("input[type='button'], input[type='submit'], input[type='reset']").css('filter', 'progid:DXImageTransform.Microsoft.gradient(startColorstr="'+$('#button_top_color').spectrum("get")+'", endColorstr="'+$('#button_bottom_color').spectrum("get")+'",GradientType=0 )');
				break;
			case 'button_font_color':
				$("input[type='button'], input[type='submit'], input[type='reset']").css('color', color.toHexString());
				break;
			case 'button_border_color':
				$("input[type='button'], input[type='submit'], input[type='reset']").css('border', '1px solid '+color.toHexString());
				break;
        }
}

$(".full").spectrum({
    //color: ,
    showInput: true,
    className: "full-spectrum",
    showButtons: false,
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxSelectionSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    show: function (color) {

    },
    beforeShow: function () {

    },
    hide: function () {

    },
    move: changeFunction,
    change: changeFunction,
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)"],
        ["rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)"],
        ["rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)"],
        ["rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)"],
        ["rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});

$(".ddlTextFontFamily option").each(function () {
		$(this).css({"font-family":$(this).text()});
});

$("#ddlPrimaryTextFontFamily").change(function () {

	var selectedFontFamily = $("#ddlPrimaryTextFontFamily option:selected").text();
	selectedFontFamily = $.trim(selectedFontFamily);

	$("body").css('font-family', selectedFontFamily);

});

$("#ddlTitleTextFontFamily").change(function () {

	var selectedFontFamily = $("#ddlTitleTextFontFamily option:selected").text();
	selectedFontFamily = $.trim(selectedFontFamily);

	$("#softwareModuleHeadline").css('font-family', selectedFontFamily);

});

			$('#primary_background_color').spectrum('set',$("body").css('background-color'));

  			$('#primary_font_color').spectrum('set',$("body").css('color'));

			$('#left_vertical_navigation_background_color').spectrum('set',$('#sidebar').css('background-color'));

			$('#left_vertical_navigation_header_color').spectrum('set',$('#sidebar .projectNavBox').css('background-color'));

			$('#left_vertical_navigation_item_color').spectrum('set',$('.arrowlistmenu ul li a').css('background-color'));

			$('#left_vertical_navigation_highlight_color').spectrum('set',$('.selectedProject').css('background-color'));

			$('#left_vertical_navigation_header_font_color').spectrum('set',$('.menuheader').css('color'));

			$('#left_vertical_navigation_item_font_color').spectrum('set',$('.arrowlistmenu ul li a').css('color'));

			$('#header_background_color').spectrum('set',$("#footer").css('background-color'));

			$('#headers_font_color').spectrum('set',$('#softwareModuleHeadline').css('color'));

			$('#link_font_color').spectrum('set',$('[href="/logout.php"]').css('color'));

			$('#button_top_color').spectrum('set','#21ABE1');

			$('#button_bottom_color').spectrum('set','#026dae');

			$('#button_font_color').spectrum('set','#000000');

			$('#button_border_color').spectrum('set','#026dae')



});
})(jQuery);
