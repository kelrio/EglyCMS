class ModalWindow{
    constructor(){

    }

    createModal(){
        var modalBackground = document.createElement('div');
        modalBackground.classList.add('modalBackground');
        modalBackground.classList.add('modalWindow');

        var modal = document.createElement('div');
            modal.classList.add('modal');


        var modalHeader = document.createElement('div');
            modalHeader.classList.add('modalHeader');
            var modalExit = document.createElement('div');
                modalExit.innerText = 'X';
                modalExit.classList.add('modalExit');
                modalExit.addEventListener('click', (e)=>{
                    modalBackground.classList.remove('modalWindow');
                    modalBackground.remove();
                });
            modalHeader.appendChild(modalExit)
        
        var modalBody = document.createElement('div');
            modalBody.classList.add('modalBody');
        
        var modalFooter = document.createElement('div');
            modalFooter.classList.add('modalFooter');
            var bodyModalFooter = document.createElement('div');
                bodyModalFooter.classList.add('bodyModalFooter');
            modalFooter.appendChild(bodyModalFooter);

        modal.appendChild(modalHeader);
        modal.appendChild(modalBody);
        modal.appendChild(modalFooter);
        modalBackground.appendChild(modal);


        return {modal: modalBackground, modalMain: modal, header: modalHeader, modalExit: modalExit, body: modalBody, footer: bodyModalFooter};
    }

    setBody(modalBody, ...elements){
        console.log(elements);
        elements.forEach(el => {
            modalBody.appendChild(el);
        });
    }
    setFooter(modalFooter, ...elements){
        console.log(modalFooter.parentElement.clientHeight);
        elements.forEach(element => {
            modalFooter.appendChild(element);
        });
    }
}