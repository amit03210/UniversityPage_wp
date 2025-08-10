class My_note{
    constructor(){
        this.delete_buttons = document.querySelectorAll('.delete-note');
        this.edit_button = document.querySelectorAll('.edit-note');
        this.saveButton = document.querySelectorAll('.update-note');
        this.event();
    }

    event(){
        this.delete_buttons.forEach(ele => ele.addEventListener('click', this.deleting_Note));
        this.edit_button.forEach(ele => ele.addEventListener('click', this.edit_note.bind(this)));
        this.saveButton.forEach(ele => ele.addEventListener('click', this.updateNote.bind(this)));
    }
    //Methods
    edit_note(e){
        const parentEl = e.target.parentElement;
        const currentState = parentEl.getAttribute('state');
        if (currentState === '' || currentState === null) {
            this.makeNoteEditable(parentEl);
        }else{
            this.makeNoteReadOnly(parentEl);
        }
        
    } 
    
    makeNoteEditable(parentEl){

        parentEl.querySelectorAll('.note-title-field, .note-body-field').forEach(el => {
            if(el){
                el.removeAttribute('readonly');
                if(el.tagName === 'P')
                    el.setAttribute('contentEditable', 'true');
                el.classList.add('note-active-field');
            }
        })
        parentEl.querySelector('.update-note').classList.add('update-note--visible');
        parentEl.querySelector('.edit-note').innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel';
        parentEl.setAttribute('state', 'editable');
    }

    makeNoteReadOnly(parentEl){
        parentEl.querySelectorAll('.note-title-field, .note-body-field').forEach(el => {
            if(el){
                el.setAttribute('readonly', 'true');
                if(el.tagName === 'P')
                    el.setAttribute('contentEditable', 'false');
                el.classList.remove('note-active-field');
            }
        })
        parentEl.querySelector('.update-note').classList.remove('update-note--visible');
        parentEl.querySelector('.edit-note').innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit';
        parentEl.setAttribute('state', '');
    }


    deleting_Note(e) {
        const id = e.target.parentElement.dataset['id'];
        const url = universityData['root_url'] + "//wp-json/wp/v2/note/" + id;
        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': universityData.nonce,
            }
        })
        .then(res => res.json())
        .catch(err => console.log(err));
        e.target.parentElement.classList.add('fade-out');
    }

    updateNote(e){
        const id = e.target.parentElement.dataset['id'];
        const parentEl = e.target.parentElement;
        let updatedPost = {
            'title': parentEl.querySelector('.note-title-field').value,
            'content': parentEl.querySelector('.note-body-field').textContent,
        }
        const url = universityData['root_url'] + "//wp-json/wp/v2/note/" + id;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': universityData.nonce,
            },
            body: JSON.stringify(updatedPost),
        })
        .then(res => this.makeNoteReadOnly(parentEl))
        .catch(err => console.log(err));

        // e.target.parentElement.classList.add('fade-out');
    }
}

export default My_note;