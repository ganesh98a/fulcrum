<?php 
function report_footer($database, $user_company_id)
{
    $db = DBI::getInstance($database);
    //To get the contact company_id
     $query1="SELECT id FROM `contact_companies` WHERE `user_user_company_id` = $user_company_id AND `contact_user_company_id` = $user_company_id ";
    $db->execute($query1);
    $row1=$db->fetch();
    $ContactCompId=$row1['id'];
    //To get the compant address
    $Footeraddress='';
    $query2="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId and `head_quarters_flag`='Y'  order by id desc limit 1";
    $db->execute($query2);
    $row2=$db->fetch();
    if($row2)
    {
    $CompanyOfficeId=$row2['id'];
    if($row2['address_line_1']!='')
    {
    $Footeraddress.=$row2['address_line_1'];
    }
    if($row2['address_city']!='')
    {
    $Footeraddress.=' | '.$row2['address_city'];
    }
    if($row2['address_state_or_region']!='')
    {
    $Footeraddress.=' , '.$row2['address_state_or_region'];
    }
    if($row2['address_postal_code']!='')
    {
    $Footeraddress.='  '.$row2['address_postal_code'];
    }
    }else{
        $query4="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId   order by id desc limit 1";
    $db->execute($query4);
    $row4=$db->fetch();
    
    $CompanyOfficeId=$row4['id'];
    if($row4['address_line_1']!='')
    {
    $Footeraddress.=$row4['address_line_1'];
    }
    if($row4['address_city']!='')
    {
    $Footeraddress.=' | '.$row4['address_city'];
    }
    if($row4['address_state_or_region']!='')
    {
    $Footeraddress.=' , '.$row4['address_state_or_region'];
    }
    if($row4['address_postal_code']!='')
    {
    $Footeraddress.='  '.$row4['address_postal_code'];
    }
    }
    
   $query3="SELECT * FROM `contact_company_office_phone_numbers` WHERE `contact_company_office_id` = $CompanyOfficeId";
    $db->execute($query3);
    $business='';
    $fax='';
     while ($row3 = $db->fetch()) 
        {
           if($row3['phone_number_type_id']=='1')
            {
            $business = $row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            } 
            if($row3['phone_number_type_id']=='2')
            {
            $fax = ' | (F)'.$row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            }   
        }
    $Footeraddress=trim($Footeraddress,'| ');
   $faxPhone =$business.$fax;
   return array('address'=>strtoupper($Footeraddress),'number'=>$faxPhone);

     
}
?>
