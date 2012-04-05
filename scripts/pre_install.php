<?php 
if (! defined('sugarEntry') || ! sugarEntry) 
    die('Not A Valid Entry Point'); 


function pre_install() { 

  
    $entry_point_registry['CustomEntryPointOne'] = array('file' => 'custom/modules/Campaigns/Tracker.php', 'auth' => false); 

    $add_entry_point = false; 
    $new_contents = ""; 
    $entry_point_registry = null; 
    if(file_exists("custom/include/MVC/Controller/entry_point_registry.php")){ 

        // This will load an array of the hooks to process 
        include("custom/include/MVC/Controller/entry_point_registry.php"); 

         
        if(!isset($entry_point_registry['CustomEntryPointOne'])) { 
            $add_entry_point = true; 
            $entry_point_registry['CustomEntryPointOne'] = array('file' => 'custom/modules/MyCustomEntry/CustomEntryPointOne.php', 'auth' => true); 
        } 
        if(!isset($entry_point_registry['CustomEntryPointTwo'])) { 
            $add_entry_point = true; 
            $entry_point_registry['CustomEntryPointTwo'] = array('file' => 'custom/modules/MyCustomEntry/CustomEntryPointTwo.php', 'auth' => true); 
        } 
    } else { 
        $add_entry_point = true;     
        $entry_point_registry['CustomEntryPointOne'] = array('file' => 'custom/modules/MyCustomEntry/CustomEntryPointOne.php', 'auth' => true); 
        $entry_point_registry['CustomEntryPointTwo'] = array('file' => 'custom/modules/MyCustomEntry/CustomEntryPointTwo.php', 'auth' => true); 
    } 
    if($add_entry_point == true){ 

        require_once('include/utils/array_utils.php'); 
        require_once('include/utils/sugar_file_utils.php'); 

        foreach($entry_point_registry as $entryPoint => $epArray){ 
            $new_contents .= "\$entry_point_registry['".$entryPoint."'] = array('file' => '".$epArray['file']."' , 'auth' => '".$epArray['auth']."'); \n"; 
        } 
         
        $new_contents = "<?php\n$new_contents\n?>"; 
        $file = 'custom/include/MVC/Controller/entry_point_registry.php'; 
        $paths = explode('/',$file); 
        $dir = ''; 
        for($i = 0; $i < sizeof($paths) - 1; $i++) 
        { 
            if($i > 0) $dir .= '/'; 
            $dir .= $paths[$i]; 
            if(!file_exists($dir)) 
            { 
                sugar_mkdir($dir, 0755); 
            } 
        } 
        $fp = sugar_fopen($file, 'wb'); 
        fwrite($fp,$new_contents); 
        fclose($fp); 
    } 
} 
?>