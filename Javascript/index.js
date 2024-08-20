

document.addEventListener('DOMContentLoaded', function () {

    const banner = document.getElementById('bannerContainer');
    const usedNumbers = [];
    let counter = 1;

    for (let index = 1; index <= 8; index++) {

        let randomInt = Math.floor(Math.random() * books.length);

        if (usedNumbers.includes(randomInt)) {
            index--;
            continue;
        }

        usedNumbers.push(randomInt);
        let book = books[randomInt];

        const imgElement = document.createElement('img');
        const spanElement = document.createElement('span');

        const author = document.createElement('div');
        author.setAttribute('id', 'author');
        const innerAuthor = document.createElement('div');
        innerAuthor.setAttribute('id', 'inner-author');

        innerAuthor.innerHTML = `

        <div class="w-100 text-center"> ${book.firstname} ${book.lastname}</div>
        <div>${book.title} </div>
        `;

        author.appendChild(innerAuthor);

        spanElement.setAttribute('style', `--i: ${counter}`);
        imgElement.setAttribute('src', `${book.photo}`);

        imgElement.addEventListener('mouseover', (e) => {
            imgElement.style.cursor = 'pointer';
            imgElement.style.transform = `scale(1.10)`;
        });
        imgElement.addEventListener('mouseout', (e) => {
            imgElement.style.cursor = 'pointer';
            imgElement.style.transform = `scale(1)`;
        });

        imgElement.addEventListener('click', (e) => {
            window.location.href = `./book-display.php?id=${book.id}`;
        });

        spanElement.appendChild(imgElement);
        spanElement.appendChild(author);
        banner.appendChild(spanElement);
        counter++;
    }

    // Buttons for Banner

    let prev = document.querySelector(".prev");
    let next = document.querySelector(".next");
    let box = document.querySelector(".box");
    let degrees = 0;

    prev.addEventListener("click", function () {
        degrees += 45;
        box.style = `transform: perspective(1000px) rotateY(${degrees}deg);`;
    });


    next.addEventListener("click", function () {
        degrees -= 45;
        box.style = `transform: perspective(1000px) rotateY(${degrees}deg);`;
    });

    if (Number(numberOfComments) > 0) {
        message = `<p class='mt-5 mb-0 text-info'>There are ${numberOfComments} comments waiting for your aproval!</p>`;
    } else {
        message = `<p class='mt-5 mb-0 text-success'>There are no new comments, that need you attention.</p>`;
    }
    if (user !== '' && isFirstLogin === true) {

        if (user === 'user') {
            Swal.fire(
                `Welcome ${username} <p style="color:lightblue" class="mt-5 mb-0">We hope you will find something nice to read today! </p>`);
        } else if (user === 'admin') {
            Swal.fire(
                `Welcome Admin-user ${username} ${message}`)
        }
    }

    const filterContainer = document.getElementById('filters');
    const bookContainer = document.getElementById('bookContainer');

    const pendingComments = userComments.filter((comment) => comment.status === 0);
    const declinedComments = userComments.filter((comment) => comment.status === 2);

    let activeFilters = [];


    function filterBooks() {

        bookContainer.innerHTML = '';
        books.forEach((book) => {
            if (activeFilters.length === 0 || activeFilters.includes(book.category)) {
                let pendingStatus = false;
                let declinedStatus = false;
                pendingComments.forEach((comment) => {
                    if (comment.book_id === book.id) {
                        pendingStatus = true;
                    }
                })
                declinedComments.forEach((comment) => {
                    if (comment.book_id === book.id) {
                        declinedStatus = true;
                    }
                })

                const card = document.createElement('div');
                card.classList.add('card');
                card.style.width = '18rem';

                card.innerHTML = `
                <a href="book-display.php?id=${book.id}" class="text-decoration-none text-dark">
                <img src="${book.photo}" class="card-img-top" height="300px" width="100%" alt="...">
                <div class="card-body">
                <h4 class="card-title mb-3">${book.title}</h4>
                <p class="card-text text-start">Author: <b>${book.firstname} ${book.lastname}</b></p>
                <p class="card-text text-start">Category: <b>${book.category}</b></p>
                </div>
                </a>`;

                if (pendingStatus) {
                    card.innerHTML += `<span data-bs-toggle="tooltip" data-bs-placement="top" title="Comment is pending for approval." style="position:absolute;top:2px;right:2px;border-radius:5%; width:120px;height:20px ;background-color:yellow; font-size:12px;font-weight:bold">Comment pending</span>`;
                }

                if (declinedStatus) {
                    card.innerHTML += `<span data-bs-toggle="tooltip" data-bs-placement="top" title="Comment has been declined." style="position:absolute;top:2px;right:2px;border-radius:5%; width:120px;height:20px ;background-color:red; font-size:12px;color:white;font-weight:bold">Comment declined</span>`;
                }
                bookContainer.appendChild(card);
            }
        });
    }

    function toggleFilter(category) {
        if (activeFilters.includes(category)) {
            activeFilters = activeFilters.filter(filter => filter !== category);
        } else {
            activeFilters.push(category);


        }
    }

    categories.forEach((category) => {
        const button = document.createElement('button');
        button.classList.add('btn', 'btn-outline-secondary', 'me-2', 'filterButton');
        button.setAttribute('data-mdb-ripple-color', 'dark');
        button.innerText = category.title;
        button.addEventListener('click', () => {
            toggleFilter(category.title);
            filterBooks();
            updateFilterAppearance();

        });
        filterContainer.appendChild(button);
    });

    function updateFilterAppearance() {
        const filterButtons = document.querySelectorAll('.filterButton');
        filterButtons.forEach(button => {
            const category = button.innerText;
            if (activeFilters.includes(category)) {
                button.classList.add('selected');
            } else {
                button.classList.remove('selected');
            }
        });
    }
    filterBooks();
    updateFilterAppearance();

});