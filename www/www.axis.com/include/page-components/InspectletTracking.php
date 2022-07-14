<?php
$logname=$session->getLoginName();
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
$primary_contact_id = $session->getPrimaryContactId();
$inspecletTracking = <<<InspecletTracking
<!-- Begin Inspectlet Asynchronous Code -->
<script type="text/javascript">
(function() {
window.__insp = window.__insp || [];

__insp.push(['wid', 1388210994]);
__insp.push(['tagSession', {email: "$logname",user_company_name:"$userCompanyName",primary_contact_id:"$primary_contact_id"}]);
var ldinsp = function(){
	__insp.push(['tagSession', {email: "$logname",user_company_name:"$userCompanyName",primary_contact_id:"$primary_contact_id"}]);
if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js?wid=1388210994&r=' + Math.floor(new Date().getTime()/3600000); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
setTimeout(ldinsp, 0);
})();
</script>


<!-- End Inspectlet Asynchronous Code -->
InspecletTracking;
?>
