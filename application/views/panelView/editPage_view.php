<?php
include_once('structure_html/load.php');
$obSettings = json_decode($menu_element);
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once('structure_html/head.php'); ?>
    <script src="<?php echo base_url(); ?>media/js/panel/editpageList.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/panel/modalWindow.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/panel/editpageBoard.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/panel/editpageDragAndDrop.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/jquery-ui.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/ace.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/quill.min.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/checkDisplay.js" ></script>
    <script src="<?php echo base_url(); ?>media/js/messageWindow.js" ></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>media/css/quill.bubble.css">

    <script>
        //var quill = 

        window.onload = ()=>{
            //zawiera wszystkie elementy utworzone dla danej podstrony
            //console.log(<?php echo $elements_on_page; ?>);

            var messageWindow = new MessageWindow(document.getElementById('message-window'), '<?php echo base_url() ?>');

            var dragAndDrop = new DragAndDrop();
            var modal = new ModalWindow();
            var list = new List(document.getElementById('main'), '<?php echo base_url(); ?>', dragAndDrop);
            var board = new Board(document.getElementById('main'), '<?php echo base_url(); ?>', dragAndDrop, modal, <?php echo $obSettings[0]->idmenu ?>, <?php echo $elements_on_page; ?>, messageWindow, <?php echo $contentLang ?>);
            dragAndDrop.setBoard(board);
        } 
    </script>

    <style>
        .list{width: 100%; height: auto; background: #272727; }
        .list.scroll {position: fixed; top: 0; left: 0; padding-left: 45px; z-index: 99;}
        .list .element {width: 60px; height: 60px; opacity: 1; padding: 2px; display: inline-grid;}
        .list .element .attr{width: 100%; height: 100%; border: none; margin-left: 2px; margin-right: 2px;}
        .list .element .attr:active {outline: 2px solid red;}
        .list .element .attr img{max-width: 100%;}
        .list .element .attr .options{overflow: hidden;}
        .list .element .attr.text {}
        .list .element .attr.cols {}
        .list .element .attr.rows {}
        .list .element .attr .options{display: none; position: absolute;}
        .list .element .attr:hover .options{display: inline; border: solid 1px #ffffff; padding: 10px;}

        .container{ border: ridge 2px #a0a0a0; padding: 25px 10px;}
        .container .board{width: 100%; height: auto; padding: 8px 0; display: none; margin-top: 2px; margin-bottom: 2px;}
        .container .allow {width: calc(100% - 10px); background: #73afe7; border-radius: 5px;}
        .container .board.allow {display: block;}
        .container .attr {display: block;}
        .container .attr .trashContainer {width: 32px; height: 32px; background: #ffffff; position: absolute; top: -15px; right: -10px; z-index: 50; text-align: center; border-radius: 5px; border: outset 1px #acacac;}
        .container .attr .trashContainer:hover {border: inset 1px #acacac;}
        .container .attr .trashContainer img{max-width: 100%; max-height: 100%;}
        .container .attr .moveContainer {width: 32px; height: 32px; background: #ffffff; position: absolute; top: 17px; right: -10px; z-index: 50; text-align: center; border-radius: 5px; border: outset 1px #acacac;}
        .container .attr .moveContainer:hover {border: inset 1px #acacac;}
        .container .attr .moveContainer img{max-width: 100%; max-height: 100%;}
        .container .attr.ql-container {display: block}
        .container .attr:hover {outline: 1px #acacac dashed;}
        .container .text {color: #000000;}
            .imageContainer {text-align: center; display: block;}
            .imageContainer input{width: 100%; text-align: center; color: #939393; font-style: italic; border: none;}
            .imageContainer input:focus{outline: none;}
            .imageContainer img {max-width: 100%;}
            .imageContainer div {width: 100%;}

        .container .attr.cols{ display: grid; grid-template-columns: 50% 50%;}
        .container .attr > .attr.table{height: auto; outline: 1px solid #c9c9c9; padding: 0;}
        .container .attr.cols > .attr.table.col-1-2{display: grid;}
        .container .attr.row > .attr.table.row-1-2{display: inline;}
        .modalBackground{width: 100%; height: 100%; position: fixed; top: 0; left: 0; background: #252525;}
            .modal {display: block; background: #ffffff; height: calc(100% - 50px); margin: 25px; border-radius: 5px; overflow: auto; z-index: 99;}
            .modal .modalHeader{background: #dee1e6; width: 100%; display: flex; justify-content: flex-end;}
            .modal .modalHeader .modalExit {margin-bottom: 3px; background: #dee1e6; padding: 5px 17px; width: 10px; color: #000000;  font-family: 'Helvetica', 'Arial', sans-serif;}
            .modal .modalHeader .modalExit:hover {background: #cd2a2a; color: #ffffff;}
            
            .modal .modalBody {}

            .modal .modalFooter {position: relative; bottom: 0;}
            .modal .modalFooter .bodyModalFooter{width: 100%; color: #000000; margin: 3px 7px; border-top: solid 2px #dee1e6; padding: 0 15px; background: #ffffff; display: flex; justify-content: flex-end;}
        
        .container .modalBackground .modalFooter {position: relative; bottom: 0; display: flex; justify-content: flex-end; }
        .container .modalBackground .modal .uploadImageContainer {display: flex; border-bottom: solid 1px #9d9d9d; padding: 5px 25px;}
        .container .modalBackground .modal .uploadImageContainer .close{position: absolute; right: 35px;}
        .container .modalBackground .modal .uploadImageContainer .uploadFile{width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1;}
        .container .modalBackground .modal .uploadImageContainer label {font-size: 1.25em; font-weight: 700; color: #7a7a7aff; display: inline-block; border: solid 1px #7a7a7aff; padding: 3px 3px 1px 3px; border-radius: 7px; cursor: pointer;}
        .container .modalBackground .modal .uploadImageContainer label > img {max-height: 20px; display: inline; margin-right: 5px;}
            .uploadImageContainer label:hover {border: solid 1px #b86b6b !important; color: #b86b6b !important;}
        .container .modalBackground .modal .imageContainer{display: flex; flex-wrap: wrap;}
        .container .modalBackground .modal .imageContainer .imgContainer {width: auto; margin: 10px 5px; height: auto;}
        .container .modalBackground .modal .imageContainer .imgContainer .selected {outline: 5px solid #003fa7;}
        .container .modalBackground .modal .imageContainer .imgContainer img{max-height: 150px;}


        .blockedWindow {width: 100%; height: 100%; position: absolute; top: 0; left: 0; background: #575757; opacity: 0.6; z-index: 98;}

        .draggable {position: fixed; opacity: 0.6;}

        .jsEditor {height: 350px;}

        @media only screen and (min-width: 768px){
            .container .board{padding-top: 8px; padding-bottom: 8px;}
        }

        @media only screen and (max-width: 768px){
            .container .board{padding-top: 12px; padding-bottom: 12px;}
        }
        

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