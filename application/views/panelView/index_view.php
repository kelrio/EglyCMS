<?php
include_once('structure_html/load.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>
</head>
<body>

    <header>
        <?php include_once('structure_html/header.php'); ?>
    </header> 

    <aside class='tiles'>
        <a href="<?php echo base_url(); ?>panel/layout" class='a'><?php echo $this->lang->line('content_view_layout'); ?></a>
        <a href="<?php echo base_url(); ?>panel/content" class='b'><?php echo $this->lang->line('content_view_content'); ?></a>
        <a href="<?php echo base_url(); ?>panel/setting" class='c'><?php echo $this->lang->line('content_view_setting'); ?></a>
        <a href="<?php echo base_url(); ?>panel/users" class='d'><?php echo $this->lang->line('content_view_users'); ?></a>
    </aside>
    
</body>
</html>