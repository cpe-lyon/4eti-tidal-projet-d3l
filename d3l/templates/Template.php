<?php

namespace D3l\Template;

class Template {
    protected $context = [];

    public function __construct($context = []) {
        $this->context = $context;
    }

    public function assign($key, $value) {
        $this->context[$key] = $value;
    }

    public function render($template)
    {
        ob_start();
        extract($this->context);

        // Read the template file into a string
        $templateContent = file_get_contents('./app/templates/' . $template);

        // Define a custom rendering function
        $render = function ($matches) use ($templateContent) {
            $variableName = trim($matches[1]);
            return isset($this->context[$variableName]) ? $this->context[$variableName] : $matches[0];
        };

        // Replace {{var}} placeholders with their corresponding values
        $pattern = '/{{\s*([^}\s]+)\s*}}/';
        $templateContent = preg_replace_callback($pattern, $render, $templateContent);

        // Evaluate the modified template content as PHP
        eval(' ?>' . $templateContent . '<?php ');

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
