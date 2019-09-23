/**
 * klasa obsługująca planszę do genertowania treści strony
 */
class Board{
    constructor(selector, url, dragAndDrop, __modalWindow, idMenuElement, elementsOnPage, messageWindow, lang){
        this.selector = selector;
        this.url = url;
        this.dragAndDrop = dragAndDrop;
        this.__modalWindow = __modalWindow;
        this.idMenuElement = idMenuElement; //id strony
        this.elementsOnPage =  elementsOnPage; //elementy załadowane z bazy dla daje podstrony
        this.selectedImage; //jaki obrazek został wybrany
        this.messageWindow = messageWindow; //klasa wyświeltająca komunikaty
        this.lang = lang;

        console.log(this.lang);

        this.allImages = []; //przechouje wszystkie obrazki uplodowane przez użytkownika {id - identyfikator bazy danych, name - nazwa użytkownika, code - base64 bez nagłwnka, type - rozszerzenie pliku}

        this.quill = []; //przechowuje wszystkie edytory tekstowe
        this.ace = []; //przechowuje wszystkie edytory kodow

        this.elTab = []; //układ wszystkich elementow na tablicy

        this.generateBoard();
        this.downloadImage();

    }
    /**
     * metoda generująca planszę do tworzenia treści strony
     */
    generateBoard(){
        var container = document.createElement('div');
            container.classList.add('container');

        var board = this.createEmptyBoard();

        container.appendChild(board);
        this.selector.appendChild(container);
        //console.log(board);
    }

    /**
     * pobiera z serwera wszystkie pliki graficzne uplodowane przez użytkkownika
     * pojedyńcze pobranie ogranicza ruch sieciowy niż gdyby wszystkie obrazki miały być pobiera za każdym 
     * uruchomieniem okienka modalnego
     */
    downloadImage(){
        this.messageWindow.show(this.lang.message_sending)

        $.ajax({
            url: this.url+'panel/getImages',
            type: 'POST'
        })
        .done((res)=>{
            //console.log(JSON.parse(res));
            this.allImages = JSON.parse(res);

            var imageContainer = document.getElementsByClassName('imageContainer')[0];
            if(imageContainer){
                this.allImages.forEach((element)=>{
                    imageContainer.appendChild(this.generateImage(element));
                })
            }

            var mainElement = document.getElementsByClassName('board')[0];
            //console.log(mainElement);
            this.elementsOnPage.forEach((el, index)=>{
                this.generateElement(el.type, mainElement, el);
                ////console.log(el);
            })
            
            //poinformowanie o zakończeniu ładowania
            this.messageWindow.done(this.lang.message_sending_ok);

        })
    }

