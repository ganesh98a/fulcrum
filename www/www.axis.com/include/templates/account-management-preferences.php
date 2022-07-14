
<div class="headerStyle">Account Management - Preferences</div>

<?php

if (isset($htmlMessages) && !empty($htmlMessages)) {
	$tmpHtml = <<<END_TMP_HTML

<div style="margin-top: 5px;">$htmlMessages</div>
END_TMP_HTML;
	echo $tmpHtml;
}

?>

<?php

if (isset($hideForm) && $hideForm) {
	$tmpHtml = <<<END_TMP_HTML

<input value="Click Here to Try Updating Your Security Information Again" type="button" onclick="window.location='$startOverUrl';">
END_TMP_HTML;
	echo $tmpHtml;

} else {

?>
<form name="frm_account_management_security_information" action="account-management-security-information-form-submit.php" method="post">
<table border="1" width="100%" cellspacing="0" cellpadding="3">
	<tr>
	    <strong>Theme:</strong>&nbsp;&nbsp;
		<input type="radio" class="theme" id="lightTheme" name="theme" value="light" checked>Light&nbsp;&nbsp;
		<input type="radio" class="theme" id="darkTheme" name="theme" value="dark">Dark
	</tr>
	<tr>
	   <h2>Color Options</h2>
	   <table>
	   		<tr>
				<td>Primary Background Color </td>
				<td><input type='text' class='full' id='primary_background_color'/></td>
				<td><em id='primary_background_color_text'></em></td>
			</tr>
			<tr>
				<td>Primary Font </td>
				<td><input type='text' class='full' id='primary_font_color'/></td>
				<td><em id='primary_font_color_text'></em></td>
			</tr>
			<tr>
				<td>Left Vertical Navigation Background Color</td>
				<td><input type='text' class='full' id='left_vertical_navigation_background_color'/></td>
				<td><em id='left_vertical_navigation_background_color_text'></em></td>
			</tr>
			<tr>
				<td>Left Vertical Navigation Headers</td>
				<td><input type='text' class='full' id='left_vertical_navigation_header_color'/></td>
				<td><em id='left_vertical_navigation_header_color_text'></em></td>
			</tr>
			<tr>
				<td>Left Vertical Navigation Items</td>
				<td><input type='text' class='full' id='left_vertical_navigation_item_color'/></td>
				<td><em id='left_vertical_navigation_item_color_text'></em></td>
			</tr>
			<tr>
				<td>Left Vertical Navigation Highlight</td>
				<td><input type='text' class='full' id='left_vertical_navigation_highlight_color'/></td>
				<td><em id='left_vertical_navigation_highlight_color_text'></em></td>
			</tr>
			<tr>
			<td>Left Vertical Navigation Header Font</td>
				<td><input type='text' class='full' id='left_vertical_navigation_header_font_color'/></td>
				<td><em id='left_vertical_navigation_header_font_color_text'></em></td>
			</tr>
			<tr>
				<td>Left Vertical Navigation Item Font</td>
				<td><input type='text' class='full' id='left_vertical_navigation_item_font_color'/></td>
				<td><em id='left_vertical_navigation_item_font_color_text'></em></td>
			</tr>
			<tr>
				<td>Header Background </td>
				<td><input type='text' class='full' id='header_background_color'/></td>
				<td><em id='header_background_color_text'></em></td>
			</tr>
			<tr>
				<td>HeadersFont </td>
				<td><input type='text' class='full' id='headers_font_color'/></td>
				<td><em id='headers_font_color_text'></em></td>
			</tr>
			<tr>
				<td>Link Font </td>
				<td><input type='text' class='full' id='link_font_color'/></td>
				<td><em id='link_font_color_text'></em></td>
			</tr>
			<tr>
				<td>Separators </td>
				<td><input type='text' class='full' id='separators'/></td>
				<td><em id='separators_text'></em></td>
			</tr>
			<tr>
				<td>Table Highlight </td>
				<td><input type='text' class='full' id='table_highlight'/></td>
				<td><em id='table_highlight_text'></em></td>
			</tr>
			<tr>
				<td>Table Hover </td>
				<td><input type='text' class='full' id='table_hover'/></td>
				<td><em id='table_hover_text'></em></td>
			</tr>
			<tr>
				<td>Button Top</td>
				<td><input type='text' class='full' id='button_top_color'/></td>
				<td><em id='button_top_color_text'></em></td>
			</tr>
			<tr>
				<td>Button Bottom</td>
				<td><input type='text' class='full' id='button_bottom_color'/></td>
				<td><em id='button_bottom_color_text'></em></td>
			</tr>
			<tr>
				<td>Button Font</td>
				<td><input type='text' class='full' id='button_font_color'/></td>
				<td><em id='button_font_color_text'></em></td>
			</tr>
			<tr>
				<td>Button Border</td>
				<td><input type='text' class='full' id='button_border_color'/></td>
				<td><em id='button_boarder_color_text'></em></td>
			</tr>
	   </table>
	</tr>
	<tr>
	   <table>
	   <h2>Font Options</h2>
	   		<tr>
				<td>Primary Text Font </td>
				<td><div id="sample">
					<select id="ddlPrimaryTextFontFamily" class="ddlTextFontFamily" >
						<option>Select Font</option>
						<!--default fonts-->
						<option>Arial</option>
						<option>Comic Sans MS</option>
						<option>Trebuchet MS</option>
						<option>Verdana</option>
						<option>Courier New</option>
						<option>Tahoma</option>
						<option>Lucida Sans Unicode</option>
						<option>Lucida Console</option>
						<option>Impact</option>
						<option>Arial Black</option>
						<!--google fonts-->
						<option>Averia Sans Libre</option>
						<option>Righteous</option>
						<option>Sancreek</option>
						<option>Alegreya SC </option>
						<option>Merienda One</option>
						<option>Aldrich</option>
						<option>Nothing You Could Do</option>

					  </select>
				</div></td>
			</tr>
			<tr>
				<td>Title Font </td>
				<td><div id="sample">
					<select id="ddlTitleTextFontFamily" class="ddlTextFontFamily" >
						<option>Select Font</option>
						<!--default fonts-->
						<option>Arial</option>
						<option>Comic Sans MS</option>
						<option>Trebuchet MS</option>
						<option>Verdana</option>
						<option>Courier New</option>
						<option>Tahoma</option>
						<option>Lucida Sans Unicode</option>
						<option>Lucida Console</option>
						<option>Impact</option>
						<option>Arial Black</option>
						<!--google fonts-->
						<option>Averia Sans Libre</option>
						<option>Righteous</option>
						<option>Sancreek</option>
						<option>Alegreya SC </option>
						<option>Merienda One</option>
						<option>Aldrich</option>
						<option>Nothing You Could Do</option>

					  </select>
				</div></td>
			</tr>
	   </table>
	</tr>
	<tr>
		<td align="left" width="100%">

			<br>
			<br>
			<input type="reset" value="    Reset Form    " name="Submit1" tabindex="22" onclick="window.location.reload()">&nbsp;|&nbsp;<input type="submit" value="   Save Changes   " name="Submit2" tabindex="21">

		</td>
	</tr>
</table>

</form>
<style type="text/css">
	body {

		<?php if (isset($get) && ($get->showBackgroundImage == 1)) { ?>
		background-image: url('/images/backgrounds/background_images/logoapple.jpg');
		<?php } ?>

		background-position: center;
	}
</style>
<?php
}
?>
<!--#contentAreaRight{
	background-color: rgba(255,255,255,50);
	} -->