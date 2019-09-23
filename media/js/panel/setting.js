class Setting{
    constructor(arraySetting, selector, messageWindow, lang){
        this.arraySetting = JSON.parse(arraySetting);
        this.selector = selector;
        this.messageWindow = messageWindow;
        this.lang = lang;

        this.createTable();
    }

    createTable(){
        console.log(this.arraySetting);
        this.arraySetting.forEach((el) => {
            this.createRow(el, this.selector);
        });
    }

    //tworzy poszczegolne pola
    createRow(rowEl, selector){
        var row = document.createElement('div');
            row.id = rowEl['idsetting']

        var name = document.createElement('input')
            name.type = 'text';
            name.disabled = true;
            name.value = rowEl['name'];
        
        var value;

        //jeśli pole ma do wybory opcje domyslne to utwrz select'a a jeśli nie to zwykły input
        if(rowEl['options'] != null){
            value = document.createElement('select');
            var elements_array = rowEl['options'].split('|');

            //dodaj wartości domyślne do selecta
            elements_array.forEach((el)=>{
                var option = document.createElement('option');
                option.value = el;
                option.innerText = el;

                if(rowEl['value'] == el){
                    option.selected = 'selected';
                }

                value.appendChild(option);
            })

            //zdarzenie zmiany wartości
            value.addEventListener('change', this.sendChange.bind(this));
        }else{
            value = document.createElement('input');
            value.type = 'text';
            value.value = rowEl['value'];
            value.addEventListener('blur', this.sendChange.bind(this));
        }
        
        row.appendChild(name);
        row.appendChild(value);
        selector.appendChild(row);
    }

    //wyślij zmiany na serwer
    sendChange(e){
        this.messageWindow.show(this.lang.message_sending);
        var id = e.target.parentElement.id;
        var value = e.target.value;

        console.log(id, value);

        $.ajax({
            url: `${this.messageWindow.url}panel/changeValue_setting`,
            method: 'POST',
            data: {idsetting: id, value: value}
        }).done((res)=>{
            console.log(res);
            this.messageWindow.done(this.lang.message_sending_ok);
        })
    }
}