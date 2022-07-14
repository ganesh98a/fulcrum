<!-- The Modal -->
<input id="userRole"  type="hidden" value="{$userRole}">
<div id="ViewUser" class="modal">
</div>
<div class="CoverDiv">
	<div class="splitcenter">
		<table class="tableCheck">
			<tr class="TopCheck">
				<td><input type="radio" value="operational" name="dashboardkpi" class="radioLable" checked="true"> </td>
				<td><span class="DCRtext">Projects</span></td>
				<td>&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</table>
		<table class="tableCheck">
			<tr class="TopCheck">
				<td><input type="radio" value="business" name="dashboardkpi" class="radioLable"> </td>
				<td><span class="DCRtext">Business</span></td>
			</tr>
		</table>
	</div>
	<div class="col-sm-12 row">
		<!-- {if isset($projManager) && !empty($projManager)} -->
		<!-- {else} -->
		<!-- {/if} -->
		<table cellpadding="15" cellspacing="0" width="50%">
			<tr style="display:none;" class="busines">
				<td style="padding-left:0px;display:none;" class="busines">
					<div class="col-sm-4 FirstSlide slides">
						<div class="FirstInTop TopSlide">
							<div class="SlideHeader">
								<div class="Splitleft">
									Signup Index
								</div>
								<div class="Splitright">
									<label class="Slidelabel">
										<input type="radio" value="MonthTill" name="signup" class="radioLable"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="QuatorTill" name="signup" class="radioLable"> QTD
									</label>
									<label class="Slidelabel">
										<input type="radio" value="YearTill" name="signup" class="radioLable" checked="true"> YTD
									</label>
								</div>
							</div>
						</div>
						<div class="DownSlide FirstInDown" id="SignupAdd">
							<div class="SlideContent FirstInTop">
								<div class="CountNo">
									{$YearlyCount}
								</div>
								<div class="DaysCount"></div>
							</div>
							<div class="SlideContentSec FirstInDown">
								<div class="IndexContent">
									SignUp
								</div>
								<div class="DaysCount"></div>
							</div>
						</div>
					</div>
				</td>
				<td style="display:none;" class="busines">
					<div class="col-sm-4 SecSlide slides">
						<div class="SecInTop TopSlide">
							<div class="SlideHeader">
								<div class="Splitleft">
									Project Index
								</div>
								<div class="Splitright">
									<label class="Slidelabel">
										<input type="radio" class="radioLable" name="project" id="pmtd" checked="true" value="pmtd" onclick="projectmonthly('monthly','project')"> MTD
									</label>
									<label class="Slidelabel">
										<input type="radio" class="radioLable" name="project" id="pqtd" value="pqtd" onclick="projectmonthly('quarter','project')"> QTD
									</label>
									<label class="Slidelabel">
										<input type="radio" class="radioLable" name="project" id="pytd" value="pytd"  onclick="projectmonthly('yearly','project')"> YTD
									</label>
								</div>
							</div>
						</div>
						<div class="DownSlide SecInDown" id="SignupAdd">
							<div class="SlideContent SecInTop">
								<div class="CountNo" id="project_data">
									{$ActiveProject}
								</div>
								<div class="DaysCount projectshow" style="display: none;">
									<table class="DaysTable">
										<tr>
											<td id="ptab1" class="TdFont" align="center">Week1</td>
											<td id="ptab2" class="TdFont" align="center">Week2</td>
											<td id="ptab3" class="TdFont" align="center">Week3</td>
											<td id="ptab4" class="TdFont project_month" align="center" >Week4</td>
											<td id="ptab5" class="TdFont project_month" align="center" >Week5</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="SlideContentSec SecInDown">
								<div class="IndexContent">
									New Project
								</div>
								<div class="DaysCount projectshow" style="display: none;">
									<table class="DaysTableDown">
										<tr >
											<td  id="pweek1" class="TdFont" align="center">14</td>
											<td  id="pweek2" class="TdFont" align="center">7</td>
											<td  id="pweek3" class="TdFont" align="center">1</td>
											<td  id="pweek4" class="TdFont project_month" align="center">0</td>
											<td  id="pweek5" class="TdFont project_month" align="center">0</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</td>
				
			</tr>

			<tr>
				<td class="operate" style="padding-left: 0;">
					<div class="col-sm-4 submittalmanager slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open Submittal Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$subCount}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open Submtl</td>
									</tr>
									{$topProject}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								 in Fulcrum
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allSubmittal()">View All</button>
							</div>
						</div>
					</td>
				
				<td class="operate" style="">
					<div class="col-sm-4 rfiSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="" style="width:160px;font-size:14px;">
								<b>Open RFI Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$rfiCount}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">Projects</td>
										<td class="thAlign">Open RFI</td>
									</tr>
									{$rfitopProject}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								in Fulcrum
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allRFI()">View All</button>
							</div>
						</div>
					</td>
				<td class="operate" style="">
					<div class="col-sm-4 ThrdSlide slides">
						<div class="ThrdInTop TopSlideThrd">
							<div class="">
									<b>User Index</b>
								</div>
							<div class="splitthrdleft">
								
								<div class=" bottomAlign">
									{$totalUsers}
								</div>
							</div>
							<div class="splitthrdright">
								<table cellpadding="5" class="full_width_table1" width="100%">
									<tr>
										<td class="thAlign">General Contractor</td>
										<td class="thAlign">Users</td>
									</tr>
									{$userCompany}
									
								</table>
							</div>
						</div>
						<div class="ThrdInDown DownSlide">
							<div style="text-align: left;padding-left: 15px;"
							 class="splitthrdleftdown total_user">
								Active Users in Fulcrum
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allUsers()">View All</button>
							</div>
						</div>
					</td>
				</tr>
				
			</table><!-- //class="chartDiv cus_health_index" -->
			<table cellpadding="15" cellspacing="0" width="50%" >
				<tr>
					<td class="operate" style="padding-left: 0;">
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
										<input type="radio" value="YearTill" name="sub_closed" class="radioLable"  > YTD
									</label>
								</div>
								</div>
							<div id="closedsubmittaldata">
							<!--	{$closesub} -->
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
								in Fulcrum
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedSubmittal()">View All</button>
							</div>
						</div>
					</td> 
					<td class="operate" style="">
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
							<!--	{$closeRFI}  -->
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
								in Fulcrum
							</div>
							<div class="splitthrdrightdown">
								<button class="view_all_btn" onclick="view_allclosedRFI()">View All</button>
							</div>
						</div>
					</td> 
				</tr>
			</table>
			<table class="chartDiv cus_health_index">
				<tr>
					<td style="display:none;" class="busines">
						<div id="DCRChartDivs" class="DCRChartDiv cus_health_inner">
							<div id="DCRCharts" class="DCRChart activeChart">
							</div>
							<input type="hidden" id="type_det" value="active">
							<div class="ChartSplitright">

								<label class="Slidelabel customerlab">

									<input type="radio" class="radioLable" name="proActive" id="pamtd" value="monthly" onclick="activecustomer('monthly','project')"> MTD
								</label>
								<label class="Slidelabel customerlab"><input type="radio" class="radioLable" name="proActive" id="pamtd" value="quarter" onclick="activecustomer('quarter','project')"> QTD</label>
								<label class="Slidelabel customerlab"><input type="radio" class="radioLable" name="proActive" id="pamtd" value="yearly"  checked onclick="activecustomer('yearly','project')"> YTD</label>

							</div>
							<div class="mainlabel">
								<table width="75%" align="center" style="color:#fff;"><tr><td class="actgen" id="active"><a onclick="setCont('active')" class="activeHref">Active General Contractors</a></td><td>|</td><td id="dormant" >
									<a onclick="setCont('dormant')" class="activeHref">Dormant General Contractors</a></td></table></div>

								</div>
							</td>
							<td class="operate" style="">
								<div id="DCRChartDiv" class="DCRChartDiv">

									<div id="DCRChartd" class="DCRChartd">
										<div id="DCRChart" class="DCRChart">
										</div>
									</div>
									<div class="ChartSplitright">
										<table class="DCRMenuchange">
											<tr class="DcrCheck">
												<td><input type="radio" value="MonthTill" name="dcrchart" class="radioLable"></td>
												<td><span class="DCRtext">MTD</span></td>
											</tr>
											<tr class="DcrCheck">
												<td><input type="radio" value="QuatorTill" name="dcrchart" class="radioLable"></td>
												<td><span class="DCRtext">QTD</span></td>
											</tr>
											<tr class="DcrCheck">
												<td><input type="radio" value="YearTill" name="dcrchart" class="radioLable" checked="true"></td>
												<td><span class="DCRtext">YTD</span></td>
											</tr>
										</table>
									</div>
								</div>
							</td>
						
					
						</tr>
					</table>
				</div>
			</div>
