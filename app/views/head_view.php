<?php
ob_start('minify_output');

function minify_output($buffer) {
    $search = [
        '/\>[^\S]+/s',
        '/[^\S ]+\</s',
        '/(\S)+/s'
    ];
    $replace = ['>', '<', '\\1'];
    return preg_replace($search, $replace, $buffer);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="public/images/avocado.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>