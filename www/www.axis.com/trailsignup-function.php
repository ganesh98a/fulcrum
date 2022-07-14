<?php
$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;

require_once('page-components/select_country_list.php');

/**
* Display the signup form
* @return html
*/
function renderTrailSignForm()
{	

	$ddlCountries = getCountrySelectBox('United States', null, "country");
	//For captcha
	$rand=substr(rand(),0,4);//only show 4 numbers
	$htmlContent = <<<END_HTML_CONTENT

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">

<div class="signup-bg">
<div class="login-form-sec signup-page"> 
	<hgroup>                                         
	  <h2>SIGN UP FOR FREE</h2>										  
	  <h4>GC or Developer? Sign up for a 60 day FREE TRIAL and see how Fulcrum can streamline your projects</h4>
	  <h4>Subcontractor? Contact your Project Manager for a Plans download link or project invite</h4>
	</hgroup> 
	<form name="signupTrail" id="signupTrail" >
	<div id="record_creation_form_container" class="">
	<div class="RFI_table_create">	
	<table width="100%" cellspacing="0" cellpadding="4" border="0">
	<tbody>
		<tr>
		<td class="">
		 <div class="group">    		    
		 	<input class="loginFormInput required target" maxlength="50" name="auth_name" size="30" tabindex="101" type="text" id="first_name"/>		    
		 	<span class="highlight"></span><span class="bar"></span>
		 	<label>First Name<span class="mandat">*</span></label>
		 </div>
		</td>
		<td class="">
		 <div class="group">  
		  <input type="text" class="loginFormInput required target" maxlength="50" name="auth_name" size="30" tabindex="101" id="last_name"/>
		  <span class="highlight"></span><span class="bar"></span>
		  <label>Last Name<span class="mandat">*</span></label>
		 </div>
		</td>		
		</tr>		
		<tr>
		<td class="">
		 <div class="group">  
		  <input type="text" class="loginFormInput required target"  id="email" onchange="checkemailExists(this.value)"/>
		  <span class="highlight"></span><span class="bar"></span>
		  <label>Email<span class="mandat">*</span></label>
		  <span id="email_err" class="mandat" style="display:none;"></span>
		  <input type="hidden" id="email_check" value="1">
		 </div> 
		</td>
		<td class="">
		 <div class="group">  
		  <input type="text" class="loginFormInput required target" id="company"/>
		  <span class="highlight"></span><span class="bar"></span>
		  <label>Company Name<span class="mandat">*</span></label>
		 </div>
		</td>
		</tr>	
		<tr>
		<td class="">
		 <div class="group captcha-form" style="width: 85% !important;float: left;">  
 		  <input type="text" class="captcha" readonly="readonly" id="cap_org"  value="$rand">		  
		  <span class="highlight"></span><span class="bar"></span>
		  <label>Captcha</label>		  
		 </div>
		 <button style="width: 10% !important;padding-left: 0;padding-right: 0;" type="button" onclick="captch()" class="buttonui"><i class="entypo-ccw"></i></button>
		</td>
		</td>
		<td class="">
		 <div class="group">  
  		  <input type="text" class="loginFormInput required target" id="cap_match"/>
		  <span class="highlight"></span><span class="bar"></span>
		  <label>Enter the text shown<span class="mandat">*</span></label>
		  <span id="captch_err" class="mandat" style="display:none;">Captcha Not Matched!</span>
		 </div> 
		</td>
	   </tr>	
		<tr>			
		<td class="">
		 <div class="group">  
		  <input type="text" class="loginFormInput number required target" id="zip" maxlength="6"/>
		  <span class="highlight"></span><span class="bar"></span>
		  <label>Zip<span class="mandat">*</span></label>
		 </div>
		 </td>
		<td>
		 <table style="float:right;">
		  <tbody>
		   <tr>
		    <td>
			 <input type="button" class="buttonui cancel-btn" onclick="window.location.href='/'" value="Cancel">
			</td>
			<td style="padding-left: 10px;">
			 <input type="button" class="buttonui" onclick="SignupViaPromiseChain('1');" value="Sign Up">
			</td>
		   </tr>
		  </tbody>
		 </table>    	
		</td>
	   </tr>
	  </tbody>
	 </table>
	</div>
   </div>
  </form>
  <div class="powered">
     <a href="/">&copy;2017 MyFulcrum.com&trade;</a>
     <a href="/login-form.php">Login</a>
     <a href="/account.php">Account</a>
  </div>
</div>
</div>


END_HTML_CONTENT;

	return $htmlContent;
	// return "good";

}

function signSuccessRecord($sign_id)
{

	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from free_trail_users where id = '$sign_id'";
	$db->execute($query);
	$row = $db->fetch();

	$first_name =$row['first_name'];
	$last_name  =$row['last_name'];
	$email 	    =$row['email'];

	$htmlContent = <<<END_HTML_CONTENT
	<div class="signup-bg">
	 <div class="login-form-sec signup-page">
	 <hgroup>    	   
	    <h3 class="signup-success">Welcome to Fulcrum. We will send an email with login details shortly.</h3>	   
      <a style="text-decoration:none;" href="/">
	  <input type="button" class="buttonui" href="/" style="width: auto;margin: 10% auto 23%;" value="Back to Home"></a>
	</hgroup>    
	
	
	<div class="powered">
     <a href="/">&copy;2017 MyFulcrum.com&trade;</a>
     <a href="/login-form.php">Login</a>
     <a href="/account.php">Account</a>
   </div>
   </div>
   </div>
END_HTML_CONTENT;

	return $htmlContent;

}

function checkEmailExist($email)
{

	$db = DBI::getInstance($database);  // Db Initialize
	$query = "SELECT * from free_trail_users where email = '$email'";
	$db->execute($query);
	$row = $db->fetch();
	$ret_data='';
	if($row)
	{
		$ret_data='1';
	}
	else
	{
		$ret_data='0';
		$query1 = "SELECT * from contacts where email = '$email'";
		$db->execute($query1);
		$row1 = $db->fetch();
		if($row1)
		{
			$ret_data='1';
		}
	}
	$db->free_result();
	return $ret_data;

}