    /**
     * Tworzy nowe elementy w najechanym elemencie
     * @param {*} data wartość wskazująca na to jaki elelement ma zostać utworzony
     * @param {*} selector jest to selektor do ktrego ma zostać wstawiony nowy element
     */
    generateElement(data, selector, returnElement = null){

        var obiect = document.createElement('div');
            obiect.classList.add('attr');
            obiect.classList.add(data);

        // //console.log(obiect);
        var board = this.createEmptyBoard();

        //kontener z ikonką do zamiany pozycji elementu
        var move = document.createElement('div');
            move.classList.add('moveContainer');

        var moveImage = document.createElement('img');
            moveImage.src = `${this.url}media/img/icon-move.png`;

        move.appendChild(moveImage);
        move.addEventListener('click', (e)=>{});

        //kontener z ikonką do usuwania elementu
        var trash = document.createElement('div');
            trash.classList.add('trashContainer');

        var trashImage = document.createElement('img');
            trashImage.src = `${this.url}media/img/icon-trash.png`;

        trash.appendChild(trashImage);
        trash.addEventListener('click', (e)=>{
            //usunięcie danych z bazy daych - pobranie niezbednych informacji
            var idElement = e.target.parentElement.parentElement.id;
            var typeElement = (e.target.parentElement.parentElement.classList.contains('image')) ? 'image' : 'text';

            $.ajax({
                url: this.url+'panel/removeElementsWithPanel',
                method: 'POST',
                data: {id: idElement, type: typeElement}
            })
            .done((res)=>{
                console.log(res);
                this.setElementsToTabs(selector.parentNode);
                obiect.nextElementSibling.remove();
                obiect.remove();
            })
        })
        
        obiect.addEventListener('mouseenter', (e)=>{
            if(obiect.firstElementChild.classList.contains('modalWindow') == false){
                obiect.appendChild(trash);
                obiect.appendChild(move);

                if(obiect.classList.contains('text') == false){
                    trash.style.top = `${obiect.offsetTop - 15}px`;
                    trash.style.left = `${obiect.offsetLeft + obiect.clientWidth - 22}px`;

                    move.style.top = `${obiect.offsetTop + 17}px`;
                    move.style.left = `${obiect.offsetLeft + obiect.clientWidth - 22}px`;
                }
            }
        })
        obiect.addEventListener('mouseleave', (e)=>{
            trash.remove();
            move.remove();
        })

        selector.parentNode.insertBefore(board, selector);
        selector.parentNode.insertBefore(obiect, selector);

        //console.log(returnElement);
        if(returnElement.content){
            if(returnElement.content.substr(0, 4) != 'ACE_'){
                switch (data){
                    case 'text':
                        var el = this.createTextArea(obiect, (returnElement) ? returnElement.id : null, (returnElement) ? returnElement.content : null);
                        break;
                    case 'rows':
                        this.createRows(obiect);
                        break;
                }
            }else{
                /**
                 * w tym miejscu skrpyt zczytywało jako zwykły tekst i dodawało go do quilla to były problemy z generowaniem kodow
                 * dlatego w tym miejscy następuje podmiana nazw klasy z text na script
                 */
                obiect.classList.remove('text');
                obiect.classList.add('script');
                var el = this.createScript(obiect, (returnElement) ? returnElement.id : null, (returnElement) ? returnElement.content.slice(4) : null)
            }
        }else{
            var el = this.createImage(obiect, (returnElement) ? returnElement : null);
        }

        // this.setElementsToTabs();
    }

    /**
     * tworzenie pustego elementu do upuszczania na nim elementu
     */
    createEmptyBoard(){
        var board = document.createElement('div');
            board.classList.add('board');

        if(CheckDisplay.getDisplay() == 'mouse'){
            board.addEventListener('dragover', (e)=>{
                this.dragAndDrop.allowDrop(e);
            })
            board.addEventListener('drop', (e)=>{
                this.dragAndDrop.drop(e);
            })
        }else{
            board.addEventListener('touchend', (e)=>{
                //console.log('zkonczono na elemencie');
            })
            board.addEventListener('touchmove', (e)=>{
                //console.log('dupa');
            })
        }
        return board;
    }
    /**
     * Metoda tworzy edytor html i innych w przeglądarce przy pomocy biblioteki Ace.js
     * @param {*} el 
     * @param {*} _id 
     * @param {*} content 
     */
    createScript(el, _id = null, content = null){

        //wygenerowanie elementu
        var div = document.createElement('div');
        div.classList.add('jsEditor');
        //div.innerText = content;

        //wpisanie zawartości pobranej z bazy danych do kontenera i przypisanie istniejącego id
        el.id = (_id) ? _id : 'null';

        el.appendChild(div);
        //dodatnie obsługi ACE Editor
        var index = this.ace.length;
        div.alt = index;
        div.id = `jsEditor${index}`;
        this.ace.push(ace.edit(`jsEditor${index}`, {
            mode: "ace/mode/html",
            selectionStyle: "text"
        }));

        if(content){
            //console.log(content);
            this.ace[index].setValue(unescape(content), 0);
            //this.ace[index].setValue("Hello world", -1);
            //console.log(this.ace[index].getValue());
        }

        this.ace[index].on('blur', (e)=>{
            this.setElementsToTabs(el);

            //tak wygląda pobieranie konkretnej wartości z edytora ace
            ////console.log(this.ace[index].getValue());
        })

        this.setElementsToTabs(el);

        return el;
    }

