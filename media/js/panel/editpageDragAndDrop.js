/**
 * Klasa odpowiadająca za obsługę drag and drop w projekcie
 */
class DragAndDrop{
    constructor(){
        this.event;
        this.board;

        // Potrzebne dla zdarzenia touch
        this.boardPosition = [];//tablica przechowująca pozycje boardow do umieszczania elementow 
        this.elTarget; //przechowuje tymczasowy element dla DnD 
        this.offsetLeft; //służy do przechowywania odstępu kursora od krańca przesuwanego elelmentu
        this.offsetTop;
        this.value; //przetrzymuje wartość przeciąganego elementu coś ala ev.dataTransfer.setData;
    }
    /**
     * Zdarzenia tylko dla obsługi myszki, nie dla touched
     */
    allowDrop(ev) {
        ev.preventDefault();
    }
    /**
     * metoda obsługująca rozpoczęcie przeciągania elementu
     * @param {*} ev atrybut zdarzenia
     * @param {*} data przekazane dane
     */
    drag(ev, data) {
        ev.dataTransfer.setData("type", data);
    }
    /**
     * Metoda obsługująca zakończenie przeciągania elementu na dozwolony kontener
     * @param {*} ev atrybut zdarzenia
     */
    drop(ev) {
        console.dir(ev);
        ev.preventDefault();
        var data = ev.dataTransfer.getData("type");

        /**
         * wybor jaki element za zostać stworzony
         */
        this.generateElement(data, ev.target);        
    }
    /**
     * Tworzy nowe elementy w najechanym elemencie
     * @param {*} data wartość wskazująca na to jaki elelement ma zostać utworzony
     * @param {*} selector jest to selektor do ktrego ma zostać wstawiony nowy element
     */
    generateElement(data, selector){
        var obiect = document.createElement('div');
            obiect.classList.add('attr');
            obiect.classList.add(data);

        // console.log(obiect);
        var board = this.board.createEmptyBoard();

        var trash = document.createElement('div');
            trash.classList.add('trashContainer');

        var trashImage = document.createElement('img');
            trashImage.src = `${this.board.url}media/img/icon-trash.png`;

        trash.appendChild(trashImage);
        trash.addEventListener('click', (e)=>{
            //usunięcie danych z bazy daych - pobranie niezbednych informacji
            var idElement = e.target.parentElement.parentElement.id;
            var typeElement = (e.target.parentElement.parentElement.classList.contains('text')) ? 'text' : 'image';

            $.ajax({
                url: this.board.url+'panel/removeElementsWithPanel',
                method: 'POST',
                data: {id: idElement, type: typeElement}
            })
            .done((res)=>{
                this.board.setElementsToTabs(selector.parentNode);
                obiect.nextElementSibling.remove();
                obiect.remove();
            })
        })
        
        obiect.addEventListener('mouseenter', (e)=>{
            if(obiect.firstElementChild.classList.contains('modalWindow') == false){
                obiect.appendChild(trash);

                if(obiect.classList.contains('text') == false){
                    trash.style.top = `${obiect.offsetTop - 15}px`;
                    trash.style.left = `${obiect.offsetLeft + obiect.clientWidth - 22}px`;
                }
            }
        })
        obiect.addEventListener('mouseleave', (e)=>{
            trash.remove();
        })

        selector.parentNode.insertBefore(board, selector);
        selector.parentNode.insertBefore(obiect, selector);

        switch (data){
            case 'text':
                this.board.createTextArea(obiect);
                break;
            case 'image':
                this.board.createImage(obiect);
                break;
            case 'rows':
                this.board.createRows(obiect);
                break;
            case 'script':
                this.board.createScript(obiect);
                break;
        }
        // this.board.setElementsToTabs();
    }

/**
 * Zdarzenia tylko dla dotknięcia ekranu
 */

    startDrag(nameClass){
        var board = document.getElementsByClassName(nameClass);
        for(var i = 0; i < board.length; i++){
            board[i].classList.add('allow');
        }
    }

