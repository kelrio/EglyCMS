class Layout{
    constructor(data, selector, url, messageWindow, lang){
        this.data = JSON.parse(data);
        this.selector = selector;
        this.url = url;
        this.messageWindow = messageWindow;
        this.allStyle; //przechowuje wszystkie style tylko do podglądu
        this.lang = lang;

        console.log(this.lang);

        this.fileName; //przechowuje h3 z nazwą edytowanego pliku

        this.ace; //edytor treści dla css
        this.containerOptions; //kontener na opcje dostepych styli jeśli wybrane style użytkownika
        this.exampleView; //kontener na przyklladowy widok

        this.downloadAllStyle();
        this.createSelect();
    }

    //tworzy wiersz z wyborem stylu css
    createSelect(){
        var div = document.createElement('div');

        var p = document.createElement('p');
        p.innerText = this.lang.layout_active_style;
        div.appendChild(p);

        var select = document.createElement('select');
        select.id = 'selectStyle';
        div.appendChild(select);

        select.addEventListener('change', this.sendChange.bind(this));

        var rowData = this.data['options'].split('|');
        rowData.forEach((el) => {
            var option = document.createElement('option');
            option.value = el;
            option.innerText = el;

            if(this.data['value'] = el){
                option.selected = 'selected';
            }

            select.appendChild(option);
        });
        this.selector.appendChild(div);

        //utworzenie przykładowego widoku strony
        this.exampleViews()

        //jeśli wybrany styl to styl użytkownika to wywołaj nowe menu
        if(this.data['value'] == 'userView') {this.optionsStyle();}
    }

    //edytor styli użytkownika
    optionsStyle(){
        this.containerOptions = (!this.containerOptions) ? document.createElement('div') : this.containerOptions;
        this.containerOptions.classList.add('options');

        this.selector.insertBefore(this.containerOptions, this.exampleView);

        //tworzenie opcji edycji styli css
        var optionTab = ['header', 'menu', 'body', 'footer'];
        var divOptions = document.createElement('div');
        
        //tworzenie opcji dla selecta
        optionTab.forEach((el)=>{
            var button = document.createElement('button');
            button.innerText = el;
            button.value = el;

            button.addEventListener('click', this.downloadStyle.bind(this));

            divOptions.appendChild(button);
        })

        //dodanie opcji do głwnego kontenera
        this.containerOptions.appendChild(divOptions);

        //utworzenie podnagłwka z nazwą edytowanego pliku
        var filenameContainer = document.createElement('div');
        filenameContainer.style.display = 'flex';

        this.fileName = document.createElement('h3');
        this.fileName.innerText = this.lang.layout_not_selected_file;
        this.containerOptions.appendChild(filenameContainer);

        filenameContainer.appendChild(this.fileName);

        //ikonka zapisu zimenionych treści
        var imgContainer = document.createElement('div');
        imgContainer.style.display = 'flex';
        //imgContainer.style.justifyContent = 'flex-end';
        filenameContainer.appendChild(imgContainer);

        var imgSave = new Image();
        imgSave.style.maxHeight = '32px';
        imgSave.style.margin = '16px';
        imgSave.src = `${this.url}media/img/save-icon.png`;
        imgSave.addEventListener('load', (e)=>{
            imgContainer.appendChild(imgSave);
        })

        imgSave.addEventListener('click', this.uploadStyle.bind(this));

        //utworzenie edytora treści
        var aceContainer = document.createElement('div');
        aceContainer.id = 'jsEditor';

        this.containerOptions.appendChild(aceContainer);

        //utworzenie edytora ace z opcjami dostosowanymi do css'a
        this.ace = ace.edit('jsEditor', {
            mode: "ace/mode/css",
            selectionStyle: "text"
        })

        //zdarzenie zmiany wartości
        this.ace.on('change', (e)=>{
            var code = '';

            if(this.allStyle != null){
                switch(this.fileName.innerText){
                    case 'body.css': code = `${this.ace.getValue()}${this.allStyle.header}${this.allStyle.menu}${this.allStyle.footer}`; this.changeDisplayStyle(code); break;
                    case 'footer.css': code = `${this.allStyle.body}${this.allStyle.header}${this.allStyle.menu}${this.ace.getValue()}`; this.changeDisplayStyle(code); break;
                    case 'header.css': code = `${this.allStyle.body}${this.ace.getValue()}${this.allStyle.menu}${this.allStyle.footer}`; this.changeDisplayStyle(code); break;
                    case 'menu.css': code = `${this.allStyle.body}${this.allStyle.header}${this.ace.getValue()}${this.allStyle.footer}`; this.changeDisplayStyle(code); break;
                }
            }
        })

    }

    //zapisanie utworzonego stylu na serwerze
    uploadStyle(e){
        this.messageWindow.show(this.lang.message_sending_file)
        $.ajax({
            url: `${this.url}panel/uploadStyle`,
            method: 'POST',
            data: {nameFile: e.target.parentElement.parentElement.firstElementChild.innerText, content: this.ace.getValue()}
        }).done((res)=>{

            console.log(res);
            this.messageWindow.done(this.lang.message_sending_ok);
        })
    }

    //pobranie danego stylu
    downloadStyle(e){
        this.messageWindow.show(this.lang.message_downloading_file)
        console.log(e.target.value);
        $.ajax({
            url: `${this.url}panel/downloadStyle`,
            method: 'POST',
            data: {nameFile: e.target.value}
        }).done((res)=>{
            this.ace.setValue(res, -1);

            console.log(res);

            this.fileName.innerText = `${e.target.value}.css`;
            this.messageWindow.done(this.lang.message_downloading_file_ok);
        })
    }


    //zapisanie ktory styl został ustawiony na głowny styl do wyświetlenia rezultatow
    sendChange(e){
        this.messageWindow.show(this.lang.message_sending);
        var id = this.data['idsetting'];
        var value = e.target.value;

        console.log(id, value);

        $.ajax({
            url: `${this.url}panel/changeValue_setting`,
            method: 'POST',
            data: {idsetting: id, value: value}
        }).done((res)=>{
            console.log(res);
            this.messageWindow.done(this.lang.message_sending_ok);
            this.data['value'] = value;

            if(this.data['value'] == 'userView') {this.optionsStyle();}else{this.containerOptions.remove(); this.containerOptions = null;}
        })
    }

    //generowanie podglądowego wyglądu strony
    exampleViews(){

        var button = document.createElement('button');
        button.innerText = this.lang.layout_button_example_view;
        button.addEventListener('click', (e)=>{
            var windowWidth = screen.width - 10;
            var windowHeight = screen.height - 10;
            const newWindow = window.open(`${this.url}Home/example`, 'tytul-okna', `toolbar=0,menubar=0,scrollbars=0,resizable=0,status=0,location=0,directories=0,top=0,left=0,height=${windowHeight},width=${windowWidth}`);
        })

        this.selector.appendChild(button);

        // this.exampleCode = `<label id='exampleViewLabel' ><nav id="menu"><ul><li><a href="#exampleViewLabel">Strona główna</a><ul></ul></li><li><a href="#exampleViewLabel">strona 1</a><ul><li><a href="#exampleViewLabel">podstrona</a></li></ul></li><li><a href="#exampleViewLabel">O nas</a><ul></ul></li><li><a href="#exampleViewLabel">examplePage</a><ul></ul></li><div class="panel"><a href="#exampleViewLabel">Panel</a></div></ul></nav>
        // <header><h1>examplePage</h1></header>
        // <article id="article">
        // <section><p class="ql-align-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque id ante at pretium. Nullam sed ligula ac dolor suscipit egestas ac quis nisi. Vivamus et dui tempor lectus imperdiet accumsan faucibus quis ligula. Nunc sit amet mauris nisl. Suspendisse accumsan tincidunt ex at ultrices. Fusce viverra mi et sem faucibus lacinia. Aenean maximus augue at ante porta fermentum. Pellentesque eget dignissim sapien, eget viverra velit. Quisque porttitor, elit vitae pulvinar faucibus, dui est aliquam mi, eget commodo lorem justo et quam.</p><p class="ql-align-justify">Maecenas viverra tincidunt nisi mattis scelerisque. Nunc ac pretium orci, a molestie metus. Pellentesque a ligula nec est lacinia dictum in ut justo. Fusce sit amet placerat nulla, elementum ornare neque. In fermentum sed est sit amet iaculis. Curabitur eget sem efficitur, commodo nibh sed, finibus augue. Vestibulum quis aliquam turpis. Nunc convallis dui vel ante ultricies, ut congue nisi imperdiet. Donec eleifend molestie turpis ut blandit. Aenean id lectus a turpis efficitur molestie sit amet vitae dui. Phasellus maximus eu elit in tincidunt. Proin vitae sem in sapien efficitur convallis.</p><p class="ql-align-justify">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean posuere orci at feugiat tempus. Aliquam magna est, rutrum id tempor nec, vestibulum sit amet mauris. Morbi libero neque, efficitur ac efficitur non, varius et nisl. Praesent efficitur tincidunt mi id aliquam. Pellentesque fringilla, elit a placerat molestie, est mauris convallis odio, quis pretium risus enim at nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis faucibus dui, ac molestie odio. Mauris tempor mauris sed erat vehicula tincidunt. Mauris imperdiet ut arcu ac lobortis. Nam sollicitudin nisl nibh, ac posuere purus faucibus et. Fusce sagittis purus non enim tincidunt imperdiet. Quisque at feugiat ex. Pellentesque a diam a lacus pulvinar faucibus. Quisque condimentum ut purus at imperdiet.</p><p><br></p></section><section>
        // <div class="imageContainer"><img src="${this.url}media/img/examplePicture.jpg"></div><div class="imageDescription"><p>Warsaw</p></div></section></article>
        // <footer></footer>`;

        // this.exampleView = document.createElement('iframe');
        //this.exampleView.classList.add('example');
        //this.selector.appendChild(this.exampleView);

        // this.exampleView.src = this.url;

    }

    //pobiera wszystkie style stworzone przez użytkonika
    downloadAllStyle(){
        this.messageWindow.show(this.lang.message_sending);

        $.ajax({
            url: `${this.url}panel/downloadAllStyle`,
            method: 'POST',
            data: {}
        }).done((res)=>{

            this.allStyle = JSON.parse(res);
            this.messageWindow.done(this.lang.message_sending_ok);

            console.log(this.allStyle);


            this.changeDisplayStyle(`${this.allStyle.body}${this.allStyle.header}${this.allStyle.menu}${this.allStyle.footer}`);
        })
    }

    changeDisplayStyle(code){

        localStorage.setItem('style', JSON.stringify(code));

    }
}