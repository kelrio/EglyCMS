/**
 * Klasa odpowiedzialna za generowanie zakładki menu po stronie klienta
 * data - tablica elementow składająca się z elementow menu {idmenu: int/primaryKey, name: string, subelement: int/referenceKey}
 * selector - selector do ktorego mają zostać wstawiane elemnty
 * url - adres panelu zarządzania: http://localhost/
 */
class Menu {
    constructor(data, selector, url, logo = 'logo', testingMode = false){
        this.data = this.decodeData(data);
        this.selector = selector;
        this.url = url;
        this.logo = logo;
        this.testingMode = testingMode;

        this.createElements();
    }

    //przetwarzanie odebranej tablicy na tablicę obiektow : [..., idmenu: int, name: string, subelement: [idmenu: int, name: string]]
    decodeData(data){
        var completeMenuElement = [];
        var menuElementWithoutAssigment = []
        data.forEach((el, index) => {
            if(el.subelement){
                menuElementWithoutAssigment = [...menuElementWithoutAssigment, el];
            }else{
                completeMenuElement = [...completeMenuElement, {idmenu: el.idmenu, name: el.name, subelements: []}];
            }
        });

        //przypisywanie podelementow do elementow, ktore zawierają dany podelement
        menuElementWithoutAssigment.forEach((el, index) => {
            const findElement = completeMenuElement.find((e)=>{
                return e.idmenu == el.subelement;
            });
            findElement.subelements = [...findElement.subelements, el]
        });
        console.log(completeMenuElement);
        return completeMenuElement;
    }

    //generuje elementy w drzewie DOM na podstawie wygenerowanej tablicy elementow
    createElements(){
        var logo = document.createElement('div');
        logo.classList.add('logo');
        logo.innerText = this.logo;


        var mainUl = document.createElement('ul');

        this.data.forEach((el)=>{
            let li = document.createElement('li');
            mainUl.appendChild(li);

            let href = document.createElement('a');
            href.href = (this.testingMode) ? '#' : `${this.url}home/page/${el.idmenu}`;
            href.innerText = el.name;
            li.appendChild(href);

            if(el.subelements){
                let ul = document.createElement('ul');
                el.subelements.forEach((e)=>{

                    let li = document.createElement('li');
                    ul.appendChild(li);

                    let href = document.createElement('a');
                    href.href = (this.testingMode) ? '#' : `${this.url}home/page/${el.idmenu}`;
                    href.innerText = e.name;
                    li.appendChild(href);

                })
                li.appendChild(ul);
            }
        })

        //dodanie odnośnika do panelu zarządzania
        let li = document.createElement('li');
        mainUl.appendChild(li);

        let href = document.createElement('a');
        href.href = `${this.url}panel`;
        href.classList.add('panel');
        href.innerText = 'Logowanie';
        li.appendChild(href);

        this.selector.appendChild(logo);
        this.selector.appendChild(mainUl);
    }
}