    /**
     * metoda tworząca textaree do wprowadzania tekstu
     * @param {*} el selektor do ktrego ma zostać dodany nowy element
     */
    createTextArea(el, _id = null, content = null){
        var toolbarOptions = [
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'font': [] }],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            ['clean']                                         // remove formatting button
          ];

        var index = this.quill.length;
        this.quill.push(new Quill(el, {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'bubble'
        }))
        
        this.quill[index].on('selection-change', (delta, oldDelta, source) => {
            if (source == 'api') {
                //console.log("An API call triggered this change.");
            } else if (source == 'user') {
                this.setElementsToTabs(el);
            }
        });

        el.id = (_id) ? _id : 'null';
        if(content){
            el.firstElementChild.innerHTML = content;
        }

        this.setElementsToTabs(el);
        return el;
    }

    /**
     * Generuje obrazek z kody base64
     * @param {id, name, code, type} obiect id - identyfikator z bazy danych, name - nazwa użytkownika, code - kod base64 obrazka, typ - rozszerzenie pliku
     */
    generateImage({id, name, code, type}){

        var img = document.createElement('img');
            img.src = `data:image/${type};base64, ${code}`;
            img.alt = name;
            img.addEventListener('click',(e)=>{

                //usuwanie zaznaczenia z innych elementow
                var selected = document.getElementsByClassName('selected');
                if(selected.length != 0){
                    for(var i = 0; i < selected.length; i++){
                        selected[i].classList.remove('selected');
                    }
                }
                this.selectedImage = e.target.alt;
                img.classList.add('selected');
            });

        var container = document.createElement('div');
            container.classList.add('imgContainer');
            container.appendChild(img);
        
        return container;
    }


    /**
     * Dodaje zdjęcie do obiektu, działa trochę inaczej niż text, najpierw tworzy okienko do zarządzania zdjęciami, następnie
     * wybieramy zdjęcie/obrazek/obrazki, zatwierdzamy, następnie obrazek zostaje dodany do trony bądź generuje galerię zdjęć
     * w zależności od tego czy wybrano jeden plik graficzny czy kilka
     * @param {*} el 
     */
    createImage(el, _select = null){
        //console.log('=======================================');
        //console.log(_select);
        //console.log('=======================================')

        el.id = (_select) ? _select.id : 'null';
        //przechowuje wybrane zdjęcie, ktre ma zostać zwrocone
        var selectedImage;

        if(!_select){
            var modal = this.__modalWindow.createModal();
            el.appendChild(modal.modal);
            
            //doprogramowanie zamykania okienka
            modal.modalExit.addEventListener('click', (e)=>{
                el.nextElementSibling.remove();
                el.remove();
            })

            //kontener na upload plikow
            var uploadImageContainer = document.createElement('div');
                uploadImageContainer.classList.add('uploadImageContainer');
            
            //kontener na istniejące obrazki użytkownika
            var allImageContainer = document.createElement('div');
                allImageContainer.classList.add('imageContainer');

                this.allImages.forEach((element) => {
                    //console.log('wywolalo');
                    allImageContainer.appendChild(this.generateImage(element));
                })
            
            //input od uploadu plikow
            var uploadImage = document.createElement('input');
                uploadImage.type = 'file';
                uploadImage.multiple = true;
                uploadImage.name = 'file';
                uploadImage.id = 'file';
                uploadImage.accept = 'image/jpeg, image/jpg, image/png, image/gif';
                uploadImage.classList.add('uploadFile');
                uploadImage.addEventListener('change', (e)=>{

                    //odczytywanie kodu url obrazkow, dziala na file multiple
                    if(FileReader){
                        var images = e.target.files;
                        //console.dir(images);


                        for(var i = 0; i < images.length; i++){
                            var file = images[i];

                            var reader = new FileReader();

                            reader.onload = (ev)=>{
                                var picFile = ev.target;

                                    //console.log(file);

                                    $.ajax({
                                        url: this.url+'panel/editPage_saveFile',
                                        method: 'POST',
                                        data: {url: picFile.result},
                                    })
                                    .done((res)=>{
                                        var result = JSON.parse(res);
                                        //console.log(result);

                                        if(result.code != null){
                                            var selector =  this.generateImage({id: result.id, name: result.name, code: result.code, type: result.type});
                                            allImageContainer.appendChild(selector);
                                            this.allImages = [...this.allImages, {id: result.id, name: result.name, code: result.code, type: result.type}]
                                        }
                                    });
                            }
                            reader.readAsDataURL(file);
                        }
                    }   
                })
            
            //label dla uploadu plikow
            var uploadImageIcon = document.createElement('img');
                uploadImageIcon.src = `${this.url}media/img/image-upload.png`;
            var labelUploadImage = document.createElement('label');
                labelUploadImage.htmlFor = 'file';
            var uploadImageP = document.createElement('span');
                uploadImageP.innerText = this.lang.editPage_modal_upload_file;

                labelUploadImage.appendChild(uploadImageIcon);
                labelUploadImage.appendChild(uploadImageP);

                uploadImageContainer.appendChild(uploadImage);
                uploadImageContainer.appendChild(labelUploadImage);

            var buttonAcceptImage = document.createElement('button');
                buttonAcceptImage.innerText = this.lang.editPage_modal_add_picture;
                buttonAcceptImage.addEventListener('click', (e)=>{
                    var image = insertPictureIntoTheBoard(this.allImages, this.selectedImage, el, this.lang);
                    image.firstElementChild.lastElementChild.firstElementChild.addEventListener('change', (e)=>{
                        this.setElementsToTabs(el);
                    })
                    el.firstElementChild.remove(); 
                    this.setElementsToTabs(el);
                })

            //ustawienie zawartości body w okienku modal
            this.__modalWindow.setBody(modal.body, uploadImageContainer, allImageContainer);
            this.__modalWindow.setFooter(modal.footer, buttonAcceptImage);
        }else{
            var image = insertPictureIntoTheBoard(this.allImages, _select.imageName, el, this.lang, _select.description);
            //console.log('======================\n=================\n==============')
            //console.dir(image);
                image.firstElementChild.lastElementChild.firstElementChild.addEventListener('blur', (e)=>{
                    this.setElementsToTabs(el);
                })
        }

        //służy do wstawiania obrazka do panelu poprzez wybod obrazka z tablicy wybierany poprzez nazwę pliku
        function insertPictureIntoTheBoard(tabImage, _selectedImage, el, lang, description = null){

                const findImage = tabImage.find(function(el) {
                    return el.name == _selectedImage;
                });

                //console.log({tabImage, _selectedImage});

                /**
                 * Wstawianie obrazka do tablicy
                 */
                selectedImage = document.createElement('img');
                selectedImage.src = `data:image/${findImage.type};base64, ${findImage.code}`
                selectedImage.alt = findImage.name;


                var newLine = document.createElement('div');
                var newLine2 = newLine.cloneNode(true);

                //kontener przechowujący obrazek i jego opis
                var imageContainer = document.createElement('div');
                    imageContainer.classList.add('imageContainer');

                //input do wstawiania opisu elementu
                var inputDescriptionImage = document.createElement('input');
                    inputDescriptionImage.type = 'text';
                    inputDescriptionImage.placeholder = lang.editPage_picture_description;
                    inputDescriptionImage.id = findImage.name;
                    inputDescriptionImage.value = description;
                    inputDescriptionImage.autocomplete = 'off';

                newLine.appendChild(selectedImage);
                newLine2.appendChild(inputDescriptionImage);
                imageContainer.appendChild(newLine);
                imageContainer.appendChild(newLine2);

                //podmiana okna modalnego na obrazek w kontenerze
                el.appendChild(imageContainer);

                return el;
        }
    }

    /**
     * tworzenie dwoch kolumn
     * @param {*} el 
     */
    createCols(el){
        var col = document.createElement('div');
            col.classList.add('attr');
            col.classList.add('table');
            col.classList.add('col-1-2');
            col.appendChild(this.createEmptyBoard());

        var col2 = document.createElement('div');
            col2.classList.add('attr');
            col2.classList.add('table');
            col2.classList.add('col-1-2');
            col2.appendChild(this.createEmptyBoard());

        el.appendChild(col);
        el.appendChild(col2);

        this.setElementsToTabs(el);
    }

    createRows(el){
        var row = document.createElement('div');
            row.classList.add('attr');
            row.classList.add('table');
            row.classList.add('row');
            row.appendChild(this.createEmptyBoard());
            
        el.appendChild(row);
    }

    /**
     * generowanie tablicy elementow do zapisu i odczytu
     */

    setElementsToTabs( selector){

        //blokowanie ekranu dla wprowadzania nowych danych
        const blockedWindow = document.createElement('div');
        blockedWindow.classList.add('blockedWindow');
        //this.selector.appendChild(blockedWindow);
        
        this.messageWindow.show(this.lang.message_editPage_save_change)
        //console.dir(selector);
        var element = [...selector.parentNode.children];
        // //console.log(element);
        
        var page = [];
        var cuteElement = [];

        element.forEach(el => {
            if(!el.classList.contains('board')){
                //dodawanie tekstu do wysyłki na serwer
                if(el.classList.contains('text')){
                    //pobieranie elementow z quilla i tworzenie z niego tekstu html do zapisu w bazie
                    var elTab = [...el.firstElementChild.children];
                    var tekst = '';

                    elTab.forEach(el => {
                        tekst += el.outerHTML;
                    })
                    cuteElement = [...cuteElement, el];
                    page = [...page, {type: 'text', description: tekst, idElement: (el.id != 'null') ? el.id : 'null'}];
                }

                //dodawanie obrazka do wysyłki na serwer
                if(el.classList.contains('image')){
                    cuteElement = [...cuteElement, el];
                    page = [...page, {type: 'image', idElement: (el.id != 'null') ? el.id: 'null', imageName: el.firstElementChild.firstElementChild.firstElementChild.alt, description: el.firstElementChild.lastElementChild.firstElementChild.value}];
                }

                //dodawanie skryptu do wysyłki ma serwer
                if(el.classList.contains('script')){
                    //pobieranie elementow z ace i tworzenie z niego tekstu html do zapisu w bazie
                    var elTab = [...el.firstElementChild.children];

                    var counterAce = el.firstElementChild.alt;

                    var tekst = this.ace[counterAce].getValue();
                    tekst = `ACE_${escape(tekst)}`;

                    //console.log('=========', tekst, this.ace[counterAce].getValue());

                    cuteElement = [...cuteElement, el];
                    page = [...page, {type: 'text', description: tekst, idElement: (el.id != 'null') ? el.id : 'null'}];
                }
            }
        })

        //console.dir({page, cuteElement});

        
        $.ajax({
            url: this.url+'panel/createElementsWithPanel',
            method: 'POST',
            data: {data: JSON.stringify(page), idPage: this.idMenuElement},
        })
        .done((res)=>{
            var debuger = 1;

            if(debuger == 0){
                //console.log(res);
            }else{
                //console.log(res);
                var result = JSON.parse(res);
                //console.log(result);

                for(var i = 0; i < result.length; i++){
                    //console.log({result, cuteElement, i});
                    cuteElement[i].id = (cuteElement[i].id == 'null') ? result[i]['id'] : cuteElement[i].id;
                }
            }
            
            this.messageWindow.done(this.lang.message_sending_ok);
            blockedWindow.remove();
        });

        // this.elTab.push({
        //     id: this.elTab.length + 1,
        //     //obiect: obiect,
        //     subelement: selector
        // });
        //var container = [...this.selector.children[1].children]; //konwersja obiektu HTMLcollection do tablicy
        ////console.dir(container);
    }

    test(){
        var counterAce = 0;

        //console.log(this.ace[0].getValue());
    }
}