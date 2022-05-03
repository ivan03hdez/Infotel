<?php

    function file_exists_ci($file) {
        if (file_exists($file))
            return true;

        $lowerfile = strtolower($file);

        foreach (glob(dirname($file).'/modelos/*')  as $file){
            //echo baseName(strtolower($file))."<br>";
            if (baseName(strtolower($file)) == $lowerfile.'.php')
                return true;
        }


        return false;
    }
?>