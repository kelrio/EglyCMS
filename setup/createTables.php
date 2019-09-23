<?php

        if(isset($_POST['hostname']) && isset($_POST['hostname']) && isset($_POST['hostname']) && isset($_POST['hostname'])){

                $hostname = $_POST['hostname'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $database = $_POST['database'];

                //tablica do tworzenia nowych tabel
                $file = array('menu', 'image', 'imageOnPage', 'textOnPage', 'page', 'setting', 'user');
                //tablica nazw tabel w kolejności do usunięcia
                $clearTable = array('EglyCMS_page', 'EglyCMS_imageOnPage', 'EglyCMS_image', 'EglyCMS_textOnPage', 'EglyCMS_menu', 'EglyCMS_setting', 'EglyCMS_user');

                $conn = @new mysqli($hostname, $username, $password, $database);
                
                // $fp = fopen("script.sql", "r");
                // $data = fread(fopen("script.sql", "r"), filesize("script.sql"));

                $result = @$conn -> query("show tables");
                $tables = array(); //przechowuje, nazwy tabel w bazie danych

                 /* pobieranie tabel z bazy danych */
                while( $row = mysqli_fetch_array($result) ){
                        $tables[] = $row[0];
                }
                /* Usuwamy z pamięci wynik zapytania */
                mysqli_free_result($result);

                $tableToDelete = '';

                //jeśli istnieją jakieś tabele
                if(count($tables) > 0){
                        //usuwanie tabel, ktore maja takie same nazwy jak tabele w systemie
                        foreach ($clearTable as $row) {
                                if(array_search($row, $tables)){
                                        //$tableToDelete += $row.',';
                                        $result = @$conn -> query("DROP TABLE ".$row);
                                }
                        }
                        // foreach ($tables as $row) {
                        //         $result = @$conn -> query("DROP TABLE ".$row);
                        // }
                }

                $countSuccess = 0;
                        
                //tworzenie tabel
                foreach ($file as $index => $value) {
                        $fp = fopen($value.".sql", "r");
                        $str = fread($fp, filesize($value.".sql"));

                        $result = @$conn -> query($str);

                        if ($result !== false){
                                $countSuccess++;
                        }
                }

                //zwrcenie wyniku działań
                if ($countSuccess == count($file)){
                        echo 'success';
                }else {
                        echo 'error';
                }

                //zamknięcie połączenia
                mysqli_close($conn);
        }else{
                echo "Access Denied";
        }