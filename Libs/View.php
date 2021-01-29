<?php

namespace Libs;

use Libs\TemplateNotFoundException;

class View {

    public static function render(string $template = null, array $data = null) : bool {
        if(empty($template)){
            return false;
        }

        $template = TEMPLATES_PATH.DIRECTORY_SEPARATOR.$template;

        if(mb_substr($template, -4) !== '.php'){
            $template .= '.php';
        }

        if(!file_exists($template)){
            throw new TemplateNotFoundException("Template not found: $template");
        }

        if(!empty($data)){
            extract($data, EXTR_OVERWRITE);
        }

        ob_start();
        include_once $template;
        ob_end_flush();
        return true;
    }

}
