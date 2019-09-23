<?php
include_once('structure_html/load.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>

    <script src="<?php echo base_url(); ?>media/js/panel/contentMenu.js" ></script>
    <script>
        window.onload = ()=>{
            var menu = new MenuSort('<?php echo $menu_json ?>', document.getElementsByClassName('container-result-grid')[0], "<?php echo base_url(); ?>");
        }
    </script>

    <style>

        .container-result-grid .mainElement{/*width: 250px; text-align: right; border-right: solid 1px #000000; */ margin-bottom: 30px;}
        .container-result-grid .mainElement a{text-decoration: none; color: #12159f; }
        .container-result-grid .mainElement a:hover{color: #9f1212;}
        .container-result-grid .mainElement .element{/*margin-top: 5px; margin-bottom: 5px; padding-right: 5px; */}
        .container-result-grid .mainElement .element:hover .subelement{/*display: inline-grid*/}
        .container-result-grid .mainElement .subelement{display: none; /* position: absolute; */ text-align: left;}

        @media only screen and (min-width: 768px){
            .container-result-grid {width: auto;}
            .container-result-grid .mainElement{width: 250px; border-right: solid 1px #000000; text-align: right;}
            .container-result-grid .mainElement a:hover{color: #9f1212;}
            .container-result-grid .mainElement .element{margin-top: 5px; margin-bottom: 5px; padding-right: 5px;}
            .container-result-grid .mainElement .element:hover .subelement{display: inline-grid}
            .container-result-grid .mainElement .subelement{left: calc(260px + 30px); padding-left: 10px; position: absolute;}

        }

        @media only screen and (max-width: 768px){
            .container-result-grid {width: 100%;}
            .container-result-grid .mainElement{width: 75%; text-align: left;}
            .container-result-grid .mainElement a:hover{color: #9f1212;}
            .container-result-grid .mainElement .element{margin-top: 5px; margin-bottom: 5px; padding-right: 5px;}
            .container-result-grid .mainElement .element .subelement{display: grid}
            .container-result-grid .mainElement .subelement{ left: 15px; padding-left: 0px; position: relative;}

        }
    </style>
</head>
<body>

    <header>
        <?php include_once('structure_html/header.php'); ?>
    </header> 

    <aside>
        <p><a href="<?php echo base_url(); ?>panel/menu"><button><?php echo $this->lang->line('content_view_menu') ?></button></a></p>

        <div class='container-result-grid'>
        </div>
    </aside>

    
    
</body>
</html>