<?php 
 if($RN_reportType === 'Project Delay Log' || $RN_reportType==='Daily Construction Report (DCR)'){
         $type_mention="Project Delay Log";
        if($RN_reportType === 'Daily Construction Report (DCR)')
        {
            $type_mention="Daily Log";
        }
      include_once('./Reports/GenerateExcelReports.php');
    }
?>
