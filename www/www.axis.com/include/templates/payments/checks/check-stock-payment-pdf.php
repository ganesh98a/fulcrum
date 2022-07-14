<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

<!-- Remove the protocol prefix (i.e., "http:") if hosting on a server instead of from localhost. -->
<style>
	body
	{
		background-image: url('http://localdev.myfulcrum.com/images/unit-testing/payments/checks/example-advent-blank-check-stock.jpg');
		background-size: 764pt;
		background-repeat: no-repeat;
		width: 764pt;
		height: 980pt;
		font-family: Courier;
	}
	div
	{
		position: absolute;
		/* for debug: border: 1px solid #000;*/
	}
	span.checkLabel
	{
		font-weight: bold;
	}
	div#check-1-date-box
	{
		left: 582pt;
		top: 70pt;

	}



	div#check-1-amount-nbr-box
	{
		left: 618pt;
		top: 114pt;
	}

	div#check-1-amount-txt-box
	{
		left: 32pt;
		top: 148pt;
	}
	div#check-1-pay-to-box
	{
		left: 96pt;
		top: 115pt;
	}
	div#check-1-pay-to-address-box
	{
		left: 35pt; /*90px;*/
		top: 180pt; /*238px;*/

	}

	div#check-1-memo-box
	{
		left: 75pt; /*90px;*/
		top: 238pt; /*238px;*/
	}

	div#check-1-row1_CompanyName
	{
		left: 50px;
		top: 520px;
	}

	div#check-1-row1_Date
	{
		left: 450px;
		top: 520px;
	}

	div#check-1-row1_CheckNumber
	{
		left: 680px;
		top: 520px;
	}

	div#check-1-row1_InvoiceDate
	{
		left: 50px;
		top: 580px;
	}

	div#check-1-row1_JobNumber
	{
		left: 200px;
		top: 580px;
		text-align: left;
	}

	div#check-1-row1_InvoiceNumber
	{
		left: 350px;
		top: 580px;
		text-align: right;
	}

	div#check-1-row1_BalancePaid
	{
		left: 500px;
		top: 580px;
		width: 150px;
		text-align: right;
	}

	div#check-1-row1_Discount
	{
		left: 650px;
		top: 580px;
		width: 150px;
		text-align: right;
	}

	div#check-1-row1_NetPaid
	{
		left: 800px;
		top: 580px;
		width: 150px;
		text-align: right;
	}



	div#check-1-row1_Total
	{
		left: 350px;
		top: 780px;
	}

	div#check-1-row1_BalancePaidSummary
	{
		left: 500px;
		top: 780px;
		width: 150px;
		border-top: 1px solid #000;
		text-align: right;
	}

	div#check-1-row1_DiscountSummary
	{
		left: 650px;
		top: 780px;
		width: 150px;
		border-top: 1px solid #000;
		text-align: right;
	}

	div#check-1-row1_NetPaidSummary
	{
		left: 800px;
		top: 780px;
		width: 150px;
		border-top: 1px solid #000;
		text-align: right;
	}
