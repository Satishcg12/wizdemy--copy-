<?php
class View{
    public static function render($view, $data = [])
    {
        $view = ROOT_DIR . 'src/views/' . $view . '.php';
        if (file_exists($view)) {
            extract($data);
            require_once $view;
        } else {
            echo 'View ' . $view . ' not found';
        }
    }
    public static function renderComponent($component, $data = [])
    {
        $component = ROOT_DIR . 'src/views/components/' . $component . '.php';
        if (file_exists($component)) {
            extract($data);
            require $component;
        } else {
            echo 'Component ' . $component . ' not found';
        }
    }
}