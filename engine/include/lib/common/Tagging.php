<?php

/**
* Framework standard header comments.
*
* ?UTF-8? Encoding Check - Smart quotes instead of three bogus characters.
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
* Draws.
*
* @category   Framework
* @package    Draws
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class Tagging extends IntegratedMapper
{
  /**
  * Class name for use in deltifyAndSave().
  */
  protected $_className = 'Tagging';

  /**
  * Table name for this Integrated Mapper.
  *
  * @var string
  */
  protected $_table = 'tagging';

   // ORM properties (instance variables) derived from the Database table attributes (fields)
  public $project_id;
  public $tag_name;

  public static function insertTagging($database,$tagname,$project_id)
  {
      $db = DBI::getInstance($database);
      $query ="INSERT INTO `tagging` (`project_id`,`tag_name`)VALUES (?,?)";
      $arrValues = array($project_id,$tagname);
      $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
      $db->free_result();
      $tagId = $db->insertId;
      return $tagId;
  }

  public static function searchAndInsertTag($database,$tagname,$project_id)
  {
      $db = DBI::getInstance($database);
      $tagname = trim($tagname);
      $query ="SELECT `id` from `tagging` where tag_name = ? and project_id = ?";
      $arrValues = array($tagname,$project_id);
      $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
      $row = $db->fetch();
      if($row)
      {
         $tagId = $row['id'];
      }else
      {
         $tagId = self::insertTagging($database,$tagname,$project_id);
      }
     
      $db->free_result();
      
      return $tagId;
  }
  public static function getTagName($database,$tag_ids)
  {
     $db = DBI::getInstance($database);
      $tagname = trim($tagname);
      $query ="SELECT GROUP_CONCAT(`tag_name`) as tag_name from `tagging` where id IN ($tag_ids)";
      $db->execute($query);
      $row = $db->fetch();
      $tag_name = $row['tag_name'];
     return $tag_name;
      
  }

  public static function searchTagName($database,$search,$project_id)
  {
    $db = DBI::getInstance($database);
      $query ="SELECT tag_name from `tagging` where tag_name LIKE '$search%' and project_id =$project_id";
      $db->execute($query);
      while($row = $db->fetch())
      {
        $arr_search[] = $row['tag_name'];
      }
     return $arr_search;
  }




}
/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
