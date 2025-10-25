// comments.js

function ChangeFont(sizeClass) {
    const body = document.body;
    body.classList.remove('font_1', 'font_2', 'font_3'); // Make sure these are defined in your CSS
    body.classList.add(sizeClass);
}

document.addEventListener('DOMContentLoaded', () => {
    // Determine which page we are on and get the correct elements
    const commentsList = document.getElementById('commentsList') || document.getElementById('indexCommentsList');
    const commentForm = document.getElementById('commentForm'); // This will only exist on comment.html

    // Function to fetch and display comments
    async function fetchComments() {
        if (!commentsList) { // If no comments list element exists on this page, do nothing
            return;
        }

        try {
            const response = await fetch('comments.php');
            const data = await response.json();

            if (data.success) {
                // Clear existing content in the comments list before populating
                // This will clear both hardcoded initial comments on index.html
                // and previous dynamic comments on comment.html
                commentsList.innerHTML = ''; 

                // Create a temporary div to hold the fetched comments
                const tempDiv = document.createElement('div');

                if (data.comments.length > 0) {
                    data.comments.forEach(comment => {
                        const p = document.createElement('p');
                        p.innerHTML = `<b>${comment.name}:</b> ${comment.comment}`;
                        tempDiv.appendChild(p);
                    });
                } else {
                    tempDiv.innerHTML = '<p>No comments yet. Be the first to comment!</p>';
                }
                
                // Append the dynamically loaded comments
                commentsList.appendChild(tempDiv);

                // If on index.html, we also want the "Review" button to stay (if it's not removed by innerHTML = '')
                // Or if it was part of the original hardcoded section.
                // We'll re-add it if it was cleared.
                if ((window.location.pathname.includes('index.html') || window.location.pathname.includes('main.html')) && !document.querySelector('.btn-review')) {
                    const reviewButton = document.createElement('a');
                    reviewButton.href = 'comment.html';
                    reviewButton.className = 'btn-review';
                    reviewButton.textContent = 'Review';
                    commentsList.appendChild(reviewButton);
                }

            } else {
                console.error('Error fetching comments:', data.message);
                commentsList.innerHTML = `<p>Error loading comments: ${data.message}</p>`;
            }
        } catch (error) {
            console.error('Network error fetching comments:', error);
            commentsList.innerHTML = '<p>Network error loading comments.</p>';
        }
    }

    // Call fetchComments on page load for both index.html and comment.html
    fetchComments();

    // Only set up form submission if the comment form exists on this page (i.e., on comment.html)
    if (commentForm) {
        commentForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const name = document.getElementById('commentName').value;
            const comment = document.getElementById('commentText').value;

            if (!name || !comment) {
                alert('Please enter your name and comment.');
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('comment', comment);

            try {
                const response = await fetch('comments.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    document.getElementById('commentName').value = '';
                    document.getElementById('commentText').value = '';
                    fetchComments(); // Reload comments to show the new one on comment.html
                    // Also trigger a refresh for indexCommentsList if it exists and is different
                    // For a basic setup, the user would refresh index.html, or we could use WebSockets/polling
                    // but for simple cases, just loading on DOMContentLoaded is sufficient.
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Network error submitting comment:', error);
                alert('Network error. Could not submit comment.');
            }
        });
    }
});