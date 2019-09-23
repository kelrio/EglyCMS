<?php
include_once('structure_html/load.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>
    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/messageWindow.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/panel/user.js" ></script>

    <style>
        #main{color: #000000;}
    </style>

</head>
<body>

    <header>
        <?php include_once('structure_html/header.php'); ?>
    </header> 

    <aside id='main'>
        <p><?php echo lang($message) ?></p>
    </aside>

    
    
</body>
</html>