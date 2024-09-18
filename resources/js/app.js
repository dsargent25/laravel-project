import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


function updateComments(){

    let commentForms = document.querySelectorAll(".comment-form");

    commentForms.forEach(form =>{

        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            const formData = new FormData(form);
            let urlString = `/chirps/${form.querySelector('#chirpId').value}/comments`;
            let chirpId = `${form.querySelector('#chirpId').value}`;
            let thisUser = `${form.querySelector('#thisUser').value}`;
            try {
                const response = await fetch(urlString, {
                    method: "POST",
                    body: formData,
                });

                const result = await response.json();

                let html = '<p class="leading-5 text-sm text-gray-600">' + thisUser + ' chirps: ' + result.comment.content + '</p>';
                let commentsList = `comments-list-${chirpId}`;
                let commentsContainer = document.getElementById(commentsList);
                commentsContainer.insertAdjacentHTML('beforeend', html);

                event.target.reset();

            } catch (error) {
                console.log(error)
            }

        });

    });

}

document.addEventListener("DOMContentLoaded", (event) => {
    updateComments();
});
