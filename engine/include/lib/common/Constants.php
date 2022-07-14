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
class Constants
{
	const SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION = "Bid Invitation - Bidder Specific";
	const SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK = "Unsigned Scope Of Work - Bidder Specific";
	const SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID = "Subcontractor Bid";
	const SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK = "Signed Scope Of Work";


	const BID_GROUP_BY_CONTACT = "bidByContact";
	const BID_GROUP_BY_COSTCODE = "bidByCostcode";

	const SUBCONTRACTOR_BID_DOCUMENT_TYPE_ID		= 1;
	const SIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID		= 2;
	const UNSIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID	= 3;
	const BID_INVITATION_DOCUMENT_TYPE_ID			= 4;
	const SUBMITTAL_DOCUMENT_TYPE_ID				= 5;

}