    stopDrag(nameClass){
        var board = document.getElementsByClassName(nameClass);
        for(var i = 0; i < board.length; i++){
            board[i].classList.remove('allow');
        }
    }

    touchStart(e, data){
        var board = document.getElementsByClassName('board');
        for(var i = 0; i < board.length; i++){
            board[i].classList.add('allow');
            board[i].style.display = 'block';
            //console.dir(board[i]);
            this.boardPosition.push({
                xStart: board[i].offsetLeft,
                yStart: board[i].offsetTop,
                xStop: board[i].offsetLeft + board[i].clientWidth,
                yStop: board[i].offsetTop + board[i].clientHeight,
                indicatorToSelector: board[i],
                data: data
            })
            //board[i].style.display = 'none';
        }

        this.elTarget = e.target.cloneNode(true);
        //this.elTarget.classList.add('draggable');
        this.elTarget.style.position = 'fixed';
        this.elTarget.style.opacity = '0.6';
        this.offsetLeft = e.touches[0].clientX -  e.target.offsetLeft;
        this.offsetTop = e.touches[0].clientY -  e.target.offsetTop;
        this.elTarget.style.top = e.touches[0].clientY - this.offsetTop + 'px';
        this.elTarget.style.left = e.touches[0].clientX - this.offsetLeft + 'px';

        e.target.parentNode.appendChild(this.elTarget);

        //console.dir(clientX);
        e.preventDefault();
    }

    touchMove(e){
        this.elTarget.style.top = e.touches[0].clientY - this.offsetTop + 'px';
        this.elTarget.style.left = e.touches[0].clientX - this.offsetLeft + 'px';
    }

    touchEnd(e){
        //ukrywanie elementow board poprzez nadanie stylu display: none;
        var board = document.getElementsByClassName('board');
        for(var i = 0; i < board.length; i++){
            board[i].style.display = 'none';
        }
        console.log(this.boardPosition);
        //sprawdzanie czy wskażnik znajduje się na jakimś elemencie
        this.boardPosition.forEach(({xStart, xStop, yStart, yStop, indicatorToSelector, data})=>{
            if((xStart <= e.changedTouches[0].clientX && e.changedTouches[0].clientX <= xStop) && (yStart <= e.changedTouches[0].clientY && e.changedTouches[0].clientY <= yStop)){
                /**
                 * Obsługa po wykryciu upuszczenie elementu
                 */

                this.generateElement(data, indicatorToSelector);

                console.log(this);
            }
        })

        this.boardPosition = [];

        console.dir(`X: ${e.changedTouches[0].clientX} | Y: ${e.changedTouches[0].clientY}`);

        this.stopDrag('board');
        this.elTarget.remove();
    }

    setBoard(board){
        this.board = board;
    }

    /**
     * dodaje możłiwość przemieszczania elementw dla myszy i dla zdarzenia touch
     * @param {Array} elements przyjmuje tablicę obiektow do zmodyfikowania {element: (selektor), value: (treść przekazana)}
     */
    setDraggable(elements){
        elements.forEach((el)=>{
            el.element.setAttribute('draggable','true');
            el.element.addEventListener('dragstart', (e)=>{
                this.startDrag('board');
                this.drag(e, el.value);
            });

            el.element.addEventListener('dragend', (e)=>{
                this.stopDrag('board');
            });

            /**
             * obsługa dotyku
             * 
             * rozpoczęcie orzesuwania palcem
             * Drag
             */
            el.element.addEventListener('touchstart', (e)=>{
                //this.dragAndDrop.startDrag('board');
                this.touchStart(e, el.value);
            });

            /**
             * Przesuwanie palcem
             * Dragover
             */
            el.element.addEventListener('touchmove', (e)=>{
                this.touchMove(e);
            });

            /**
             * Zakończenie przesuwania palcem
             * Drop
             */
            el.element.addEventListener('touchend', (e)=>{
                this.touchEnd(e);
            });

        })
    }
}