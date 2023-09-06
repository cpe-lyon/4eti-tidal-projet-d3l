// templates/Template.php
<?php

class Template 
{
    protected $data = [];

    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function render($template)
    {
        ob_start();
        extract($this->data);
        include($template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
