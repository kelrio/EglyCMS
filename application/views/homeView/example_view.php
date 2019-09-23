<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Example Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="<?php echo base_url(); ?>media/js/jquery-3.3.1.min.js"></script>



    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/quill.bubble.css">

    <script>
        $(window).on('scroll', function(){
            if($(window).scrollTop()){
                $('nav').addClass('black')
            }else{
                $('nav').removeClass('black');
            }
        })

        window.addEventListener('focus', loadStyle);

        window.addEventListener('load', loadStyle);

        function loadStyle(){
            //ustawienie styli css z edytora
            var style = document.getElementById('style');
            //console.log(JSON.parse(localStorage.getItem('style')));
            style.innerHTML = JSON.parse(localStorage.getItem('style'))
        }

    </script>

    <link rel="stylesheet" href="<?php echo base_url() ?>media/css/quill.bubble.css">

</head>
<body>
    <style id="style"></style>

    <nav id='menu'>
    <div class="logo">Title</div><ul><li><a href="#">Strona główna</a><ul></ul></li><li><a href="#" class="panel">Logowanie</a></li></ul>
    </nav>

    <header>
        <h1>Strona główna</h1>
    </header>

    <section id='article'>
        <article><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget lectus fringilla, euismod turpis quis, vehicula mi. Aliquam non odio ac odio sodales eleifend. Donec convallis est lacus, vitae mattis elit pretium id. Sed fermentum est ex. Quisque id vehicula sapien. Nam pulvinar condimentum urna, eu efficitur ante consectetur nec. Nulla facilisi.</p></article><article><p><br></p></article><article><div class="imageContainer"><img src="<?php echo base_url() ?>media/img/example.jpg"></div><div class="imageDescription"><p>Description of the picture</p></div></article><article><ol><li class="ql-align-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sed varius leo, at mattis nibh. Sed tortor ipsum, semper sit amet arcu sit amet, dapibus accumsan ante. Duis dignissim felis velit, lobortis posuere sapien fermentum et. Nullam dictum turpis eu nulla rhoncus elementum. Proin vehicula ex nec lobortis commodo. Proin posuere tempor nisl fringilla aliquam. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li class="ql-align-justify"><em class="ql-font-monospace">Pellentesque rutrum tortor at erat semper, aliquet porttitor mauris tempor. Quisque non ligula vel dui tincidunt consectetur. Suspendisse tempus ut metus quis scelerisque. Pellentesque convallis varius sollicitudin. Integer et euismod tellus, vitae vulputate libero. In hac habitasse platea dictumst. Integer placerat nibh ipsum, et ullamcorper felis auctor eu. Etiam efficitur semper mi ut finibus. Pellentesque a ex eleifend, condimentum ipsum a, dictum turpis. Morbi venenatis neque risus, quis rutrum tortor eleifend dapibus. Aliquam nec rhoncus lacus. Integer porttitor sem ut enim euismod, at porttitor sapien sagittis.</em></li><li class="ql-align-justify">Donec dui metus, hendrerit vitae viverra nec, commodo sit amet nisi. Etiam condimentum eu leo mattis malesuada. Pellentesque consequat sodales scelerisque. In a metus enim. In cursus dignissim placerat. Aenean sodales augue vitae dui laoreet commodo. Mauris aliquet, lorem ac sollicitudin vestibulum, nibh orci sagittis ipsum, nec ornare lorem felis sit amet neque. Nunc et egestas ligula. Nunc ac nunc et odio mollis feugiat. Phasellus at dolor molestie, ornare mi sed, cursus libero. Integer bibendum nisl sit amet sodales ultrices. Ut tincidunt scelerisque varius. Mauris pulvinar bibendum pharetra. Nunc et mattis felis. Cras vestibulum egestas volutpat.</li></ol><p><br></p></article>
    </section>

    <footer>

    </footer>
    
    
</body>
</html>