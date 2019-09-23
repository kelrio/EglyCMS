class MenuSort{
    constructor(json, selector, url){
        this.elements;
        this.selector = selector;
        this.url = url;

        this.decode(json);
    }

    decode(json){
        this.elements = JSON.parse(json);
        console.log(this.elements);

        this.createElements();
    }

    createElements(){
        var containerIds = [];

        var elementMain = document.createElement('div');
            elementMain.classList.add('mainElement'); 

        this.elements.forEach((el) => {
            if(el.subelement == null){
                var text = document.createElement('a');
                    text.innerHTML = el.name;
                    text.setAttribute('href', this.url + 'panel/editPage/'+el.idmenu);
                
                var elements = document.createElement('div');
                    elements.appendChild(text);
                    elements.classList.add('element');
                    elements.id = el.idmenu;

                    containerIds[el.idmenu] = document.createElement('div');
                    containerIds[el.idmenu].classList.add('subelement');

                elementMain.appendChild(elements);
            }
        });

        this.elements.forEach((el) => {
            if(el.subelement != null){

                var text = document.createElement('a');
                    text.innerHTML = el.name;
                    text.setAttribute('href', this.url + 'panel/editPage/'+el.idmenu);
                
                var elements = document.createElement('div');
                    elements.appendChild(text);
                    elements.classList.add('attrSubelement');
                    elements.id = el.idmenu;
                
                containerIds[el.subelement].appendChild(elements);  
                console.dir(containerIds);
            }
        });

        console.log(containerIds);

        this.selector.appendChild(elementMain);

        containerIds.forEach((el, index) => {
            var elements = document.getElementById(index);
                elements.appendChild(el);
            console.dir(index);
        });
    }


}