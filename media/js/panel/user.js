class User{
    constructor(data, selector, url, messageWindow, lang){
        this.data = JSON.parse(data);
        this.selector = selector;
        this.url = url;
        this.messageWindow = messageWindow;
        this.lang = lang; //zawiera treści językowe do wyświetlania w danym języku

        console.log(this.lang);

        console.log(this.data);

        this.createBoard();
    }

    //tworzy zawartość całej tablicy
    createBoard(){
        this.data.forEach((el) => {
            this.selector.appendChild(this.createRow(el));
        });

        //wygenerowanie przycisku do tworzenia nowych użytkownikow
        var div = document.createElement('div');
        var addBtn = document.createElement('button');
        addBtn.innerText = '+';
        addBtn.addEventListener('click', (e)=>{

            this.messageWindow.show(this.lang.message_sending);

            //ajax wysyłający dane
            $.ajax({
                url: `${this.url}panel/addUser`,
                method: 'POST'
            }).done((res)=>{
                location.reload();
            })
        })

        div.appendChild(addBtn);
        this.selector.appendChild(div);
    }

    //służy do wygenerowania jednego wiersza z jednym użytkownikiem
    createRow(el){
            
            var div = document.createElement('div');
            div.id = el.iduser;

            //input z loginem
            var loginInput = document.createElement('input');
            loginInput.type = 'text';
            loginInput.value = el.login;
            loginInput.placeholder = this.lang.user_login;
            loginInput.name = 'login';
            loginInput.addEventListener('change', (e)=>{
                var id = e.target.parentElement.id;
                var value = e.target.value;

                this.sendData(id, 'login', value);
            })

            //hasło
            var passwordInput = document.createElement('input');
            passwordInput.type = 'password';
            passwordInput.placeholder = this.lang.user_password;
            passwordInput.name = 'password';

            //powtorne hasło
            var rePasswordInput = document.createElement('input');
            rePasswordInput.type = 'password';
            rePasswordInput.placeholder = this.lang.user_password_re;
            rePasswordInput.name = 'replacePassword';
            //zdarzenie zmiany wartości hasła
            rePasswordInput.addEventListener('change', (e)=>{
                var password = e.target.parentElement.children[1].value;
                var rePassword = e.target.value;
                var id = e.target.parentElement.id;

                if(password == rePassword){
                    this.sendData(id, 'password', password);
                }else{
                    passwordInput.value = '';
                    rePasswordInput.value = '';
                    this.messageWindow.alert(this.lang.message_password_not_equal);
                }
                
            })

            //możłiwość edycji artukułow
            var editArticleLabel = document.createElement('label');
            editArticleLabel.htmlFor = `editArticle${el.iduser}`;
            editArticleLabel.innerText = this.lang.user_edit_article;

            var editArticle = document.createElement('input');
            editArticle.type = 'checkbox';
            editArticle.name = 'editArticle';
            editArticle.id = `editArticle${el.iduser}`;
            if(el.editArticle == 1)  editArticle.checked = true;
            editArticle.addEventListener('click', (e)=>{
                var id = e.target.parentElement.id
                var value = (e.target.checked) ? 1 : 0;

                this.sendData(id, 'editArticle', value);
            })

            //możliwość tworzenia stron
            var createPageLabel = document.createElement('label');
            createPageLabel.htmlFor = `createPage${el.iduser}`;
            createPageLabel.innerText = this.lang.user_create_page;

            var createPage = document.createElement('input');
            createPage.type = 'checkbox';
            createPage.name = 'createPage';
            createPage.id = `createPage${el.iduser}`;
            if(el.createPage == 1)  createPage.checked = true;
            createPage.addEventListener('click', (e)=>{
                var id = e.target.parentElement.id
                var value = (e.target.checked) ? 1 : 0;

                this.sendData(id, 'createPage', value);
            })

            //zmiana ustawień
            var changeSettingLabel = document.createElement('label');
            changeSettingLabel.htmlFor = `changeSetting${el.iduser}`;
            changeSettingLabel.innerText = this.lang.user_change_setting;

            var changeSetting = document.createElement('input');
            changeSetting.type = 'checkbox';
            changeSetting.name = 'changeSetting';
            changeSetting.id = `changeSetting${el.iduser}`;
            if(el.changeSetting == 1) changeSetting.checked = true ;
            changeSetting.addEventListener('click', (e)=>{
                var id = e.target.parentElement.id
                var value = (e.target.checked) ? 1 : 0;

                this.sendData(id, 'changeSetting', value);
            })

            //zarządzanie użutkownikami
            var changeAccountLabel = document.createElement('label');
            changeAccountLabel.htmlFor = `changeAccount${el.iduser}`;
            changeAccountLabel.innerText = this.lang.user_change_account;

            var changeAccount= document.createElement('input');
            changeAccount.type = 'checkbox';
            changeAccount.name = 'changeAccount';
            changeAccount.id = `changeAccount${el.iduser}`;
            if(el.changeAccount == 1)  changeAccount.checked = true ;
            changeAccount.addEventListener('click', (e)=>{
                var id = e.target.parentElement.id
                var value = (e.target.checked) ? 1 : 0;

                this.sendData(id, 'changeAccount', value);
            })

            //obsługuje zdarzenie usunięcia elementu
            var deleteBtn; 
            if(el.delete == null){
                deleteBtn = document.createElement('button');
                deleteBtn.innerText = '-';
                deleteBtn.addEventListener('click', (e)=>{
                    if(confirm(this.lang.user_popup_confirm_delete_account)){
                        this.messageWindow.show(this.lang.message_sending);

                        var id = e.target.parentElement.id;
                        var login = e.target.parentElement.firstChild.value;

                        //ajax wysyłający dane
                        $.ajax({
                            url: `${this.url}panel/deleteUser`,
                            method: 'POST',
                            data: {iduser: id, login: login}
                        }).done((res)=>{
                            this.messageWindow.done(this.lang.message_sending_ok);
                            //usuwa dany element
                            e.target.parentElement.remove();
                        })
                    }
                }) 
            }
            


            div.appendChild(loginInput);
            div.appendChild(passwordInput);
            div.appendChild(rePasswordInput);
            div.appendChild(editArticle);
            div.appendChild(editArticleLabel);
            div.appendChild(createPage);
            div.appendChild(createPageLabel);
            div.appendChild(changeSetting);
            div.appendChild(changeSettingLabel);
            div.appendChild(changeAccount);
            div.appendChild(changeAccountLabel);
            if(el.delete == null) div.appendChild(deleteBtn);

            return div;
    }

    //wysyła dane do zaktualizowania na serwer
    sendData(id, el, value){
        this.messageWindow.show(this.lang.message_sending);

        $.ajax({
            url: `${this.url}panel/changeUser`,
            method: 'POST',
            data: {iduser: id, element: el, value: value}
        }).done((res)=>{
            this.messageWindow.done(this.lang.message_sending_ok);
        }).fail((res)=>{
            this.messageWindow.alert(this.lang.message_error);
        })
    }
}