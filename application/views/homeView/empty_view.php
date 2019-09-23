<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');

// $this->lang->load('content_lang', 'polish');

$this->load->database();

$this->lang->load('home/content_lang', $language);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        html, body{width: 100%; height: 100%; margin: 0; padding: 0;}
        body{background: url('./media/img/header/humberto-chavez-1058365-unsplash.jpg'); background-size: cover; font-family: sans-serif; font-size: 21px; text-transform: uppercase;}
        .message{text-align: center; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 25px; background: rgba(255, 255, 255, 0.6); border-radius: 15px;}
    
        .message button {border: solid 2px #E2472f; border-radius: 5px; padding: 3px; background: #ffffff; text-transform: uppercase; color: #E2472f; outline: none; margin: 1px; -webkit-transition-duration: 0.4s; transition-duration: 0.4s; font-size: 18px; padding: 10px;}
        .message button:hover {background: #E2472f; color: #ffffff;}
    </style>
</head>
<body>

    <div class="message">
        <p><?php echo $this->lang->line('emptyView_message_p1'); ?></p>
        <p><?php echo $this->lang->line('emptyView_message_p2'); ?></p>
        <a href="<?php echo base_url() ?>panel"><button><?php echo $this->lang->line('emptyView_button_login'); ?></button></a>
    </div>

</body>
</html>