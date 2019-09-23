<?php
include_once('structure_html/load.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>

    <script src="<?php echo base_url(); ?>media/js/panel/panelMenu.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/messageWindow.js" ></script>
    <script>
        window.onload = ()=>    {
            var messageWindow = new MessageWindow(document.getElementById('message-window'), '<?php echo base_url() ?>');

            var menu = new Menu('<?php echo $menu_json ?>', document.getElementsByClassName('container-result-grid')[0], '<?php echo base_url(); ?>', 
            messageWindow, <?php echo $contentLang ?>);
        }
    </script>
    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/panelMenu.css">
</head>
<body>

    <div id='message-window'>
        <div id='message'>
            <img src='' />
            <p></p>
        </div>
    </div>

    <header>
        <?php include_once('structure_html/header.php'); ?>
    </header> 

    <aside>
        <div class='container-result-grid'>
        </div>
    </aside>

    
    
</body>
</html>