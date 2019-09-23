<?php
include_once('structure_html/load.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>
    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/messageWindow.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/ace.js" ></script>

    <script src="<?php echo base_url(); ?>media/js/panel/layout.js" ></script>

    <script>

        window.addEventListener('load', ()=>{
            var messageWindow = new MessageWindow(document.getElementById('message-window'), '<?php echo base_url() ?>');
            var layout = new Layout('<?php echo $activeStyle ?>',document.getElementById('main'), '<?php echo base_url() ?>', messageWindow, <?php echo $contentLang ?>)
        })

    </script>

    <style>
        #main {color: #000000; }
        #main > div:first-of-type {display: flex;}
        #main > div:first-of-type > p {margin: 5px 15px;}

        #jsEditor{height: 280px;}

        .example {padding: 10px; border: ridge 3px #aeaeae; margin-top: 10px;}
        .example h1 {background: #ffffff; text-align: left; color: #000000;}
        .example img {max-width: 100%;}

        iframe {width: 100vw; height: 60vh; position: absolute; left: 0;}
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