/**
 * Klasa służąca do generowania elementow listy dla dragAndDrop do edytora stron
 */
class List{
    constructor(selector, url, dragAndDrop){
        this.selector = selector;
        this.url = url;
        this.dragAndDrop = dragAndDrop;
        this.optionsCols = {display: 'none', value: 45};

        // Potrzebne dla zdarzenia touch
        this.boardPosition = [];//tablica przechowująca pozycje boardow do umieszczania elementow 
        this.elTarget; //przechowuje tymczasowy element dla DnD 
        this.offsetLeft; //służy do przechowywania odstępu kursora od krańca przesuwanego elelmentu
        this.offsetTop;

        this.createList();
    }
    /**
     * Tworzy liste skłądającą się z elementw do przeciągania
     */
    createList(){
        window.addEventListener('scroll', (e)=>{
            this.scrollMenu(e);
        })


        //sprawdzanie typu urządzenia wyświetlającego treść
        // console.log(CheckDisplay.getDisplay());

        var elements = [];
        var list = document.createElement('div');
            list.classList.add('list');

        var text = document.createElement('div');
            text.classList.add('attr');
            text.classList.add('text');
            var imgText = document.createElement('img');
            imgText.src = this.url + 'media/img/icon-text.png';
            text.appendChild(imgText);
            

        elements[0] = document.createElement('div');
        elements[0].classList.add('element');
        elements[0].appendChild(text);

        var img = document.createElement('div');
            img.classList.add('attr');
            img.classList.add('cols');
            var imgImg =document.createElement('img');
            imgImg.src = this.url + 'media/img/icon-image.png';
            img.appendChild(imgImg);
            //cols.appendChild(options.cloneNode(true));

        elements[1] = document.createElement('div');
        elements[1].classList.add('element');
        elements[1].appendChild(img);

        // var rows = document.createElement('div');
        //     rows.classList.add('attr');
        //     rows.classList.add('rows');
        //     var imgRows =document.createElement('img');
        //     imgRows.src = this.url + 'media/img/icon-rows.png';
        //     rows.appendChild(imgRows);

        // elements[2] = document.createElement('div');
        // elements[2].classList.add('element');
        // elements[2].appendChild(rows);

        var script = document.createElement('div');
        script.classList.add('attr');
        script.classList.add('rows');
            var imgScript = document.createElement('img');
            imgScript.src = this.url + 'media/img/icon-script.png';
            script.appendChild(imgScript);

        elements[2] = document.createElement('div');
        elements[2].classList.add('element');
        elements[2].appendChild(script);

        /**
         * Wysyła do klasy DragAndDrop dane, jakie ikonki istnieją oraz ich wartośc do generowania elementow
         */
        this.dragAndDrop.setDraggable([
            {element: imgText, value: 'text'},
            {element: imgImg, value: 'image'},
            //{element: imgRows, value: 'rows'},
            {element: imgScript, value: 'script'},
        ])

        /**
         * dodawanie utworzonych elementow do drzewa nienawiści(DOOM)
         */
        elements.forEach(el => {
            list.appendChild(el);
        });
        this.selector.appendChild(list);
    }
    
    /**
     * zdarzenie, ktore po przekroczeniu pozycji ekranu ustawia liste widoczną cały czas na grze ekranu
     */
    scrollMenu(e){
        var menu = this.selector.firstElementChild;
        if (document.body.scrollTop > 178 || document.documentElement.scrollTop > 178) {
            if(!menu.classList.contains('scroll')){
                menu.classList.add('scroll');
                this.selector.children[1].style.paddingTop = '76px';
            }
		} else {
            if(menu.classList.contains('scroll')){
                menu.classList.remove('scroll');
                this.selector.children[1].removeAttribute('style');
            }
		}
	}
}