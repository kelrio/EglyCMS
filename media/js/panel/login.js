class Login{
    constructor(selector, url, messageWindow, lang){
        this.url = url;
        this.selector = selector;
        this.messageWindow = messageWindow;
        this.lang = lang;

        this.createLoginForm();
    }

    createLoginForm(){
        var loginDiv = document.createElement('div');
        var login = document.createElement('input');
        login.type = 'text';
        login.placeholder = this.lang.login_login;
        loginDiv.appendChild(login);

        var passwordDiv = document.createElement('div');
        var password = document.createElement('input');
        password.type = 'password';
        password.placeholder = this.lang.login_password;
        passwordDiv.appendChild(password);

        var loginBtn = document.createElement('button');
        loginBtn.innerText = this.lang.login_button_logining;
        loginBtn.addEventListener('click', this.loginig.bind(this));

        this.selector.appendChild(loginDiv);
        this.selector.appendChild(passwordDiv);
        this.selector.appendChild(loginBtn);
    }

    loginig(e){
        this.messageWindow.show(this.lang.message_logining);

        console.dir(e.target);

        var login = e.target.parentElement.children[0].firstChild.value;
        var password = e.target.parentElement.children[1].firstChild.value;

        $.ajax({
            url: `${this.url}panel/logining`,
            method: 'POST',
            data: {login: login, password: password}
        }).done((res)=>{
            console.log(res);

            if(res == 'ok'){
                this.messageWindow.done(this.lang.message_logining_ok);

                setTimeout(() => {
                    window.location.href = `${this.url}panel`;
                }, 300);
            }else{
                if(res == 'login'){
                    this.messageWindow.alert(this.lang.message_account_doesnt_exist);
                }else if(res == 'password'){
                    this.messageWindow.alert(this.lang.message_password_incorrect);
                }else{
                    this.messageWindow.alert(this.lang.message_logining_error);
                }
            }
        })
    }
}