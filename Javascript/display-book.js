if (status) {
    document.addEventListener('DOMContentLoaded', function () {
        const buttonNotes = document.getElementById('buttonNotes');
        const notesContainer = document.getElementById('notes-container');
        const notesList = document.querySelector('.notes-list');
        const saveButton = document.getElementById('saveButton')
        const textarea = document.getElementById('newNote');
        // Eventlistener for Show / Hide Button for Notes
        buttonNotes.addEventListener('click', (e) => {
            notesContainer.classList.toggle('hideContainer');
            e.target.innerHTML = 'Show notes';
            if (!notesContainer.classList.contains('hideContainer')) {
                e.target.innerHTML = 'Hide notes';
                fetchAndDisplayNotes();
            }
        });

        function fetchAndDisplayNotes(userId) {
            // Fetch notes using AJAX
            fetch(`./Note-CRUD/fetch_notes.php?bookId=${bookId}&userId=${userId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear previous notes
                    notesList.innerHTML = '';

                    // Append fetched notes to the notes list
                    data.forEach(note => {
                        const li = document.createElement('li');
                        li.classList.add('row', 'align-items-center', 'note-item', 'mx-0', 'border-light', 'text-white');
                        li.dataset.noteId = note.id;
                        li.innerHTML = `
                    <div class="col-8">
                        <span class="note-content">${note['note']}</span>
                    </div>
                    <div class="col-4">
                        <a href="#" class="btn btn-dark btn-sm" id="editButton">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm" id="deleteButton">Delete</a>
                    </div>
                `;
                        notesList.appendChild(li);
                    });
                })
                .catch(error => console.error('Error fetching notes:', error));
        }

        saveButton.addEventListener('click', (e) => {
            e.preventDefault();
            newContent = textarea.value;
            saveNote(newContent, userId);
            textarea.value = '';
        })

        // Reset error Message on Textarea Focus
        textarea.addEventListener('focus', (e) => {
            errorNote.innerHTML = '';
        })

        function saveNote(newContent, userId) {

            // Send AJAX request to update note
            fetch('./Note-CRUD/save-note.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    content: newContent,
                    bookId: bookId,
                    userId: userId,
                })
            }).then(response => response.json())
                .then(response => {
                    console.log(response);
                    if (response.success) {
                        fetchAndDisplayNotes();
                        console.log('Note saved successfully');
                    } else {
                        const errorNote = document.getElementById('errorNote');
                        errorNote.innerHTML = "<p class='alert alert-danger'>Can't save an Empty note! </p>";
                        console.error('Failed to save note');
                    }
                })
                .catch(error => console.error('Error saving note:', error));
        }


        // Function to handle editing a note
        function editNote(noteId, newContent) {
            // Send AJAX request to update note
            fetch('./Note-CRUD/edit-note.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: noteId,
                    content: newContent
                })
            })
                .then(response => {
                    if (response.ok) {
                        console.log('Note updated successfully');
                    } else {
                        console.error('Failed to update note');
                    }
                })
                .catch(error => console.error('Error updating note:', error));
        }

        // Function to handle deleting a note
        function deleteNote(noteId) {
            const x = {
                id: noteId
            }

            // Send AJAX request to delete note
            fetch('./Note-CRUD/delete-note.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: noteId
                })
            }).then(response => response.json())
                .then(response => {
                    if (response.success === true) {
                        console.log('The Note has been deleted');

                    } else {
                        console.error('Failed to delete note');
                    }
                })
                .catch(
                    error => console.error('Error deleting note:', error)
                );
        }




        // Add event listener to handle clicks on edit/delete buttons
        notesList.addEventListener('click', async function (event) {
            const target = event.target;
            const noteItem = target.closest('.note-item');
            const editButton = noteItem.querySelector('#editButton');
            const deleteButton = noteItem.querySelector('#deleteButton');

            const noteId = noteItem.dataset.noteId;


            // Handle edit button click
            if (target === editButton) {
                const noteContentElement = noteItem.querySelector('.note-content');
                const initialVal = noteContentElement.textContent;

                const newContent = await Swal.fire({
                    input: "textarea",
                    inputLabel: "Message",
                    inputPlaceholder: "Type your message here...",
                    inputValue: initialVal,
                    inputAttributes: {
                        "aria-label": "Type your message here"
                    },
                    showCancelButton: true

                });



                if (newContent.value !== null && newContent.value !== '' && newContent.value !== undefined) {
                    const noteId = noteItem.dataset.noteId;
                    editNote(noteId, newContent.value);
                    noteContentElement.textContent = newContent.value; // Update UI immediately
                } else {
                    console.log("Note has not beed Updated!");
                }
            }

            // Handle delete button click
            if (target === deleteButton) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure you want to Delete the Note?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "The Note was delete successfully!",
                            icon: "success"
                        })
                        deleteNote(noteId);
                        noteItem.remove();;
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your Note lives another day! :)",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
}