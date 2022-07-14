<?php
/**
 * cron job to generate jobsite daily log dcr report
 */

// Secret key via url allows access to this script
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['sapi'] = 'cli';
$init['skip_always_include'] = true;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/File.php');

$config = Zend_Registry::get('config');
$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
$baseDirectory = $config->system->base_directory;
$fileManagerBasePath = $config->system->file_manager_base_path;
$tempDir = $fileManagerBasePath.'temp/reports';
$removetempDir = $fileManagerBasePath.'temp/reports';
$removeDir = rrmdir($tempDir);
/*rmdir($tempDir);
echo $cmd = "rm -f ".$tempDir."/*";
$cmdRun = `$cmd`;
$fileObject = new File();
$fileObject->delete2($tempDir);*/
function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
?>
