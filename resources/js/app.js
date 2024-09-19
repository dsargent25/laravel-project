import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function addDeleteClickHandler(form){
    form.querySelector('.comment-delete-form').addEventListener('submit', deleteComments());
}

function updateComments(){

    let commentForms = document.querySelectorAll(".comment-form");

    commentForms.forEach(form =>{

        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            const formData = new FormData(form);
            let urlString = `/chirps/${form.querySelector('#chirpId').value}/comments`;
            let chirpId = `${form.querySelector('#chirpId').value}`;
            let thisUser = `${form.querySelector('#thisUser').value}`;
            var csrf = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch(urlString, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-Token': csrf,
                    }
                });

                const result = await response.json();

                let html =

                `
                    <div id="comment-${result.comment.id}">
                        <div>
                            <p class="leading-5 text-sm text-gray-600"> ${thisUser} chirps: ${result.comment.content} </p>
                        </div>

                        <form class="comment-delete-form">
                            <input type="hidden" name="_token" value="${csrf}" autocomplete="off">
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" id="commentId" name="commentId" value="${result.comment.id}">
                            <button type="submit" class=" text-red-600 text-xs px-6">Delete Comment</button>
                        </form>
                    </div>

                `;


                let commentsList = `comments-list-${chirpId}`;
                let commentsContainer = document.getElementById(commentsList);
                commentsContainer.insertAdjacentHTML('beforeend', html);

                let newComment = document.querySelector(`#comment-${result.comment.id}`);

                addDeleteClickHandler(newComment);

                event.target.reset();

            } catch (error) {
                console.log(error)
            }

        });

    });

}

function deleteComments(){

    let commentDeleteForms = document.querySelectorAll(".comment-delete-form");

    commentDeleteForms.forEach(form =>{

        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            let commentId = `${form.querySelector('#commentId').value}`;
            let urlStringDelete = `/comments/${commentId}`;
            let commentInstanceId = `comment-${commentId}`;
            let commentInstance = document.getElementById(commentInstanceId);
            var csrf = document.querySelector('meta[name="csrf-token"]').content;

            try {

                const response = await fetch(urlStringDelete, {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-Token': csrf,
                    }
                });

                if (response.status === 200) {
                    commentInstance.remove();
                }

            } catch (error) {
                console.log(error)
            }

        });

    });

}

document.addEventListener("DOMContentLoaded", (event) => {
    updateComments();
    deleteComments();
});
