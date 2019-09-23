<?php
include_once('structure_html/load.php');
/**
 * $contentLang - zawiera treści do wyświetlania, przekazywana z kontrolera
 */

?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>
    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/messageWindow.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/panel/user.js" ></script>

    <script>
        window.addEventListener('load', ()=>{

            var language = JSON.stringify();

            var messageWindow = new MessageWindow(document.getElementById('message-window'), '<?php echo base_url() ?>');
            var user = new User('<?php echo $userData ?>',document.getElementById('main'), '<?php echo base_url() ?>', messageWindow, <?php echo $contentLang ?>);
        })
    </script>

    <style>
        label {border: solid 2px #39393d; border-radius: 5px; padding: 3px; background: #ffffff; text-transform: uppercase; color: #39393d; outline: none; margin: 1px; -webkit-transition-duration: 0.4s; transition-duration: 0.4s;}
        input[type='checkbox'] {display: none;}
        input[type="checkbox"]:checked+label {background: #39393d; color: #ffffff; border-color: #5d5d64;}
    </style>

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