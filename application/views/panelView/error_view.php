<?php
include_once('structure_html/load.php');

$this->lang->load('error_lang', 'polish');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>

    <style>
        aside h1{color: #000000; margin-top: 25px; margin-left: 50px; margin-right: 50px; margin-bottom: 25px;}
    </style>
</head>
<body>

    <header>
        <?php include_once('structure_html/header.php'); ?>
    </header> 

    <aside>
        <h1><?php echo $this->lang->line($error);?></h1>
    </aside>

    
    
</body>
</html>