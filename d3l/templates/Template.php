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

    private function interpretControlStructures($content)
    {
        // Simple if else statements
        $content = preg_replace_callback('/{% if (.*?) %}(.*?){% else %}(.*?){% endif %}/s', function ($matches) {
            $condition = trim($matches[1]);
            $ifBlock = trim($matches[2]);
            $elseBlock = trim($matches[3]);
            return '<?php if (' . $condition . '): ?>' . $ifBlock . '<?php else: ?>' . $elseBlock . '<?php endif; ?>';
        }, $content);

        // Simple if statements
        $content = preg_replace_callback('/{% if (.*?) %}(.*?){% endif %}/s', function ($matches) {
            $condition = trim($matches[1]);
            $block = trim($matches[2]);
            return '<?php if (' . $condition . '): ?>' . $block . '<?php endif; ?>';
        }, $content);

        // Simple for loops
        $content = preg_replace_callback('/{% for (\w+) in (\w+) %}(.*?){% endfor %}/s', function ($matches) {
            $variableName = trim($matches[1]);
            $arrayName = trim($matches[2]);
            $block = trim($matches[3]);

            // Replace {{var}} placeholders with their corresponding values
            $pattern = '/{{\s*([^}\s]+)\s*}}/';

            $block = preg_replace_callback($pattern, function ($matches) {
                $variableName = trim($matches[1]);
                return '<?php echo $' . $variableName . '; ?>';
            }, $block);

            return '<?php foreach ( $this->context["' . $arrayName . '"] as $' . $variableName . '): ?>' . $block . '<?php endforeach; ?>';
        }, $content);

        return $content;
    }

    public function render($template)
    {
        ob_start();
        extract($this->context);

        // Read the template file into a string
        $templateContent = file_get_contents('./app/templates/' . $template);

        // Replace {{var}} placeholders with their corresponding values
        $pattern = '/{{\s*([^}\s]+)\s*}}/';

        $templateContent = preg_replace_callback($pattern, function ($matches) {
            $variableName = trim($matches[1]);
            return isset($this->context[$variableName]) ? $this->context[$variableName] : $matches[0];
        }, $templateContent);

        // Interpret simple control structures
        $templateContent = $this->interpretControlStructures($templateContent);

        // Generate a unique file name for the temporary PHP file
        $tempFilename = tempnam(sys_get_temp_dir(), 'template_');

        // Write the generated PHP code to the temporary file
        file_put_contents($tempFilename, '<?php ob_start(); ?>' . $templateContent . '<?php $content = ob_get_clean(); echo $content; ?>');

        // Include the temporary PHP file
        include $tempFilename;

        // Delete the temporary PHP file
        unlink($tempFilename);

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
