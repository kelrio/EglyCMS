/**
 * klasa służąca do generowania treści odebranych z bazy danych jako selektory drzewa DOM
 */
class Elements{
    constructor(data, selector, url){
        this.data = data;
        this.selector = selector;
        this.url = url;

        this.generateElement();
    }

    /**
     * cały proces dodawania elementow do drzewa DOM
     */
    generateElement(){
        this.data.forEach((el, index) => {
            var section = document.createElement('article');

            if(el.type == 'text'){
                if(el.content.substr(0,4) == 'ACE_'){
                    el.content = el.content.slice(4);
                    el.content = unescape(el.content);
                }
                section.innerHTML = el.content;
            }else{
                var imageDiv = document.createElement('div');
                imageDiv.classList.add('imageContainer');

                var imageDescriptionDiv = document.createElement('div');
                imageDescriptionDiv.classList.add('imageDescription');
                
                var imageDescription = document.createElement('p');
                imageDescription.innerHTML = el.description;
                imageDescriptionDiv.appendChild(imageDescription);

                var image = new Image();
                image.src = `${this.url}media/upload/${el.imageName}.${el.imageType}`;
                image.addEventListener('load', (e)=>{
                    console.dir(e);
                    imageDiv.appendChild(e.target);
                    
                });

                section.appendChild(imageDiv);
                section.appendChild(imageDescriptionDiv);
            }

            this.selector.appendChild(section);
        });
    }
}