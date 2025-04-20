<?php
// minify.php

// Check if the function is already declared to avoid redeclaration errors
if (!function_exists('minify_output')) {
    function minify_output($buffer) {
        $search = [
            '/>[^\\S ]+/s',
            '/[^\\S ]+</s',
            '/(\\s)+/s'
        ];
        $replace = ['>', '<', '\\1'];
        return preg_replace($search, $replace, $buffer);
    }
}
?>