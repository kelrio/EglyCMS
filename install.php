<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EglyCMS - setup</title>

    <style>
        .stage{width: 80%; margin: 120px auto; display: none;}
        .active {display: block;}

        footer{position: fixed; bottom: 50px; right: 20px; padding: 25px 50px; }
        .btn {padding: 15px 25px; margin-left: 50px; }
    </style>
</head>
<body>

    <div class='stage active'>
        <h1>EglyCMS</h1>

        <p>Już tylko krok dzieli cię od możliwości tworzenia własnej strony internetowej w systemie "EglyCMS"</p>
        <p><strong>Pamiętaj! Po zakończeniu instalacji plik instalacyjny zostanie usunięty i nie probuj go umieszczać w systemie na nowo.</strong></p>
        <p>Aby przejść dalej, kliknij przycisk dalej</p>
    </div>

    <div class='stage'>
        <h1>Baza danych</h1>

        <p>Wprowadź dane potrzebne do łączenia się z bazą danych</p>
        <p>hostname<input type="text"  id="hostname"></p>
        <p>username<input type="text"  id="username"></p>
        <p>password<input type="password" id="password"></p>
        <p>database<input type="text" id="database"></p>

        <button>Testuj połączenie</button>
        <p id='result'></p>
    </div>

    <footer>
        <button class='btn next' >Dalej</button>
    </footer>
    
</body>
</html>