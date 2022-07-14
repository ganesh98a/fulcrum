<input id="userRole"  type="hidden" value="{$userRole}">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}<!-- The Modal -->
<div id="ViewUser" class="modal">
</div>
<div class="CoverDiv">
	{if (isset($userRole) &&  ($userRole=="user" || $userRole=="admin") && $userCanViewTaskSummary  )}
	<input id="projManager"  type="hidden" value="{$projManager}">
	<input id="user_id"  type="hidden" value="{$user_id}">
	<input type="hidden" id="sort" value="asc">
	<div class="col-sm-12 row">	
		<table border="0" class="content" cellpadding="5" style="margin:0; padding:15px" width="100%">
			<tr>
    			<td class="tasksummary" style="color: #06c; font-weight: 500;">
    			YOU HAVE 
    			<span style="font-weight:bold;" id="task_cnt">{$tasksummary_cnt}</span> 
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
					      
					      {if isset($userRole) && (($userRole=="user" && $projManager ) || $userRole=="admin") && $userCanViewDashboard}
					      <li>
					        <label><input type="radio" value="tasksummary" name="dashboardkpi" class="radioLable" checked="true">Task Summary</label>
					      </li>
					      <li>
					        <label><input type="radio" value="operational" name="dashboardkpi" class="radioLable" >Projects</label>
					      </li>
					      {/if}
					    </ul>
					  </div>
    			</td>
    		</tr>
		</table>	
		<div class="ts-row tasksummary">
			<table border="0" class="content" cellpadding="5" style="margin:0; padding:15px" width="100%">
				<thead>					
		    		<tr class="tasksummary" id="tasksummary_filter_tr">
						{if isset($userRole) && ($userRole=="user" && $projManager )}
		    			<td style="width: 20%;"><input type="text" class="form-control" placeholder="Enter" id="assigned_to"></td>
		    			{/if}
		            	<td {if isset($userRole) && ($userRole=="user" && $projManager )} style="width: 20%;" {else} style="width: 40%;" {/if} ><input type="text" class="form-control" placeholder="Enter" id="task_item"></td>
		            	<td {if isset($userRole)  && ($userRole=="user" && $projManager )} style="width: 15%;" {else} style="width: 15%;" {/if}>
		            		<div class="datepicker_style_custom" style="display: block;">
								<input type="text" value="" class="fcus_date cus_date_report form-control " id="due_date" placeholder="Pick a Date"><img class="datepicker datedivseccal_icon_gk" width="13" alt="" src="./images/cal.png" id="dp1562147413179">
							</div>
		    			</td>
		    			<td {if isset($userRole) && ($userRole=="user" && $projManager )} style="width: 10%;"  {else} style="width: 10%;" {/if} id="not_meeting" ><input type="text" class="form-control" placeholder="Enter" id="meeting_type"></td>
		    			<td {if isset($userRole) && ($userRole=="user" && $projManager )} style="width: 20%;"  {else} style="width: 20%;" {/if}><input type="text" class="form-control" placeholder="Enter" id="discussion"></td>
		    			<td {if isset($userRole) && ($userRole=="user" && $projManager )} style="width: 15%;"  {else} style="width: 15%;" {/if}>
		    				<a href="javascript:void(0)" class="btn-cmn complete_date" style="color:white; text-decoration: none; font-size: 11px;white-space: nowrap;" id="uncomplete" >Show Completed Tasks</a>	
		    			</td>
					</tr>
				</thead>
				<tbody class="border-tbody" id="tasksummary_bod">          	
            		{$tasksummary}
            	</tbody>
			</table>
		</div>
		{/if}
		
	<!-- This is for Admin -->
		{if isset($userRole) && ($userRole=="admin")}
		<table cellpadding="10">
			<tr>
				<td class="operate" style="padding-left: 0; {if ($userCanViewTaskSummary)}  display:none; {/if}">
					<div class="col-sm-4 submittalmanager slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open Submittal Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$subCountAd}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open Submtl</td>
									</tr>
									{$subOpenDetails}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								 in {$company}
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="viewOpenSubmittalAdmin()">View All</button>
							</div>
						</div>
					</td>
				
				<td class="operate" style=" {if ($userCanViewTaskSummary)}  display:none; {/if}">
					<div class="col-sm-4 rfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open RFI Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$rfiOpen}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open RFI</td>
									</tr>
									{$rfiOpenDetails}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								in {$company}
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="viewOpenRfiAdmin()">View All</button>
							</div>
						</div>
					</td>
				<td class="operate" style=" {if ($userCanViewTaskSummary)}  display:none; {/if}">
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
									<!-- {$ActiveProject} -->
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
									{$rfiCount}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Opened</td>
									</tr>
									{$rfitopProject}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div class="splitthrdleftdown total_user"
							style="text-align: left;padding-left: 10px;">
								Open RFI in {$rfiPrjName}
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allRFI()">View All</button>
							</div>
						</div>
					</td> -->
				</tr>
				<tr>
					<td class="operate" style="padding-left: 0;  {if ($userCanViewTaskSummary)}  display:none; {/if}">
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
								in {$company}
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedSubmittal()">View All</button>
							</div>
						</div>
					</td> 
					<td class="operate" style=" {if ($userCanViewTaskSummary)}  display:none; {/if}">
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
								in {$company}
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedRFI()">View All</button>
							</div>
						</div>
					</td>
					<td class="operate" style=" {if ($userCanViewTaskSummary)}  display:none; {/if}">
					<div class="col-sm-4 ThrdSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div><b>User Index</b></div>
							<div class="splitthrdleft">							
								<div class=" bottomAlign">
									{$companyUsers}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Users</td>
									</tr>
									{$user_project}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div class="splitthrdleftdown total_user"
							style="text-align: left;padding-left: 10px;">
								Total Users in {$company}
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
									{$subCount}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Opened</td>
									</tr>
									{$topProject}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div class="splitthrdleftdown total_user"
							style="text-align: left;padding-left: 10px;">
								 in {$subPrjName}
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allSubmittal()">View All</button>
							</div>
						</div>
					</td>
					 -->
				</tr>
			</table>
			{/if}
				<!-- This is for user -->
				{if isset($userRole) && ($userRole=="user" && !$projManager &&  !$userCanViewTaskSummary)}
				<!--<div class="messageQueueErrorHeader">Unauthorized Access Restricted </div> 
				 <div class="messageQueueErrorHeader">You are not a "Project Manager" in any of the projects. </div>
				 <div class="messageQueueErrorHeader">Dashboard Access Restricted. </div> -->
				{/if} 

		{if isset($userRole) && ($userRole=="user" && $projManager )}
		<table cellpadding="10">
			<tr>
				<td   class="operate" {if ($userCanViewTaskSummary)} style="display: none;" {/if}>
					<div class="col-sm-4 rfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open RFI Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$userRfiCount}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open RFI</td>
									</tr>
									{$rfiuserProject}
									
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
				<td  class="operate" {if ($userCanViewTaskSummary)} style="display: none;" {/if}>
					<div class="col-sm-4 submittalSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open Submittal Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$subuserCount}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open submtl</td>
									</tr>
									{$userSubmittalopen}
									
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
						<td class="operate" {if ($userCanViewTaskSummary)} style="display: none;" {/if}>
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
					<td  class="operate" {if ($userCanViewTaskSummary)} style="display: none;"{/if}>
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
			
			{/if}
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
		{/if}

