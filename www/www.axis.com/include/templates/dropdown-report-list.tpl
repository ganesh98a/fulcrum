{if isset($report_list) && !empty($report_list)}
{html_options id="ddl_report_id" name=ddl_report_id options=$report_list selected=$selectedreport }
{else}
{html_options id="ddl_report_id" name=ddl_report_id options=$report_list selected=$selectedreport}
{/if}
