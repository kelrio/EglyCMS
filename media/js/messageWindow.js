/**
 * klasa odpowiedzialna za wyświeltanie komuniaktow o łądowaniu
 */
class MessageWindow{
    constructor(container, url){
        this.container = container;
        this.url = url;

        this.load  = `${url}media/img/ajax-loader.gif`;
        this.ok = `${url}media/img/ok.png`;
        this.alertImg = `${url}media/img/alert-icon.png`;

        console.dir(this.container);
    }

    //metoda odpowiedzialna za wyświetlanie komunikatu
    show(message){
        this.container.children[0].children[1].innerText = message;
        this.container.children[0].children[0].src = this.load;
        $(this.container).finish();
        $(this.container).animate({
            top: '-20px'
        })
    }

    //metoda ukrywająca komunikat
    done(message){
        $(this.container).delay(500).animate({
            top: '-100px'
        });

        this.container.children[0].children[1].innerText = message;
        this.container.children[0].children[0].src = this.ok;
    }

    alert(message){
        this.container.children[0].children[1].innerText = message;
        this.container.children[0].children[0].src = this.alertImg;
        $(this.container).finish();
        
        $(this.container).animate({
            top: '-20px'
        }).delay(2500).animate({
            top: '-100px'
        });
    }

}