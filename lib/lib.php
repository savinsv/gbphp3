<?php
    $style = "/css/style.css";
    $images = "/img/";
    $exts = ['jpg','png','gif'];


    function check_ext($ext,$array_exts){
        if (($ext !=='') and (is_array($array_exts)) and (count($array_exts)>0)){
            return in_array($ext,$array_exts);
        };
    };

    function get_ext($filename) {
        return substr(strrchr($filename,'.'),1);
    };
//            
    function get_files($files_path,$exts) {
        $files = [];
        if (is_dir($files_path)) {
            $images = dir($files_path);
            while (false !== ($entry = $images->read())){
                $ext = mb_strtolower(get_ext($entry));
                if ($entry !== '.' and $entry !== '..' and check_ext($ext,$exts)) {
                    $files[] =  $entry;
                }; 
            };
        };
        return $files;
    };
