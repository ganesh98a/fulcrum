<?php /* Smarty version Smarty-3.0.8, created on 2022-04-13 07:20:30
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dashboard-admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2297062565d9e7d1ba7-87550377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a3b76a3f1f54c9bda71b9eea257e0d9db8b6743' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dashboard-admin.tpl',
      1 => 1638855414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2297062565d9e7d1ba7-87550377',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<input id="userRole"  type="hidden" value="<?php echo $_smarty_tpl->getVariable('userRole')->value;?>
">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?><!-- The Modal -->
<div id="ViewUser" class="modal">
</div>
<div class="CoverDiv">
	<?php if ((isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"||$_smarty_tpl->getVariable('userRole')->value=="admin")&&$_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>
	<input id="projManager"  type="hidden" value="<?php echo $_smarty_tpl->getVariable('projManager')->value;?>
">
	<input id="user_id"  type="hidden" value="<?php echo $_smarty_tpl->getVariable('user_id')->value;?>
">
	<input type="hidden" id="sort" value="asc">
	<div class="col-sm-12 row">	
		<table border="0" class="content" cellpadding="5" style="margin:0; padding:15px" width="100%">
			<tr>
    			<td class="tasksummary" style="color: #06c; font-weight: 500;">
    			YOU HAVE 
    			<span style="font-weight:bold;" id="task_cnt"><?php echo $_smarty_tpl->getVariable('tasksummary_cnt')->value;?>
</span> 
    			TASKS FOR YOUR REVIEW !
    			<select id="task_summary_type" name="task_summary_type" style="float: right">
					<option value="meetings" selected>Meetings</option>
					<option value="rfis">RFIs</option>
					<option value="submittals">Submittals</option>
					<option value="bs">BS</option>
				</select>
    			</td>
    			<td>
    				<div class="fields">
					    <ul>
				   		  <li class="tasksummary">
					        <span class="indicator red-box"></span>
					        <b>Over due</b>
					      </li>
					      <li class="tasksummary">
					        <span class="indicator yellow-box"></span>
					        <b>0-7 days</b>
					      </li>
					      <li class="tasksummary">
					        <span class="indicator blue-box"></span>
					        <b>8-15 days</b>
					      </li>
					      
					      <?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&(($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)||$_smarty_tpl->getVariable('userRole')->value=="admin")&&$_smarty_tpl->getVariable('userCanViewDashboard')->value){?>
					      <li>
					        <label><input type="radio" value="tasksummary" name="dashboardkpi" class="radioLable" checked="true">Task Summary</label>
					      </li>
					      <li>
					        <label><input type="radio" value="operational" name="dashboardkpi" class="radioLable" >Projects</label>
					      </li>
					      <?php }?>
					    </ul>
					  </div>
    			</td>
    		</tr>
		</table>	
		<div class="ts-row tasksummary">
			<table border="0" class="content" cellpadding="5" style="margin:0; padding:15px" width="100%">
				<thead>					
		    		<tr class="tasksummary" id="tasksummary_filter_tr">
						<?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?>
		    			<td style="width: 20%;"><input type="text" class="form-control" placeholder="Enter" id="assigned_to"></td>
		    			<?php }?>
		            	<td <?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?> style="width: 20%;" <?php }else{ ?> style="width: 40%;" <?php }?> ><input type="text" class="form-control" placeholder="Enter" id="task_item"></td>
		            	<td <?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?> style="width: 15%;" <?php }else{ ?> style="width: 15%;" <?php }?>>
		            		<div class="datepicker_style_custom" style="display: block;">
								<input type="text" value="" class="fcus_date cus_date_report form-control " id="due_date" placeholder="Pick a Date"><img class="datepicker datedivseccal_icon_gk" width="13" alt="" src="./images/cal.png" id="dp1562147413179">
							</div>
		    			</td>
		    			<td <?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?> style="width: 10%;"  <?php }else{ ?> style="width: 10%;" <?php }?> id="not_meeting" ><input type="text" class="form-control" placeholder="Enter" id="meeting_type"></td>
		    			<td <?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?> style="width: 20%;"  <?php }else{ ?> style="width: 20%;" <?php }?>><input type="text" class="form-control" placeholder="Enter" id="discussion"></td>
		    			<td <?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?> style="width: 15%;"  <?php }else{ ?> style="width: 15%;" <?php }?>>
		    				<a href="javascript:void(0)" class="btn-cmn complete_date" style="color:white; text-decoration: none; font-size: 11px;white-space: nowrap;" id="uncomplete" >Show Completed Tasks</a>	
		    			</td>
					</tr>
				</thead>
				<tbody class="border-tbody" id="tasksummary_bod">          	
            		<?php echo $_smarty_tpl->getVariable('tasksummary')->value;?>

            	</tbody>
			</table>
		</div>
		<?php }?>
		
	<!-- This is for Admin -->
		<?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="admin")){?>
		<table cellpadding="10">
			<tr>
				<td class="operate" style="padding-left: 0; <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>  display:none; <?php }?>">
					<div class="col-sm-4 submittalmanager slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open Submittal Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('subCountAd')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open Submtl</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('subOpenDetails')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								 in <?php echo $_smarty_tpl->getVariable('company')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="viewOpenSubmittalAdmin()">View All</button>
							</div>
						</div>
					</td>
				
				<td class="operate" style=" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>  display:none; <?php }?>">
					<div class="col-sm-4 rfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open RFI Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('rfiOpen')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open RFI</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('rfiOpenDetails')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								in <?php echo $_smarty_tpl->getVariable('company')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="viewOpenRfiAdmin()">View All</button>
							</div>
						</div>
					</td>
				<td class="operate" style=" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>  display:none; <?php }?>">
					<div class="col-sm-4 SecSlide slides">
						<div class="SecInTop TopSlide">
							<div class="SlideHeader">
								<div class="Splitleft">
									Project Index
								</div>
								<div class="Splitright">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="project" class="radioLable" checked="true"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="project" class="radioLable"> QTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="YearTill" name="project" class="radioLable"> YTD
									</label>
								</div>
							</div>
						</div>
						<div class="DownSlide SecInDown" id="ProjectAdd">
							<div class="SlideContent SecInTop">
								<div class="CountNo">
									<!-- <?php echo $_smarty_tpl->getVariable('ActiveProject')->value;?>
 -->
								</div>
								<div class="DaysCount"></div>
							</div>
							<div class="SlideContentSec SecInDown">
								<div class="IndexContent">
									Active Project
								</div>
								<div class="DaysCount"></div>
							</div>
						</div>
					</div>
				</td>
				
				
				<!-- <td class="operate" style="">
					<div class="col-sm-4 rfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div><b>Open RFI Index</b></div>
							<div class="splitthrdleft">
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('rfiCount')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Opened</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('rfitopProject')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div class="splitthrdleftdown total_user"
							style="text-align: left;padding-left: 10px;">
								Open RFI in <?php echo $_smarty_tpl->getVariable('rfiPrjName')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allRFI()">View All</button>
							</div>
						</div>
					</td> -->
				</tr>
				<tr>
					<td class="operate" style="padding-left: 0;  <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>  display:none; <?php }?>">
					<div class="col-sm-4 closesubmittalSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="font-size:14px;">
								<div style="float: left;">
									<b>Closed Submtl Index</b>
								</div>	
								<div style="float: right;">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="sub_closed" class="radioLable" checked="true"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="sub_closed" class="radioLable"> QTD
									</label>
									<label class="Slidelabel" 
									style="margin-right: 0;">
										<input type="radio" value="YearTill" name="sub_closed" class="radioLable"> YTD
									</label>
								</div>
								</div>
							<div id="closedsubmittaldata">
							<div class="splitthrdleft">
								<div class=" bottomAlign">
								..	
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Closed Submtl</td>
									</tr>
									
									
								</table>
							</div>
						</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								in <?php echo $_smarty_tpl->getVariable('company')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedSubmittal()">View All</button>
							</div>
						</div>
					</td> 
					<td class="operate" style=" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>  display:none; <?php }?>">
					<div class="col-sm-4 closedrfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="font-size:14px;">
								<div style="float: left;">
									<b>Closed RFI Index</b>
								</div>	
								<div style="float: right;">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="rfi_closed" class="radioLable" checked="true"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="rfi_closed" class="radioLable"> QTD
									</label>
									<label class="Slidelabel" 
									style="margin-right: 0;">
										<input type="radio" value="YearTill" name="rfi_closed" class="radioLable" > YTD
									</label>
								</div>
								</div>
							<div id="closedrfidata">
							<div class="splitthrdleft">
								<div class=" bottomAlign">
								  ..
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Closed RFI</td>
									</tr>
									
									
								</table>
							</div>
						</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								in <?php echo $_smarty_tpl->getVariable('company')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedRFI()">View All</button>
							</div>
						</div>
					</td>
					<td class="operate" style=" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>  display:none; <?php }?>">
					<div class="col-sm-4 ThrdSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div><b>User Index</b></div>
							<div class="splitthrdleft">							
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('companyUsers')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Users</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('user_project')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div class="splitthrdleftdown total_user"
							style="text-align: left;padding-left: 10px;">
								Total Users in <?php echo $_smarty_tpl->getVariable('company')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_adminUsers()">View All</button>
							</div>
						</div>
					</td>
				<!-- <td class="operate" style="">
					<div class="col-sm-4 submittalSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div><b>Open Submittal Index</b></div>
							<div class="splitthrdleft">
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('subCount')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Opened</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('topProject')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div class="splitthrdleftdown total_user"
							style="text-align: left;padding-left: 10px;">
								 in <?php echo $_smarty_tpl->getVariable('subPrjName')->value;?>

							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allSubmittal()">View All</button>
							</div>
						</div>
					</td>
					 -->
				</tr>
			</table>
			<?php }?>
				<!-- This is for user -->
				<?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&!$_smarty_tpl->getVariable('projManager')->value&&!$_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?>
				<!--<div class="messageQueueErrorHeader">Unauthorized Access Restricted </div> 
				 <div class="messageQueueErrorHeader">You are not a "Project Manager" in any of the projects. </div>
				 <div class="messageQueueErrorHeader">Dashboard Access Restricted. </div> -->
				<?php }?> 

		<?php if (isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=="user"&&$_smarty_tpl->getVariable('projManager')->value)){?>
		<table cellpadding="10">
			<tr>
				<td   class="operate" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?> style="display: none;" <?php }?>>
					<div class="col-sm-4 rfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open RFI Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('userRfiCount')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open RFI</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('rfiuserProject')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								Open RFI
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_userRFI()">View All</button>
							</div>
						</div>
					</td>
				<td  class="operate" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?> style="display: none;" <?php }?>>
					<div class="col-sm-4 submittalSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open Submittal Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									<?php echo $_smarty_tpl->getVariable('subuserCount')->value;?>

								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open submtl</td>
									</tr>
									<?php echo $_smarty_tpl->getVariable('userSubmittalopen')->value;?>

									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								Open Submittal
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_userSubmittal()">View All</button>
							</div>
						</div>
					</td>
				</tr>
				<tr>
						<td class="operate" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?> style="display: none;" <?php }?>>
					<div class="col-sm-4 closedrfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="font-size:14px;">
								<div style="float: left;">
									<b>Closed RFI Index</b>
								</div>	
								<div style="float: right;">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="rfi_userclosed" class="radioLable" checked="true"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="rfi_userclosed" class="radioLable"> QTD
									</label>
									<label class="Slidelabel" 
									style="margin-right: 0;">
										<input type="radio" value="YearTill" name="rfi_userclosed" class="radioLable"> YTD
									</label>
								</div>
								</div>
							<div id="closeduserrfidata">
							<div class="splitthrdleft">
								<div class=" bottomAlign">
								..	
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Closed RFI</td>
									</tr>
									
									
								</table>
							</div>
						</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								Closed RFI
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_alluserclosedRFI()">View All</button>
							</div>
						</div>
					</td> 
					<td  class="operate" <?php if (($_smarty_tpl->getVariable('userCanViewTaskSummary')->value)){?> style="display: none;"<?php }?>>
					<div class="col-sm-4 closesubmittalSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="font-size:14px;">
								<div style="float: left;">
									<b>Closed Submtl Index</b>
								</div>	
								<div style="float: right;">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="subuser_closed" class="radioLable" checked="true"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="subuser_closed" class="radioLable"> QTD
									</label>
									<label class="Slidelabel" 
									style="margin-right: 0;">
										<input type="radio" value="YearTill" name="subuser_closed" class="radioLable"> YTD
									</label>
								</div>
								</div>
							<div id="userclosedsubmittaldata">
							<div class="splitthrdleft">
								<div class=" bottomAlign">
								..	
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Closed Submtl</td>
									</tr>
									
									
								</table>
							</div>
						</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								Closed Submtl
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedUserSubmittal()">View All</button>
							</div>
						</div>
					</td> 
					
				</tr>	
				
					
			</table>
			
			<?php }?>
			<!-- <table class="chartDivAdmin" cellpadding="15">
				<tr>
					<tr>
						<td>
							<div id="DCRChartDiv" class="DCRChartDiv">

								<div id="DCRChartd" class="DCRChartd">
									<div id="DCRChart" class="DCRChart">
									</div>
								</div>
								<div class="ChartSplitright">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="dcrchart" class="radioLable"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="dcrchart" class="radioLable"> QTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="YearTill" name="dcrchart" class="radioLable" checked="true"> YTD
									</label>
								</div>
							</div>
						</td>
					</tr>
				</table> -->

			</div>
		</div>
		<?php }?>

