<?php

class mainController {
    public function level($selected=''){
        $level = ['admin','user','superadmin'];
        $opt = '';
        foreach($level as $item){
            $opt.='<option '.($selected == $item ? 'selected' : '').' value="'.$item.'">'.$item.'</option>';
        }
        return $opt;
    }
}


?>