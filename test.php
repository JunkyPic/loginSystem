<?php

function doTrim($data){
        foreach($data as $key => $value){
            $data[$key] = str_replace(' ', '', $value);
        }
        return $data;
    }

$credentials = array('username' => ' arwwaraw' , 
                     'password' => '  atweat  atwtaw  ',
                     'password' => '  atweat  atwtaw             1                  ',
                     );
                     
echo '<pre>';
print_r($credentials);
echo '<pre>';
print_r(doTrim($credentials));
