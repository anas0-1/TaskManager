
    // Update the displayed text of the dropdown when an option is selected
    document.getElementById('categorySelect').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var displayText = selectedOption.textContent;
        this.previousElementSibling.textContent = displayText;
    });


    // Update the value of the hidden input field when a category is selected
    document.getElementById('categorySelect').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var selectedCategoryId = selectedOption.value;
        document.getElementById('selectedCategory').value = selectedCategoryId;
    });


    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const taskItem = this.closest('.task-item');

            const title = taskItem.querySelector('h3').textContent;
            const description = taskItem.querySelector('p:nth-child(2)').textContent;
            const startTime = taskItem.querySelector('p:nth-child(3)').textContent.split(' - ')[0].trim();
            const endTime = taskItem.querySelector('p:nth-child(3)').textContent.split(' - ')[1].split('|')[0].trim();
            const categoryName = taskItem.querySelector('p:nth-child(3)').textContent.split('| Category: ')[1].trim();
            const categoryId = [...document.querySelectorAll('#categorySelect option')].find(option => option.textContent.trim() === categoryName).value;

            document.getElementById('task_id').value = taskId;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('start_time').value = startTime;
            document.getElementById('end_time').value = endTime;
            document.getElementById('categorySelect').value = categoryId;
            document.getElementById('action').value = 'update';
        });
    });

    // Update the value of the hidden input field when a category is selected
    document.getElementById('categorySelect').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var selectedCategoryId = selectedOption.value;
        document.getElementById('selectedCategory').value = selectedCategoryId;
    });


    $(document).ready(function() {
        // Function to handle task deletion
        function deleteTask(taskId) {
            // Send an AJAX request to delete the task
            $.ajax({
                type: 'POST',
                url: 'func/deleteTask.php', // URL to the PHP script for deleting tasks
                data: { task_id: taskId }, // Data to send to the server
                success: function(response) {
                    // If deletion is successful, remove the task item from the DOM
                    $('.task-item[data-task-id="' + taskId + '"]').remove();
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                }
            });
        }

        // Event listener for delete button click
        $('.delete-button').click(function(e) {
            e.preventDefault(); 
            // Get the task ID from the data-task-id attribute
            var taskId = $(this).data('task-id');

            var confirmDelete = confirm("Are you sure you want to delete this task?");
            if (confirmDelete) {
                deleteTask(taskId);
            }
        });
    });


    $(document).ready(function () {
        $('#createTaskForm').on('submit', function (e) {
            e.preventDefault(); 

            var formData = $(this).serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function (response) {
                    // Handle successful response
                    console.log(response); 
                    // You can update the UI or perform any other actions here
                },
                error: function (xhr, status, error) {
                    console.error(error);        
                }
            });
        });
    });

