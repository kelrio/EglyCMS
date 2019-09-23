<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Install</title>

    <script src="<?php echo base_url() ?>media/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url() ?>media/js/messageWindow.js"></script>
    <script src="<?php echo base_url() ?>media/js/install/install.js"></script>
    <script>
        window.addEventListener('load', ()=>{
            var messageWindow = new MessageWindow(document.getElementById('message-window'), '<?php echo base_url() ?>');
            var install = new Install('<?php echo base_url() ?>', document.getElementById('footer'), messageWindow);
        })
    </script>

    <style>
        
        html, body{background: linear-gradient(#5757ff, #2a2a7c) no-repeat; background-size:contain; font-family: sans-serif; width: 100%; height: 100%; margin: 0;}

        .hidden {display: none;}
        #footer{padding: 5vh 50vw;}
        .btn {padding: 15px 25px;}
        .row{width:100%;}
        
        #message-window {text-align: center; position: fixed; top: -100px; left: 50%; z-index: 99; transform: translateX(-50%);}
        #message-window #message {background: #ffffff; padding: 25px 5px 5px 5px; width: auto; border-radius: 0 0 15px 15px; border-style: none ridge ridge ridge; color: #212121;}
        #message-window #message p{margin: 10px; display: inline;}
        #message-window #message img{ display: inline;}

        .main{padding: 12vh 12vw;}
        .main > .window{ background: #eeeeee; border-radius: 16px; border: ridge 3px #6a6a74;}
        .main > .window >p:first-child{margin: 0;}
        .main > .window > p{padding: 5px 5vw; background: #0000a6; color: #ffffff; border-radius: 13px 13px 0 0;}
        .main > .window > article {padding: 3vh 3vw;}

        button {border: solid 2px #39393d; border-radius: 5px; padding: 3px; background: #ffffff; text-transform: uppercase; color: #39393d; outline: none; margin: 1px; -webkit-transition-duration: 0.4s; transition-duration: 0.4s;}
        button:hover {background: #39393d; color: #ffffff;}
        button[disabled] {background: #68686f; color: #39393d;}
        button[disabled]:hover {background: #68686f; color: #39393d;}



        
        
    </style>
</head>
<body>
    
    <div id='message-window'>
        <div id='message'>
            <img src='' />
            <p></p>
        </div>
    </div>

    <section class='main'>
        <div class='window'>
            <p>Setup</p>
            <article id='1' class='hidden'>
                <h3>Konfigauracja łączenia z serwerem</h3>

                <div class="row">
                    <p>Witaj w instalatorze bazy danych systemy EglyCMS. Aby rozpocząć wprowadź dane do bazy danych, ktorą otrzymałeś podczas tworzenia konta hostingowego i następnie kliknij "Sprawdź połączenie" aby dostać możliwość przejścia dalej</p>
                </div>

                <div class='row'>
                    <input type="text" id="hostname" placeholder="np. localhost | twojastrona.pl">
                    <label for="hostname">Adres bazy</label>
                </div>
                <div class='row'>
                    <input type="text" id="username"  placeholder='np. root | nazwa użytkownika'>
                    <label for="username">Nazwa konta</label>
                </div>
                <div class='row'>
                    <input type="text" id="password" placeholder='np. password'>
                    <label for="password">Hasło</label>
                </div>
                <div class='row'>
                    <input type="text" id="database" placeholder='np. cms | nazwa bazy danych'>
                    <label for="database">Nazwa Bazy</label>
                </div>
                <div class='row'>
                    <button id='checkConnection' class='btn'>Sprawdź połączenie</button>
                </div>
            </article>

            <article id='2' class='hidden'>
                <div class='row'>
                    <p>W tym momencie nastąpi właściwa konfiguracja bazy danych i plikow konfiguracyjnych. Nie musisz się niczym martwić, proces jest automatyczny. Jedynym twoim zadaniem jest kliknąć "Rozpocznij instalację" i zaczekać na zakończenie</p>
                    <p>Jeśli posiadasz jakieś tabele w wybranej bazie danych to wykonaj backup bazy, ponieważ system wyczyści bazę ze wszystkich tabel</p>
                    <p><strong>UWAGA!</strong> Po zakończeniu tego procesu instalator zostanie usunięty, jeśli kiedyś nastąpi problem z bazą danych przekopiuj spowrotem na serwer plik "application/controllers/install.php" z pakietu instalacyjnego</p>
                </div>

                <div class='row'>
                    <button id='createDataBase'>Rozpocznij instalację</button>
                </div>
            </article>

            <article id='3' class='hidden'>
                <div class='row'>
                    <p>Wszystko gotowe, od tej pory możesz cieszyć się swoją własną stroną internetową zbudowaną w systemie EglyCMS. Aby zarządzać stroną przejdź do panelu zarządzania albo przejdź na adres <a href="<?php echo base_url() ?>">swojej strony</a> i wybierz zaloguj.</p>
                    <p>Dane do logowania, hasło należy jak najszybciej zmienić w sekcji ustawiń w panelu zarządzania</p>
                    <ul>
                        <li>
                            Nazwa użytkownika: <strong>admin</strong>
                        </li>
                        <li>
                            Hasło: <strong>admin</strong>
                        </li>
                    </ul>
                </div>
            </article>
            
            <div id="footer">
                <button class='btn next'>Dalej</button>
            </div>
        </div>
        
    </section>

</body>
</html>