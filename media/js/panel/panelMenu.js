/**
 * Klasa do generowania elementw menu po pobraniu ich z bazy danych. Dane są przekazywane z modelu PanelMenu_model
 * następnym parametrem jest selektor, do ktrego mają zostać wstawione nowe elementu menu
 * url odnosi się do bazowego adresu serwera
 */
class Menu{
    constructor(json, selector, url, messageWindow, lang){
        this.elements = [];
        this.selector = selector;
        this.url = url;
        this.lang = lang;
        this.messageWindow = messageWindow;

        this.container;

        this.decode(json);
        this.createSelector();
    }

    decode(json){
        this.elements = JSON.parse(json);
    }

    /**
     * Służy do tworzenia i dodawania do drzewa DOOM inputow do operowania na elementach menu
     */
    createSelector(){
        /**
         * Generowanie elementow na podstawie istniejących elementow z bazy danych
         */
        var el = document.createElement('div');
            el.classList.add('element');
        var col = document.createElement('div');
            col.classList.add('col');

        for(var i = 0; i < this.elements.length; i++){
            if(this.elements[i].subelement == null){
                var input = document.createElement('input');
                    input.type = 'text';
                    input.value = this.elements[i].name;
                    input.id = this.elements[i].idmenu;
                    input.addEventListener('focus', (e)=>{
                        this.changeElementFocus(e);
                    })
                    input.addEventListener('blur', (e)=>{
                        this.changeElementBlur(e);
                    })


                var newEl = el.cloneNode(true);
                    newEl.classList.add('exist');  
                newEl.appendChild(input);

                var newCol = col.cloneNode(true);
                    newCol.appendChild(newEl);

                //dodawanie pustego elementu do dodania do kolumny
                var newElAdd = el.cloneNode(true)
                    newElAdd.classList.add('notexist')
                    newElAdd.appendChild(this.addNewEmptyElement(this.elements[i].idmenu))

                    newCol.appendChild(newElAdd);
                
                this.selector.appendChild(newCol);
            }else{
                //jeśłi dany element jest podelementem menu
                var id = this.elements[i].subelement;
                var elDef = document.getElementById(id);
                    elDef = elDef.parentNode.parentNode;
                
                var input = document.createElement('input');
                    input.type = 'text';
                    input.value = this.elements[i].name;
                    input.id = this.elements[i].idmenu;
                    input.addEventListener('focus', (e)=>{
                        this.changeElementFocus(e);
                    })
                    input.addEventListener('blur', (e)=>{
                        this.changeElementBlur(e);
                    })
                
                var newEl = el.cloneNode(true);
                    newEl.classList.add('exist');
                    newEl.appendChild(input);

                //zamiana miejscami z pustym elementem do dodania
                var prevEl = elDef.lastChild;
                if(prevEl.classList.contains('notexist')){
                    elDef.insertBefore(newEl, prevEl);
                }

            }
        }
        /**
         * Tworzenie elementu do dodawania nowego elementu menu
         * Do elementu menu dodawany jest input do dodania nowego elementu
         * nastęnie element dostaje klasę notexist i jest dodawany do kolumny
         * ktra jest dodawana do głnego selektora
         */
        el.appendChild(this.addNewEmptyElement());
        el.classList.add('notexist');
        col.appendChild(el);
        this.selector.appendChild(col);
        
    }
    /**
     * Metoda dodaje pusty element, służący do dodawania elementu menu
     */
    addNewEmptyElement(id = null){

        var input = document.createElement('input');
            input.type = 'text';
            input.placeholder = this.lang.text_add_new_menu_el;
            input.addEventListener('blur', (e)=>{
                this.addElementBlur(e, id);
            }) 

        return input;

    }
    /**
     * metoda zdarzenia dla zmiany elementu menu dla zdarzenia aktywacji elementu input
     * Tworzenie ikonki usuwającej dany element
     */
    changeElementFocus(e){
        this.container = e.target.value.trim();
        console.dir(e.target);

        var closeElement = document.createElement('div');
            closeElement.classList.add('close-wrap');
        var icon = document.createElement('button');
            icon.classList.add('close');
            icon.innerHTML = '&times';
            /**
             * usuwanie elementu menu
             */
            icon.addEventListener('mousedown', (e)=>{
                //pobieranie id głnego elementu i pobieranie jego pozycji w tablicy elementow   
                var id = e.target.parentNode.parentNode.firstChild.id;
                var index = this.elements.find(function(el) {
                    return el.idmenu == id
                });

                var indexElement = this.elements.indexOf(index);
                if(confirm(this.lang.text_confirm_delete_element)){
                    //usuwanie wszystkich elementw posiadających id jako subelement
                    var elementsToDelete = [];
                    for(var i = 0; i < this.elements.length; i++){//zbieranie elementow, ktore trzeba usunąć
                        if(this.elements[i].subelement == id){
                            elementsToDelete.unshift(i)
                        }
                    }
                    elementsToDelete.forEach((item)=>{//usuwanie elementow z głownej tablicy
                        this.elements.splice(item, 1);
                    })

                    this.messageWindow.show(this.lang.message_sending);

                    $.ajax({
                        url: this.url + 'panel/deleteMenuElement',
                        type: 'POST',
                        data: { id: index.idmenu,
                                name: this.container
                            },
                    })
                    .done((res)=>{
                        console.log(res);
                        if(res == 1){
                            this.messageWindow.done(this.lang.message_sending_ok)
                            this.elements.splice(indexElement, 1);
                            console.log(this.elements);
                            this.reload();
                        }
                    })
                }
                

                console.log(index.idmenu)
            })
            
            closeElement.appendChild(icon);
        
        e.target.parentNode.appendChild(closeElement)
    }
    /**
     * metoda zdarzenia dla zmiany nazwy elementu menu dla zdarzenia deaktywacji elementu input
     */
    changeElementBlur(e){
        //var index = $(e.target).parent().index() + 1;
        var index = e.target.id;
        if(e.target.value.trim() != this.container){

            this.messageWindow.show(this.lang.message_sending);

            $.ajax({
                url: this.url+'panel/renameMenuElements',
                type: 'POST',
                data: {id: index, name: e.target.value.trim(), valueControl: this.container},
            })
            .done((res)=>{
                console.log(res);
                if(res == 1){
                    //odszukanie elementu w tablicy menu
                    const findElement = this.elements.find((el)=>{
                        return el.name == this.container;
                    });
                    //zmiana jego nazwy w tablicy elementow
                    findElement.name = e.target.value.trim();
                    this.messageWindow.done(this.lang.message_sending_ok);
                }
            })
        }

        e.target.parentNode.lastElementChild.remove();
    }
    /**
     * metoda zdarzenia dla deaktywacji tworzenia nowego elementu menu
     */
    addElementBlur(e, id){
        if(e.target.value != ''){
            this.messageWindow.show(this.lang.message_sending);

            $.ajax({
                url: this.url + 'panel/addMenuElements',
                type: 'POST',
                data: {name: e.target.value.trim(), subelement: id},
            })
            .done((res)=>{
                //console.log(res);
                console.log(id);
                this.elements.push({idmenu: res, name: e.target.value, subelement: id});
                
                this.messageWindow.done(this.lang.message_sending_ok);

                this.reload();
            })
        }
    }
    /**
     * metoda do ponownego załądowania elementow menu
     */
    reload(){
        this.selector.innerHTML = '';
        this.createSelector();
    }

    // nieistotne, testowane było połączenie z kontrolerem
    send(url, data){
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
        })
        .done(function(res){
            console.log(res)
        })
    }
}