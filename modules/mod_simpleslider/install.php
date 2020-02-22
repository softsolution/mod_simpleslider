<?php
function info_module_mod_simpleslider(){
        $_module['title']         = 'Слайдер SimpleSlider';
        $_module['name']          = 'Слайдер SimpleSlider';  
        $_module['description']   = 'Простой слайдер для Универсального каталога';     
        $_module['link']          = 'mod_simpleslider';     
        $_module['position']      = 'sidebar';
        $_module['author']        = 'soft-solution.ru';   
        $_module['version']       = '1.0';                           
        
        $_module['config'] = array();
        
        return $_module;

    }

    function install_module_mod_simpleslider(){

        return true;

    }
    
    function upgrade_module_mod_simpleslider(){

        return true;
        
    }

?>