<?php
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
 * This page has three states:
 * 1) Create a new Contact Company
 * 2) Update an existing Contact Company
 * 3) Display a Contact Company in Read-Only mode (not updateable in this mode/view)
 */

// Start with: $contactCompany
/* @var $contactCompany ContactCompany */

// Default data points
$contact_company_id = '';
$user_user_company_id = $AXIS_NON_EXISTENT_USER_COMPANY_ID;
$contact_user_company_id = $AXIS_NON_EXISTENT_USER_COMPANY_ID;
$company = '';
$employer_identification_number = '';
$construction_license_number = '';
$construction_license_number_expiration_date = '';
$vendor_flag = '';
$companyNameStripped = '';
$btnSaveText = 'Save Company';

if (!isset($arrContactCompanies) || empty($arrContactCompanies)) {
	$arrContactCompanies = array();
}

foreach ($arrContactCompanies as $contact_company_id => $contactCompany) {
	/* @var $contactCompany ContactCompany */

	if (!$contactCompany instanceof ContactCompany) {
		continue;
	}

	// This value may already be set
	$contact_company_id = (int) $contactCompany->contact_company_id;
	$user_user_company_id = (int) $contactCompany->user_user_company_id;
	$contact_user_company_id = (int) $contactCompany->contact_user_company_id;
	$company = (string) $contactCompany->company;
	$employer_identification_number = (string) $contactCompany->employer_identification_number;
	$construction_license_number = (string) $contactCompany->construction_license_number;
	$construction_license_number_expiration_date = (string) $contactCompany->construction_license_number_expiration_date;
	$vendor_flag = (string) $contactCompany->vendor_flag;
	$primary_phone_number = (string) $contactCompany->primary_phone_number;

	if ($user_company_id == $contact_user_company_id) {
		$myCompanyDataCase = true;
	} else {
		$myCompanyDataCase = false;
	}

	if ($user_user_company_id == $contact_user_company_id) {
		$companyName = $contactCompany->contact_company_name . ' (My Company)';
	} else {
		$companyName = $contactCompany->contact_company_name;
	}

	$construction_license_number_expiration_date = $contactCompany->construction_license_number_expiration_date;
	if ( isset($construction_license_number_expiration_date) && !empty($construction_license_number_expiration_date) && ($construction_license_number_expiration_date != '0000-00-00') ) {
		$construction_license_number_expiration_date = date('m/d/Y',strtotime($construction_license_number_expiration_date));
	} else {
		$construction_license_number_expiration_date = '';
	}

	$btnSaveText = 'Update Company Information';
	$companyNameStripped = str_replace(' (My Company)', '', $companyName);

	/*
	echo '
		<fieldset>
	';
	*/


	// manage-contact_company-record--contact_companies--user_user_company_id--1

	// Update mode
	?>
	<form id="frmCompanyInfo" name="frmCompanyInfo">
		<input id="formattedAttributeGroupName--manage-contact_company-record--<?=$contact_company_id;?>" type="hidden" value="<?php echo$companyNameStripped;?>">
		<input id="formattedAttributeSubgroupName--manage-contact_company-record--contact_companies--<?=$contact_company_id;?>" type="hidden" value="Contact Company Data">
		<table border="0" width="100%" cellpadding="2px;" cellspacing="5px;">

			<tr valign="top">
				<td class="padding10">
					<div class="contactSectionHeader"><?php echo$companyNameStripped;?> Info</div>

					<table class=" width100-per" width="100%">
						<tr style="height: 50px;">
							<td class="textAlignLeft">Company Name:<span class="contactMan">*</span></td>
							<?php
							if ($myCompanyDataCase && $userCanManageMyContactCompanyData) {
		// Since this updates the contact_company record and the user_company record we don't want them to update with ajax one at a time.
								?>
								<td><input name="companyName" id="manage-contact_company-record--contact_companies--company--<?=$contact_company_id;?>" class="wideInput" value="<?php echo$companyNameStripped;?>"></td>
								<?php
							} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyData) {
								?>
								<td><input name="companyName" id="manage-contact_company-record--contact_companies--company--<?=$contact_company_id;?>" class="wideInput" value="<?php echo$companyNameStripped;?>" onchange="updateCompanyField('<?=$contact_company_id;?>', 'companyName','manage-contact_company-record--contact_companies--company');"></td>
								<?php
							} else {
								echo '<td>'.$companyNameStripped.'</td>';
							}
							?>
						</td>
					
				<td class="textAlignLeft">Contractor License:</td>

				<?php
				if (($myCompanyDataCase && $userCanManageMyContactCompanyData) || $contact_company_id == 0) {
					?>
					<td><input id="manage-contact_company-record--contact_companies--construction_license_number--<?=$contact_company_id;?>" maxlength="9" class="wideInput" value="<?php echo$construction_license_number;?>"></td>
					<?php
				} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyData) {
					?>
					<td><input id="manage-contact_company-record--contact_companies--construction_license_number--<?=$contact_company_id;?>" maxlength="9" class="wideInput" value="<?php echo$construction_license_number;?>" onchange="updateCompanyField('<?=$contact_company_id;?>', 'license','manage-contact_company-record--contact_companies--construction_license_number');"></td>
					<?php
				} else {
					echo '<td>'.$construction_license_number.'</td>';
				}
				?>

			</td>
		
					<td class="textAlignLeft">Federal Tax ID:</td>
					<?php
					if ($myCompanyDataCase && $userCanManageMyContactCompanyEmployerIdentificationNumber) {
						?>
						<td><input id="manage-contact_company-record--contact_companies--employer_identification_number--<?=$contact_company_id;?>" class="wideInput" value="<?php echo$employer_identification_number;?>"></td>
						<?php
					} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyEmployerIdentificationNumbers) {
						?>
						<td><input id="manage-contact_company-record--contact_companies--employer_identification_number--<?=$contact_company_id;?>" class="wideInput" value="<?php echo$employer_identification_number;?>" onchange="updateCompanyField('<?=$contact_company_id;?>', 'taxID','manage-contact_company-record--contact_companies--employer_identification_number');"></td>
						<?php
					} elseif ($myCompanyDataCase && $userCanViewMyContactCompanyEmployerIdentificationNumber) {
						echo '<td>'.$employer_identification_number.'</td>';
					} elseif (!$myCompanyDataCase && $userCanViewThirdPartyContactCompanyEmployerIdentificationNumbers) {
						echo '<td>'.$employer_identification_number.'</td>';
					} else {
						$obfuscatedFederalTaxId = preg_replace('/[0-9]{1}/', 'x', $employer_identification_number, -1);
						echo '<td>'.$obfuscatedFederalTaxId.'</td>';
					}
					?>
				</td>
			</tr>


					<tr>
						<td class="textAlignLeft">Primary Phone Number:</td>
						<?php
						if ($myCompanyDataCase && $userCanManageMyContactCompanyData) {
							?>
							<td><input id="manage-contact_company-record--contact_companies--primary_phone_number--<?=$contact_company_id;?>" class="phoneNumber wideInput" value="<?php echo$primary_phone_number;?>"></td>
							<?php
						} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyData) {
							?>
							<td><input name="companyName" id="manage-contact_company-record--contact_companies--primary_phone_number--<?=$contact_company_id;?>" class="wideInput phoneExtension" value="<?php echo$primary_phone_number;?>" onchange="updateContactCompany(this);"></td>
							<?php
						} else {
							echo '<td>'.$primary_phone_number.'</td>';
						}
						?>
					</td>
				
			<td class="textAlignLeft">License Expiration:</td>

			<?php
			if (($myCompanyDataCase && $userCanManageMyContactCompanyData) || $contact_company_id == 0) {
				?>
				<td><input id="manage-contact_company-record--contact_companies--construction_license_number_expiration_date--<?=$contact_company_id;?>" class="wideInput datepicker auto-hint" value="<?php echo$construction_license_number_expiration_date;?>" title="MM/DD/YYYY"></td>
				<?php
			} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyData) {
				?>
				<td><input id="manage-contact_company-record--contact_companies--construction_license_number_expiration_date--<?=$contact_company_id;?>" class="wideInput datepicker auto-hint" value="<?php echo$construction_license_number_expiration_date;?>" onchange="updateCompanyField('<?=$contact_company_id;?>', 'licenseDate','manage-contact_company-record--contact_companies--construction_license_number_expiration_date');" title="MM/DD/YYYY"></td>
				<?php
			} else {
				echo '<td>'.$construction_license_number_expiration_date.'</td>';
			}
			?>

		</td>

	<?php
	// @todo Figure this out...
	// if ( ($contact_company_id == 0 || $myCompanyDataCase) && $userCanManageContactsManager) {
	if ($mode == 'update') {
		if (($myCompanyDataCase && $userCanManageMyContactCompanyData) || (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyData)) {
			?>
				<td colspan="2" class="textAlignLeft">
					<input id="btnSaveNewCompany" name="btnSaveNewCompany" type="button" value="<?php echo $btnSaveText;?>" onclick="Contacts_Manager__updateAllContactCompanyAttributes('manage-contact_company-record', '<?=$contact_company_id;?>');">
				</td>
			</tr>
			<?php
		}
	}
	?>

	<?php
	if ($mode == 'create') {
		if (($myCompanyDataCase && $userCanManageMyContactCompanyData) || (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyData)) {
			?>
				<td colspan="2" class="textAlignLeft">
					<input id="btnSaveNewCompany" name="btnSaveNewCompany" type="button" value="<?=$btnSaveText;?>" onclick="saveCompany('manage-contact_company-record', '<?=$contact_company_id;?>');">
				</td>
			</tr>
			<?php
		}
	}
	?>

</table>

</tr>
</table>

</form>
<?php

} // End foreach loop

return;
