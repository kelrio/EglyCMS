class Install{
    constructor(url, footerSelector, messageWindow){
        this.url = url;
        this.connectionDataBase = false;
        this.stage = 0;
        this.messageWindow = messageWindow;

        //dane do łączenia z bazą danych
        this.hostname;
        this.username;
        this.password;
        this.database;

        this.footerSelector = footerSelector;

        this.footerSelector.children[0].addEventListener('click', this.changeStage.bind(this));

        this.changeStage();
    }

    changeStage(){
        this.stage++;
        this.footerSelector.children[0].setAttribute('disabled', true);

        var stage1 = document.getElementById('1');
        var stage2 = document.getElementById('2');
        var stage3 = document.getElementById('3');

        switch(this.stage){
            case 1: stage1.classList.remove('hidden');this.checkConnection(); break;
            case 2: stage1.classList.add('hidden'); stage2.classList.remove('hidden'); this.createDataBase();  break;
            case 3: stage2.classList.add('hidden'); stage3.classList.remove('hidden'); break;
        }
    }

    //tworzenie table i rekordw w bazie
    createDataBase(){
        var btnCreateDataBase = document.getElementById('createDataBase');
        btnCreateDataBase.addEventListener('click', (e)=>{

            this.messageWindow.show('Tworzenie pliku konfiguracyjnego')
            $.ajax({
                url: `${this.url}install/saveConfig`,
                method: 'POST',
                data: {hostname: this.hostname, username: this.username, password: this.password, database: this.database}
            }).done((res)=>{
                console.log(res);
                if(res == 'success'){

                    this.messageWindow.show('Tworzenie tabel w bazie danych');
                    //tworzenie tabel w bazie danych
                    $.ajax({
                        url: `${this.url}setup/createTables.php`,
                        method: 'POST',
                        data: {hostname: this.hostname, username: this.username, password: this.password, database: this.database}
                    }).done((res)=>{
                        console.log(res);
                        if(res == 'success'){
        
                            this.messageWindow.show('Wprowadzanie wymaganych danych')
                            //dodawanie danych
                            $.ajax({
                                url: `${this.url}install/setData`,
                                method: 'POST'
                            }).done((res)=>{
                                console.log(res);
                                if(res == 'success'){
                
                                    this.messageWindow.show('Czyszczenie danych instalacyjnych');
                                    $.ajax({
                                        url: `${this.url}setup/deleteFile.php`,
                                        method: 'POST'
                                    }).done((res)=>{
                                        if(res == 'success'){
                                            this.messageWindow.done('Instalacja zakończona');
                                            this.changeStage();
                                        }else{
                                            this.messageWindow.alert('Błąd podcas czyszczenia danych instalacyjnyc');
                                        }
                                    })
                                    //

        
                                }else{
                                    this.messageWindow.alert('Błąd podczas wprowadzania danych');
                                    this.footerSelector.children[0].setAttribute('disabled', true);
                                }
                            })

                        }else{
                            this.messageWindow.alert('Błąd podczas tworzenia tabel');
                            this.footerSelector.children[0].setAttribute('disabled', true);
                        }
                    })
                    
                }else{
                    this.messageWindow.alert('Błąd podczas tworzenia pliku konfiguracyjnego');
                    this.footerSelector.children[0].setAttribute('disabled', true);
                }
            })
        })
    }

    //sprawdzanie poprawności danych łączenia do bazy danych
    checkConnection(){
        var buttonCheckConnetion = document.getElementById('checkConnection');
        buttonCheckConnetion.addEventListener('click', (e)=>{
            
            this.messageWindow.show('Sprawdzanie połączenia z bazą danych');

            this.hostname = document.getElementById('hostname');
            this.hostname = this.hostname.value;
            this.username = document.getElementById('username');
            this.username = this.username.value;
            this.password = document.getElementById('password');
            this.password = this.password.value;
            this.database = document.getElementById('database');
            this.database = this.database.value;

            if(this.hostname != '' && this.username != '' && this.database != ''){
                $.ajax({
                    url: `${this.url}install/checkconnection`,
                    method: 'POST',
                    data: {hostname: this.hostname, username: this.username, password: this.password, database: this.database}
                }).done((res)=>{
                    console.log(res);
                    if(res == 'success'){
                        this.messageWindow.done('Połączenie nawiązane');
                        this.connectionDataBase = true;
                        this.footerSelector.children[0].removeAttribute('disabled');
                    }else{
                        this.messageWindow.alert('Wsytąpił problem podczas nawiązywania połączenia lub wprowadzono błędne dane');
                        this.footerSelector.children[0].setAttribute('disabled', true);
                    }
                })
            }else{
                this.messageWindow.alert('Wprowadź wymagane dane do połączenia');
            }
        })
    }


}