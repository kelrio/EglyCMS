<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $nameElement ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>media/js/home/menu.js"></script>
    <script src="<?php echo base_url(); ?>media/js/home/elements.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/presentationView/<?php echo $activeStyle['value'] ?>/menu.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/presentationView/<?php echo $activeStyle['value'] ?>/footer.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/presentationView/<?php echo $activeStyle['value'] ?>/body.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/presentationView/<?php echo $activeStyle['value'] ?>/header.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/quill.bubble.css">

    <script>
        $(window).on('scroll', function(){
            if($(window).scrollTop()){
                $('nav').addClass('black')
            }else{
                $('nav').removeClass('black');
            }
        })

        window.addEventListener('load', (e)=>{
            //elementy przypisane do podstrony
            var _elementsOnPage = <?php echo $elementsOnPage; ?>;

            console.log(JSON.stringify(_elementsOnPage));
            //elementy menu
            var _menuElement = [...<?php echo $menuElements; ?>];

            var menu = new Menu(_menuElement, document.getElementById('menu'), '<?php echo base_url() ?>', '<?php echo $logo['value'] ?>');
            var elements = new Elements(_elementsOnPage, document.getElementById('article'), '<?php echo base_url() ?>');
        });

    </script>

    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/quill.bubble.css">

</head>
<body>
    <nav id='menu'></nav>

    <header>
        <h1><?php echo $nameElement ?></h1>
    </header>

    <section id='article'>
    
    </section>

    <footer>

    </footer>
    
    
</body>
</html>