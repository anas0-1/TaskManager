    // Function to handle exporting tasks
    function exportTasks() {
        // Fetch tasks data from the server 
        fetch('func/exportTasks.php')
            .then(response => response.json())
            .then(tasksData => {

                const tasksJson = JSON.stringify(tasksData);

                const blob = new Blob([tasksJson], { type: 'application/json' });

                // Create a link element to trigger download
                const downloadLink = document.createElement('a');
                downloadLink.href = URL.createObjectURL(blob);
                downloadLink.download = 'tasks.json';

                downloadLink.click();
            })
            .catch(error => {
                console.error('Error exporting tasks:', error);
                alert('Failed to export tasks. Please try again.');
            });
    }

    // event listener to export button
    document.getElementById('exportTasksBtn').addEventListener('click', exportTasks);


    // Function to handle importing tasks
    function importTasks(event) {
        const file = event.target.files[0];

        
        if (file) {
           
            const reader = new FileReader();
            reader.onload = function (event) {
                try {
                    const tasksData = JSON.parse(event.target.result);
                    // function to process imported tasks data
                    processImportedTasks(tasksData);
                } catch (error) {
                    console.error('Error parsing JSON file:', error);
                    alert('Invalid JSON file. Please select a valid JSON file.');
                }
            };
            reader.readAsText(file);
        }
    }

    // event listener for importing tasks
    document.getElementById('importTasksInput').addEventListener('change', importTasks);

