Running pre_uninstall... 
<?php 
if (! defined('sugarEntry') || ! sugarEntry) 
    die('Not A Valid Entry Point'); 


function pre_uninstall() { 
 
	$entry_point_registry['CustomEntryPointOne'] = array('file' => 'custom/modules/Campaigns/Tracker.php', 'auth' => false); 

    $remove_entry_point = false; 
    $new_contents = ""; 
    $entry_point_registry = null; 
    if(file_exists("custom/include/MVC/Controller/entry_point_registry.php")){ 
     
        include("custom/include/MVC/Controller/entry_point_registry.php"); 

        if(isset($entry_point_registry['CustomEntryPointOne'])) { 
            $remove_entry_point = true; 
            unset($entry_point_registry['CustomEntryPointOne']); 
        } 
        if(isset($entry_point_registry['CustomEntryPointTwo'])) { 
            $remove_entry_point = true; 
            unset($entry_point_registry['CustomEntryPointTwo']); 
        } 
        if($remove_entry_point == true){         

            require_once('include/utils/array_utils.php'); 
            require_once('include/utils/sugar_file_utils.php'); 
         
            foreach($entry_point_registry as $entryPoint => $epArray){ 
                $new_contents .= "\$entry_point_registry['".$entryPoint."'] = array('file' => '".$epArray['file']."' , 'auth' => '".$epArray['auth']."'); \n"; 
            } 
            $new_contents = "<?php\n$new_contents\n?>"; 
            $file = 'custom/include/MVC/Controller/entry_point_registry.php'; 
            $fp = sugar_fopen($file, 'wb'); 
            fwrite($fp,$new_contents); 
            fclose($fp); 
        } 
         
    }     
} 
?>