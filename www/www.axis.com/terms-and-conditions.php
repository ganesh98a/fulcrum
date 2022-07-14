<?php
/**
 * Contact Us.
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = false;
$init['https_admin'] = false;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');


$htmlTitle = 'Terms And Conditions';
$htmlBody = "";

$headline = 'Terms And Conditions';
$template->assign('headline', $headline);

//retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

<style>
#wrapper {
	border: 0px solid #f0f0f0;
	margin-left: auto;
	margin-right: auto;
	width: 800px;
}

p {
	color: #8B8E90;
	margin-top: 0px;
	vertical-align:middle;
}
</style>
END_HTML_CSS;


$template->assign('queryString', $uri->queryString);

require('template-assignments/main.php');

$htmlContent = <<<END_HTML_CONTENT
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td width="100%" height="18">
	<table border="0" cellspacing="0" width="100%">
	<tr>
	<td colspan="2" height="22">
	<h2 align="center"><span class="title"><i><font color="#000080">MyFulcrum.com
	End-User License Agreement</font></i></span></h2>
	</td>
	</tr>
	</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td nowrap><div style="margin-left:150px;">$htmlMessages</div></td></tr>
	<tr>
	<td width="100%" height="150">
	<p align="center"><textarea class="OTOUCBx" id="taTOUContent" title="End-User License Agreement" style="width: 663px; height: 200px;" name="taTOUContent" rows="6" readOnly cols="40">
END-USER LICENSE AGREEMENT FOR MYFULCRUM.COM SOFTWARE

IMPORTANT - READ CAREFULLY: This End-User License Agreement ("Agreement") is a legal agreement between you (either an individual or a single entity) and MyFulcrum.com for the MyFulcrum.com software product, which includes computer executable code and may include associated media, printed materials, and "online" or electronic documentation ("PRODUCT"). The PRODUCT also may include any updates and supplements to the original PRODUCT and or third party software product provided to you by MyFulcrum.com. Any software provided along with the PRODUCT that is associated with a separate end-user license agreement is licensed to you under the terms of that license agreement. BY INSTALLING, COPYING, DOWNLOADING, ACCESSING OR OTHERWISE USING THE PRODUCT, YOU AGREE TO BE BOUND BY THE TERMS OF THIS AGREEMENT. IF YOU DO NOT AGREE TO THE TERMS OF THIS AGREEMENT, DO NOT INSTALL OR USE THE PRODUCT; YOU MAY, HOWEVER, RETURN IT TO YOUR PLACE OF PURCHASE.


SOFTWARE LICENSE
The PRODUCT is protected by copyright laws and international copyright treaties, as well as other intellectual property laws and treaties.

1.	GRANT OF LICENSE

This Agreement grants you the following rights:

License.
You, the original purchaser is herby granted a non-transferable, non-exclusive personal license to use the software.

Installation.
You may install and use one copy of the PRODUCT on a single computer, including a workstation, terminal, or other digital electronic device ("COMPUTER").

Restrictions.
All rights not expressly granted herein are reserved by MyFulcrum.com


2.	DESCRIPTION OF OTHER RIGHTS AND LIMITATIONS
    A.	Limitations on Reverse Engineering, Decompilation and Disassembly.
You may not reverse engineer, decompile, or disassemble the PRODUCT, except and only
to the extent that such activity is expressly permitted by applicable law notwithstanding
this limitation.

    B.	Limitations on Use.
You may not modify, copy, adapt, translate, loan, resell for profit, distribute, network, rent, lease or create derivative works based upon the PRODUCT or any copy, except as expressly provided in Section 1 above.

    C.	Trademarks.
This Agreement does not grant you any rights in connection with any trademarks or service marks of MyFulcrum.com or the third party software products provided to you as part of
this agreement.

    D.	Ownership:
You have no ownership rights in the PRODUCT; you have a license to use the PRODUCT as long as this license agreement remains in full force and effect.  Ownership of the PRODUCT, and all intellectual property rights therein shall remain at all times with MyFulcrum.com, or the third party suppliers.   Any other use of the PRODUCT by any person, business, corporation, government organization or any other entity is strictly forbidden and is a violation of this License Agreement.


    E.	Termination.
Your failure to comply with the terms of this Agreement shall terminate your license and any rights thereof.


3.	COPYRIGHT
All title and intellectual property rights in and to the PRODUCT (including but not limited to any images, photographs, animations, video, audio, music, text, and "applets" incorporated into the PRODUCT), the accompanying printed materials, and any copies of the PRODUCT are owned by MyFulcrum.com or its suppliers. All title and intellectual property rights in and to the content which may be accessed through use of the PRODUCT is the property of the respective content owner and may be protected by applicable copyright or other intellectual property laws and treaties. All rights not expressly granted are reserved by MyFulcrum.com



4.	WARRANTY

COMPANY MAKES NO REPRESENTATION OR WARRANTY OF ANY KIND, EXPRESS, IMPLIED OR STATUTORY, INCLUDING BUT NOT LIMITED TO WARRANTIES OF MERCHANTABILITY, UNINTERRUPTED USE, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT.



5.	LIMITATION OF LIABILITY
IN NO EVENT WILL MYFULCRUM.COM BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY INCIDENTAL OR CONSEQUENTIAL DAMAGES (INCLUDING, WITHOUT LIMITATION, INDIRECT, SPECIAL, OR PUNITIVE, OR EXEMPLARY DAMAGES FOR LOSS OF BUSINESS, LOSS OF PROFITS, BUSINESS INTERRUPTION, OR LOSS OF BUSINESS INFORMATION) ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM, OR FOR ANY CLAIM BY ANY OTHER PARTY, EVEN IF MYFULCRUM.COM HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.  MYFULCRUM.COM'S AGGREGATE LIABILITY WITH RESPECT TO ITS OBLIGATIONS UNDER THIS AGREEMENT OR OTHERWISE WITH RESPECT TO THE PRODUCT AND DOCUMENTATION OR OTHERWISE SHALL NOT EXCEED THE AMOUNT OF THE LICENSE FEE PAID BY YOU FOR THE PRODUCT AND DOCUMENTATION.  BECAUSE SOME STATES/COUNTRIES DO NOT ALLOW THE EXCLUSIN OR LIMITATION OF LIABILIYT FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, THE ABOVE LIMITATION MAY NOT APPLY TO YOU.



6. 	EXPORT RESTRICTIONS
THE LICENSE AGREEMENT IS EXPRESSLY MADE SUBJECT TO ANY LAWS, REGULATIONS, ORDER OR OTHER RESTRICTIONS ON THE EXPORT FROM THE UNITED STATES OF AMERICA OF THE PRODUCT OR INFORMATION ABOUT SUCH PRODUCT WHICH MAY BE IMPOSED FROM TIME TO TIME BY THE GOVERNMENT OF THE UNITED STATES OF AMERICA.  YOU SHALL NOT EXPORT THE PRODUCT, DOCUMENTATION, OR INFORMATION ABOUT THE PRODUCT AND DOCUMENTATION OR INFORMATION ABOUT THE PRODUCT AND DOCUMENTATION WITHOUT CONSENT OF MYFULCRUM.COM AND COMPLIANCE WITH SUCH LAWS, REGULATIONS, ORDERS, OR OTHER RESTRICTIONS.



7.	GENERAL

    A.	This Agreement shall constitute the entire agreement between the parties with respect to the subject matter hereof and merges all prior and contemporaneous communications. It shall
not be modified except by a written agreement signed by the Licensee and Company.

    B.	If any provision of this Agreement shall be held by a court of competent jurisdiction to be illegal, invalid or unenforceable, that provisions shall be limited or eliminated to the minimum extent necessary so that this Agreement shall otherwise remain in full force and effect
and enforceable.
    C.	No waiver of any breach of any provision of this Agreement shall constitute a waiver of any prior, concurrent or subsequent breach of the same or any other provisions hereof, and no waiver shall be effective unless made in writing and signed by an authorized representative of the waiving party.

    D.	Controlling Law.  THIS AGREEMENT SHALL BE GOVERNED BY AND CONSTRUED UNDER THE LAWS OF THE STATE OF CALIFORNIA AND WITHOUT REGARD TO THE UNITED NATIONS CONVENTION ON CONTRACTS FOR THE INTERNATIONAL SALE OF GOODS.  The parties agree the sole jurisdiction and venue shall be Orange County
Superior Court.


8. 	END USER WARRANTIES AND REPRESENTATIONS:
    A)  	AS A CONDITION TO PROVIDING THIS SERVICE YOU MUST REPRESENT AND WARRANT THAT:
      a.	The Information You submits have been originally created and produced by You;
      b.	No other person, firm, corporation, or entity has any rights or interest in the Information You submits;
      c.	The Information will not violate any copyright, trademark, or any other registered or common-law proprietary or intellectual property right of any person, firm, corporation,
or entity;
      d.	 All factual statements in the Information will be true and the Information will not contain any defamatory or unlawful statements, or statements that violate the privacy or similar right of any person, firm, corporation, or entity;
      e.	The Information will not contain information or instructions that could reasonably cause foreseeable injury to person or property; and

    B) 	    INDEMNIFICATION

You will indemnify and hold harmless MyFulcrum.com from any claims, damage, or expense (including, but not limited to, reasonable attorney fees and court costs) arising out of a breach of your representations or warranties.


If you have any questions about MyFulcrum.coms legal agreement, please feel free to contact us at: Legal at MyFulcrum.com.
</textarea></td>
	</tr>
	<tr>
	<td width="100%">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td width="68%" align="right"><a href="javscript:openPrintVersion();"><img border="0" src="images/printer.gif" width="23" height="20"></a>&nbsp;</td>
		<td width="32%" align="left"><a href="javscript:openPrintVersion();">Printer-Friendly Version</a></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td width="100%" height="20" valign="top" align="center"><span class="OLblEm" id="lblButtonInfo0"><i><font size="1" color="#808080">By clicking on the Accept button below, you are accepting the End-User License Agreement.</font></i></span></td>
	</tr>
	<tr>
	<td width="100%" height="27" align="center"><input name="btnDecline" title="Decline" value="I  Decline " type="button" onclick="window.location='xt_terms_and_conditions.php?decline=true$uri->queryString" style="width: 125px;">&nbsp;&nbsp;&nbsp;&nbsp;<input id="first_element" name="btnAccept" title="Accept" type="button" onclick="window.location='xt_terms_and_conditions.php?accept=true$uri->queryString" value="I  Accept " style="width: 125px;"></td>
	</tr>
	</table>
</td>
</tr>
</table>
END_HTML_CONTENT;

$template->assign('htmlContent', $htmlContent);
$template->display('master-web-unauthenticated-html5.tpl');
exit;

?>



<?php
/**
 * terms and conditions.
 *
 *
 *
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');


$htmlTitle = 'Terms and Conditions';
$htmlBody = "onload='setFocus();'";
require_once('page-components/axis/header.php');

// retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
?>
<script>
function openPrintVersion() {
xCoord = (800 - screen.width) / 2;
yCoord = (500 - screen.height) / 2;

printWindow = window.open('terms-and-conditions-print.php', 'print', 'width=600, height=500, toolbar=no, menubar=no, status=no, scrollbars=yes, resizable=yes, left='+xCoord+', top='+yCoord);

}

</script>
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td width="100%" height="18">
	<table border="0" cellspacing="0" width="100%">
	<tr>
	<td colspan="2" height="22">
	<h2 align="center"><span class="title"><i><font color="#000080">MyFulcrum.com
	End-User License Agreement</font></i></span></h2>
	</td>
	</tr>
	</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<?php
	echo '<tr><td nowrap><div style="margin-left:150px;">'.$htmlMessages.'</div></td></tr>';
	?>
	<tr>
	<td width="100%" height="150">
	<p align="center"><textarea class="OTOUCBx" id="taTOUContent" title="End-User License Agreement" style="width: 663px; height: 200px;" name="taTOUContent" rows="6" readOnly cols="40">
END-USER LICENSE AGREEMENT FOR MYFULCRUM.COM SOFTWARE

IMPORTANT - READ CAREFULLY: This End-User License Agreement ("Agreement") is a legal agreement between you (either an individual or a single entity) and MyFulcrum.com for the MyFulcrum.com software product, which includes computer executable code and may include associated media, printed materials, and "online" or electronic documentation ("PRODUCT"). The PRODUCT also may include any updates and supplements to the original PRODUCT and or third party software product provided to you by MyFulcrum.com. Any software provided along with the PRODUCT that is associated with a separate end-user license agreement is licensed to you under the terms of that license agreement. BY INSTALLING, COPYING, DOWNLOADING, ACCESSING OR OTHERWISE USING THE PRODUCT, YOU AGREE TO BE BOUND BY THE TERMS OF THIS AGREEMENT. IF YOU DO NOT AGREE TO THE TERMS OF THIS AGREEMENT, DO NOT INSTALL OR USE THE PRODUCT; YOU MAY, HOWEVER, RETURN IT TO YOUR PLACE OF PURCHASE.


SOFTWARE LICENSE
The PRODUCT is protected by copyright laws and international copyright treaties, as well as other intellectual property laws and treaties.

1.	GRANT OF LICENSE

This Agreement grants you the following rights:

License.
You, the original purchaser is herby granted a non-transferable, non-exclusive personal license to use the software.

Installation.
You may install and use one copy of the PRODUCT on a single computer, including a workstation, terminal, or other digital electronic device ("COMPUTER").

Restrictions.
All rights not expressly granted herein are reserved by MyFulcrum.com


2.	DESCRIPTION OF OTHER RIGHTS AND LIMITATIONS
    A.	Limitations on Reverse Engineering, Decompilation and Disassembly.
You may not reverse engineer, decompile, or disassemble the PRODUCT, except and only
to the extent that such activity is expressly permitted by applicable law notwithstanding
this limitation.

    B.	Limitations on Use.
You may not modify, copy, adapt, translate, loan, resell for profit, distribute, network, rent, lease or create derivative works based upon the PRODUCT or any copy, except as expressly provided in Section 1 above.

    C.	Trademarks.
This Agreement does not grant you any rights in connection with any trademarks or service marks of MyFulcrum.com or the third party software products provided to you as part of
this agreement.

    D.	Ownership:
You have no ownership rights in the PRODUCT; you have a license to use the PRODUCT as long as this license agreement remains in full force and effect.  Ownership of the PRODUCT, and all intellectual property rights therein shall remain at all times with MyFulcrum.com, or the third party suppliers.   Any other use of the PRODUCT by any person, business, corporation, government organization or any other entity is strictly forbidden and is a violation of this License Agreement.


    E.	Termination.
Your failure to comply with the terms of this Agreement shall terminate your license and any rights thereof.


3.	COPYRIGHT
All title and intellectual property rights in and to the PRODUCT (including but not limited to any images, photographs, animations, video, audio, music, text, and "applets" incorporated into the PRODUCT), the accompanying printed materials, and any copies of the PRODUCT are owned by MyFulcrum.com or its suppliers. All title and intellectual property rights in and to the content which may be accessed through use of the PRODUCT is the property of the respective content owner and may be protected by applicable copyright or other intellectual property laws and treaties. All rights not expressly granted are reserved by MyFulcrum.com



4.	WARRANTY

COMPANY MAKES NO REPRESENTATION OR WARRANTY OF ANY KIND, EXPRESS, IMPLIED OR STATUTORY, INCLUDING BUT NOT LIMITED TO WARRANTIES OF MERCHANTABILITY, UNINTERRUPTED USE, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT.



5.	LIMITATION OF LIABILITY
IN NO EVENT WILL MYFULCRUM.COM BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY INCIDENTAL OR CONSEQUENTIAL DAMAGES (INCLUDING, WITHOUT LIMITATION, INDIRECT, SPECIAL, OR PUNITIVE, OR EXEMPLARY DAMAGES FOR LOSS OF BUSINESS, LOSS OF PROFITS, BUSINESS INTERRUPTION, OR LOSS OF BUSINESS INFORMATION) ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM, OR FOR ANY CLAIM BY ANY OTHER PARTY, EVEN IF MYFULCRUM.COM HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.  MYFULCRUM.COM'S AGGREGATE LIABILITY WITH RESPECT TO ITS OBLIGATIONS UNDER THIS AGREEMENT OR OTHERWISE WITH RESPECT TO THE PRODUCT AND DOCUMENTATION OR OTHERWISE SHALL NOT EXCEED THE AMOUNT OF THE LICENSE FEE PAID BY YOU FOR THE PRODUCT AND DOCUMENTATION.  BECAUSE SOME STATES/COUNTRIES DO NOT ALLOW THE EXCLUSIN OR LIMITATION OF LIABILIYT FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, THE ABOVE LIMITATION MAY NOT APPLY TO YOU.



6. 	EXPORT RESTRICTIONS
THE LICENSE AGREEMENT IS EXPRESSLY MADE SUBJECT TO ANY LAWS, REGULATIONS, ORDER OR OTHER RESTRICTIONS ON THE EXPORT FROM THE UNITED STATES OF AMERICA OF THE PRODUCT OR INFORMATION ABOUT SUCH PRODUCT WHICH MAY BE IMPOSED FROM TIME TO TIME BY THE GOVERNMENT OF THE UNITED STATES OF AMERICA.  YOU SHALL NOT EXPORT THE PRODUCT, DOCUMENTATION, OR INFORMATION ABOUT THE PRODUCT AND DOCUMENTATION OR INFORMATION ABOUT THE PRODUCT AND DOCUMENTATION WITHOUT CONSENT OF MYFULCRUM.COM AND COMPLIANCE WITH SUCH LAWS, REGULATIONS, ORDERS, OR OTHER RESTRICTIONS.



7.	GENERAL

    A.	This Agreement shall constitute the entire agreement between the parties with respect to the subject matter hereof and merges all prior and contemporaneous communications. It shall
not be modified except by a written agreement signed by the Licensee and Company.

    B.	If any provision of this Agreement shall be held by a court of competent jurisdiction to be illegal, invalid or unenforceable, that provisions shall be limited or eliminated to the minimum extent necessary so that this Agreement shall otherwise remain in full force and effect
and enforceable.
    C.	No waiver of any breach of any provision of this Agreement shall constitute a waiver of any prior, concurrent or subsequent breach of the same or any other provisions hereof, and no waiver shall be effective unless made in writing and signed by an authorized representative of the waiving party.

    D.	Controlling Law.  THIS AGREEMENT SHALL BE GOVERNED BY AND CONSTRUED UNDER THE LAWS OF THE STATE OF CALIFORNIA AND WITHOUT REGARD TO THE UNITED NATIONS CONVENTION ON CONTRACTS FOR THE INTERNATIONAL SALE OF GOODS.  The parties agree the sole jurisdiction and venue shall be Orange County
Superior Court.


8. 	END USER WARRANTIES AND REPRESENTATIONS:
    A)  	AS A CONDITION TO PROVIDING THIS SERVICE YOU MUST REPRESENT AND WARRANT THAT:
      a.	The Information You submits have been originally created and produced by You;
      b.	No other person, firm, corporation, or entity has any rights or interest in the Information You submits;
      c.	The Information will not violate any copyright, trademark, or any other registered or common-law proprietary or intellectual property right of any person, firm, corporation,
or entity;
      d.	 All factual statements in the Information will be true and the Information will not contain any defamatory or unlawful statements, or statements that violate the privacy or similar right of any person, firm, corporation, or entity;
      e.	The Information will not contain information or instructions that could reasonably cause foreseeable injury to person or property; and

    B) 	    INDEMNIFICATION

You will indemnify and hold harmless MyFulcrum.com from any claims, damage, or expense (including, but not limited to, reasonable attorney fees and court costs) arising out of a breach of your representations or warranties.


If you have any questions about MyFulcrum.coms legal agreement, please feel free to contact us at: Legal at MyFulcrum.com.
</textarea></td>
	</tr>
	<tr>
	<td width="100%">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td width="68%" align="right"><a href="javscript:openPrintVersion();"><img border="0" src="images/printer.gif" width="23" height="20"></a>&nbsp;</td>
		<td width="32%" align="left"><a href="javscript:openPrintVersion();">Printer-Friendly Version</a></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td width="100%" height="20" valign="top" align="center"><span class="OLblEm" id="lblButtonInfo0"><i><font size="1" color="#808080">By clicking on the Accept button below, you are accepting the End-User License Agreement.</font></i></span></td>
	</tr>
	<tr>
	<td width="100%" height="27" align="center"><input name="btnDecline" title="Decline" value="I  Decline " type="button" onclick="window.location='xt_terms_and_conditions.php?decline=true<?php echo $uri->queryString; ?>';" style="width: 125px;">&nbsp;&nbsp;&nbsp;&nbsp;<input id="first_element" name="btnAccept" title="Accept" type="button" onclick="window.location='xt_terms_and_conditions.php?accept=true<?php echo $uri->queryString; ?>';" value="I  Accept " style="width: 125px;"></td>
	</tr>
	</table>
</td>
</tr>
</table>
<?php
require_once('page-components/axis/footer.php');
?>