</style>
</head>
<body>
	<div id="check-1-date-box">
	<pre></pre>
	</div>
	<div id="check-1-pay-to-box">

	</div>
	<div id="check-1-amount-nbr-box">

	</div>
	<div id="check-1-amount-txt-box">

	</div>
	<div id="check-1-pay-to-address-box">
	<pre>

	</pre>
	</div>
	<div id="check-1-memo-box">

	</div>

	<div id="check-1-row1_CompanyName">

	</div>
	<div id="check-1-row1_Date">

	</div>

	<div id="check-1-row1_CheckNumber">

	</div>

	<div id="check-1-row1_InvoiceDate">

	</div>
	<div id="check-1-row1_JobNumber">

	</div>
	<div id="check-1-row1_InvoiceNumber">

	</div>
	<div id="check-1-row1_BalancePaid">

	</div>
	<div id="check-1-row1_Discount">

	</div>
	<div id="check-1-row1_NetPaid">

	</div>

	<div id="check-1-row1_Total">

	</div>
	<div id="check-1-row1_BalancePaidSummary">

	</div>
	<div id="check-1-row1_DiscountSummary">

	</div>
	<div id="check-1-row1_NetPaidSummary">

	</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
	// Check #1.
	/*
	var checkData1 = {
		"date"		  : "<?php echo $checkDate;?>", // The date when the check is first eligible to be cashed/deposited. e.g. 05/01/2013
		"payTo"		 : "<?php echo $checkPayTo;?>", // To whom the check should be made out. e.g. Michael Harry Scepaniak
		"amountNbr"	 : "<?php echo $checkAmountNbr;?>", // The amount of the check, as a number. e.g. 13,100.00
		"amountTxt"	 : "<?php echo $checkAmountTxt;?>", // The amount of the check, written out long-form. e.g. Thirteen thousand one hundred and 00/100
		"payToAddress"  : [ // Lines 1 through 5 of the recipient's address.
			"<?php echo $checkPayToAddress1;?>",
			"<?php echo $checkPayToAddress2;?>", // e.g. 1313 Mockingird Lane
			"<?php echo $checkPayToAddress3;?>", // e.g. Cockeysville, MD 22178
			"",
			"",
			""],
		"memo"		  : "<?php echo $checkMemo;?>", // A short note to include on the check. e.g. Just a small thank you.
		"row1_CompanyName"		 : "<?php echo $row1_CompanyName;?>",
		"row1_Date"	 : "<?php echo $row1_Date;?>", //
		"row1_CheckNumber"	 : "<?php echo $row1_CheckNumber;?>",
		"row1_InvoiceDate"		 : "<?php echo $row1_InvoiceDate;?>",
		"row1_JobNumber"	 : "<?php echo $row1_JobNumber;?>", //
		"row1_InvoiceNumber"	 : "<?php echo $row1_InvoiceNumber;?>",
		"row1_BalancePaid"		 : "<?php echo $row1_BalancePaid;?>",
		"row1_Discount"	 : "<?php echo $row1_Discount;?>", //
		"row1_NetPaid"	 : "<?php echo $row1_NetPaid;?>",
		"row1_Total"	 : "<?php echo $row1_Total;?>",
		"row1_BalancePaidSummary"		 : "<?php echo $row1_BalancePaidSummary;?>",
		"row1_DiscountSummary"	 : "<?php echo $row1_DiscountSummary;?>", //
		"row1_NetPaidSummary"	 : "<?php echo $row1_NetPaidSummary;?>"
	};
*/
	var checkData1 = {
		"date"		  : "<?php echo $checkTemplateData['checkDate']; ?>", // The date when the check is first eligible to be cashed/deposited. e.g. 05/01/2013
		"payTo"		 : "<?php echo $checkTemplateData['checkPayTo']; ?>", // To whom the check should be made out. e.g. Michael Harry Scepaniak
		"amountNbr"	 : "<?php echo $checkTemplateData['checkAmountNbr']; ?>", // The amount of the check, as a number. e.g. 13,100.00
		"amountTxt"	 : "<?php echo $checkTemplateData['checkAmountTxt']; ?>", // The amount of the check, written out long-form. e.g. Thirteen thousand one hundred and 00/100
		"payToAddress"  : [ // Lines 1 through 5 of the recipient's address.
			"<?php echo $checkTemplateData['checkPayTo']; ?>",
			"<?php echo $checkTemplateData['checkPayToAddress1']; ?>", // e.g. 1313 Mockingird Lane
			"<?php echo $checkTemplateData['checkPayToAddress2']; ?>", // e.g. Cockeysville, MD 22178
			"",
			"",
			""],
		"memo"		  : "<?php echo $checkTemplateData['checkMemo']; ?>", // A short note to include on the check. e.g. Just a small thank you.
		"row1_CompanyName"		 : "<?php echo $checkTemplateData['row1_CompanyName']; ?>",
		"row1_Date"	 : "<?php echo $checkTemplateData['row1_Date']; ?>", //
		"row1_CheckNumber"	 : "<?php echo $checkTemplateData['row1_CheckNumber']; ?>",
		"row1_InvoiceDate"		 : "<?php echo $checkTemplateData['row1_InvoiceDate']; ?>",
		"row1_JobNumber"	 : "<?php echo $checkTemplateData['row1_JobNumber']; ?>", //
		"row1_InvoiceNumber"	 : "<?php echo $checkTemplateData['row1_InvoiceNumber']; ?>",
		"row1_BalancePaid"		 : "<?php echo $checkTemplateData['row1_BalancePaid']; ?>",
		"row1_Discount"	 : "<?php echo $checkTemplateData['row1_Discount']; ?>", //
		"row1_NetPaid"	 : "<?php echo $checkTemplateData['row1_NetPaid']; ?>",
		"row1_Total"	 : "<?php echo $checkTemplateData['row1_Total']; ?>",
		"row1_BalancePaidSummary"		 : "<?php echo $checkTemplateData['row1_BalancePaidSummary']; ?>",
		"row1_DiscountSummary"	 : "<?php echo $checkTemplateData['row1_DiscountSummary']; ?>", //
		"row1_NetPaidSummary"	 : "<?php echo $checkTemplateData['row1_NetPaidSummary']; ?>"
	};
	// Check #2. If you only need to print one check, leave the values for this check blank.
	var checkData2 = {
		"date"		  : "",
		"payTo"		 : "",
		"amountNbr"	 : "",
		"amountTxt"	 : "",
		"payToAddress"  : [
			"",
			"",
			"",
			"",
			""],
		"memo"		  : ""
		};

	// Check #3. If you only need to print two checks, leave the values for this third check blank.
	var checkData3 = {
		"date"		  : "",
		"payTo"		 : "",
		"amountNbr"	 : "",
		"amountTxt"	 : "",
		"payToAddress"  : [
			"",
			"",
			"",
			"",
			""],
		"memo"		  : ""
		};

	/*
	 * ============================================
	 * NO NEED TO MODIFY ANYTHING BELOW THIS POINT.
	 * ============================================
	 */

	jQuery(document).ready(function() {
		populateCheck(1, checkData1);
	})

	var populateCheck = function(checkNbr, checkData)
	{
		jQuery("div#check-" + checkNbr + "-date-box").html(checkData.date);
		jQuery("div#check-" + checkNbr + "-pay-to-box").html(checkData.payTo);
		jQuery("div#check-" + checkNbr + "-amount-nbr-box").html(checkData.amountNbr);
		jQuery("div#check-" + checkNbr + "-amount-txt-box").html(checkData.amountTxt);
		jQuery("div#check-" + checkNbr + "-pay-to-address-box pre").html(buildAddressBlock(checkData.payToAddress));
		jQuery("div#check-" + checkNbr + "-memo-box").html(checkData.memo);
		jQuery("div#check-" + checkNbr + "-row1_CompanyName").html(checkData.row1_CompanyName);
		jQuery("div#check-" + checkNbr + "-row1_Date").html(checkData.row1_Date);
		jQuery("div#check-" + checkNbr + "-row1_CheckNumber").html(checkData.row1_CheckNumber);
		jQuery("div#check-" + checkNbr + "-row1_InvoiceDate").html(checkData.row1_InvoiceDate);
		jQuery("div#check-" + checkNbr + "-row1_JobNumber").html(checkData.row1_JobNumber);
		jQuery("div#check-" + checkNbr + "-row1_InvoiceNumber").html(checkData.row1_InvoiceNumber);
		jQuery("div#check-" + checkNbr + "-row1_BalancePaid").html(checkData.row1_BalancePaid);
		jQuery("div#check-" + checkNbr + "-row1_Discount").html(checkData.row1_Discount);
		jQuery("div#check-" + checkNbr + "-row1_NetPaid").html(checkData.row1_NetPaid);
		jQuery("div#check-" + checkNbr + "-row1_Total").html(checkData.row1_Total);
		jQuery("div#check-" + checkNbr + "-row1_BalancePaidSummary").html(checkData.row1_BalancePaidSummary);
		jQuery("div#check-" + checkNbr + "-row1_DiscountSummary").html(checkData.row1_DiscountSummary);
		jQuery("div#check-" + checkNbr + "-row1_NetPaidSummary").html(checkData.row1_NetPaidSummary);
	}

	var buildAddressBlock = function(addressLines)
	{
		var addressBlock = "";
		for (var i = 0; i < addressLines.length; i++)
		{
			var addressLine = addressLines[i];
			if (addressLine !== undefined && addressLine !== null && addressLine.length > 0)
			{
				if (addressBlock.length > 0)
				{
					addressBlock += "<br/>";
				}
				addressBlock += "		 " + addressLine;
			}
		}
		return addressBlock;
	}
</script>
</body>
</html>
