<?php
include_once('structure_html/load.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>

    <style>
        #main > div {margin: 8px 0;}
    </style>

    <script src="<?php echo base_url(); ?>media/js/panel/setting.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/messageWindow.js" ></script>

    <script>

        window.addEventListener('load', ()=>{
            var messageWindow = new MessageWindow(document.getElementById('message-window'), '<?php echo base_url() ?>');

            var setting = new Setting('<?php echo $setting ?>', document.getElementById('main'), messageWindow, <?php echo $contentLang ?>);
        })
        

    </script>
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

    

    <aside id='main'>
        
    </aside>

    
    
</body>
</html>