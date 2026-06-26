<?php
// if no session, redirect to login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
// Read comments from JSON file
$commentsFile = 'comment.json';
$comments = [];
if (file_exists($commentsFile)) {
    $jsonContent = file_get_contents($commentsFile);
    $comments = json_decode($jsonContent, true);
}
$commentCount = count($comments);
?>
<div class="admin-content">
    <div class="admin-header">
        <h1><i class="fas fa-comments"></i> User Comments & Suggestions</h1>
        <div class="comment-count">
            <span><?php echo $commentCount; ?></span>
            <small>Total</small>
        </div>
    </div>
    
    <?php if (empty($comments)): ?>
        <div class="no-comments">
            <i class="fas fa-inbox"></i>
            <h3>No Comments Yet</h3>
            <p>When users submit comments or suggestions, they will appear here.</p>
        </div>
    <?php else: ?>
        <div class="comments-container">
            <?php foreach ($comments as $index => $comment): ?>
                <div class="comment-card" data-index="<?php echo $index; ?>">
                    <div class="comment-header">
                        <div class="user-info">
                            <div class="user-name"><?php echo htmlspecialchars($comment['name']); ?></div>
                            <?php if (!empty($comment['email'])): ?>
                                <div class="user-email"><?php echo htmlspecialchars($comment['email']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="comment-meta">
                            <div class="comment-date"><?php echo date('F j, Y, g:i a', strtotime($comment['date'])); ?></div>
                            <button class="delete-btn" data-index="<?php echo $index; ?>">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="comment-content">
                        <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Deletion</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this comment? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button id="cancelDelete" class="btn btn-secondary">Cancel</button>
            <button id="confirmDelete" class="btn btn-danger">Delete</button>
        </div>
    </div>
</div>

<style>
.admin-content {
    width: 100%;
}
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #eee;
}
.admin-header h1 {
    color: var(--hov);
    font-size: 2.2rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}
.comment-count {
    background-color: var(--bgcol);
    color: white;
    border-radius: 8px;
    padding: 10px 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.comment-count span {
    font-size: 1.8rem;
    font-weight: bold;
    line-height: 1;
}
.comment-count small {
    font-size: 0.8rem;
    margin-top: 3px;
}
.no-comments {
    text-align: center;
    padding: 50px 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.no-comments i {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 20px;
}
.no-comments h3 {
    color: var(--hov);
    margin-bottom: 10px;
}
.no-comments p {
    color: #666;
}
.comments-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.comment-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.comment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 15px 20px;
    background-color: #f9f9f9;
    border-bottom: 1px solid #eee;
}
.user-info {
    flex-grow: 1;
}
.user-name {
    font-weight: bold;
    color: var(--hov);
    font-size: 1.1rem;
    margin-bottom: 5px;
}
.user-email {
    color: #666;
    font-size: 0.9rem;
}
.comment-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
}
.comment-date {
    color: #777;
    font-size: 0.85rem;
    white-space: nowrap;
}
.delete-btn {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s;
}
.delete-btn:hover {
    background-color: #d32f2f;
}
.comment-content {
    padding: 20px;
    line-height: 1.6;
    color: #333;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    animation: fadeIn 0.3s;
}
.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 0;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: slideIn 0.3s;
}
.modal-header {
    background-color: #f44336;
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-header h3 {
    margin: 0;
    font-size: 1.2rem;
}
.close {
    color: white;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
}
.close:hover {
    opacity: 0.7;
}
.modal-body {
    padding: 20px;
}
.modal-footer {
    padding: 15px 20px;
    background-color: #f9f9f9;
    border-radius: 0 0 8px 8px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.btn {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}
.btn-secondary {
    background-color: #e0e0e0;
    color: #333;
}
.btn-secondary:hover {
    background-color: #d0d0d0;
}
.btn-danger {
    background-color: #f44336;
    color: white;
}
.btn-danger:hover {
    background-color: #d32f2f;
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}
@keyframes slideIn {
    from {transform: translateY(-50px); opacity: 0;}
    to {transform: translateY(0); opacity: 1;}
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .comment-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .comment-meta {
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
    }
    
    .comment-date {
        align-self: auto;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const modal = document.getElementById('deleteModal');
    const closeBtn = document.getElementsByClassName('close')[0];
    const cancelBtn = document.getElementById('cancelDelete');
    const confirmBtn = document.getElementById('confirmDelete');
    
    // Variable to store the index of the comment to be deleted
    let commentToDelete = null;
    
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    // Add click event to each delete button
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            commentToDelete = this.getAttribute('data-index');
            modal.style.display = 'block';
        });
    });
    
    // Close modal when clicking on X
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        commentToDelete = null;
    });
    
    // Close modal when clicking on Cancel
    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        commentToDelete = null;
    });
    
    // Handle delete confirmation
    confirmBtn.addEventListener('click', function() {
        if (commentToDelete !== null) {
            // Create and send form data
            const formData = new FormData();
            formData.append('index', commentToDelete);
            
            // Send request to delete comment
            fetch('delete_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the comment card from the DOM
                    const commentCard = document.querySelector(`.comment-card[data-index="${commentToDelete}"]`);
                    if (commentCard) {
                        commentCard.remove();
                    }
                    
                    // Update comment count
                    const countElement = document.querySelector('.comment-count span');
                    if (countElement) {
                        countElement.textContent = data.count;
                    }
                    
                    // Check if there are no more comments
                    const commentsContainer = document.querySelector('.comments-container');
                    if (commentsContainer && data.count === 0) {
                        commentsContainer.innerHTML = `
                            <div class="no-comments">
                                <i class="fas fa-inbox"></i>
                                <h3>No Comments Yet</h3>
                                <p>When users submit comments or suggestions, they will appear here.</p>
                            </div>
                        `;
                    }
                } else {
                    alert('Error deleting comment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting comment. Please try again.');
            })
            .finally(() => {
                modal.style.display = 'none';
                commentToDelete = null;
            });
        }
    });
    
    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
            commentToDelete = null;
        }
    });
});
</script>