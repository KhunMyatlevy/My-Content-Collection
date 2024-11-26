fetch('js/projects.json')
    .then(response => {
        // Check if the response is OK (status 200-299)
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Convert the response data to JSON format
    })
    .then(data => {
        projects = data; // Store the fetched projects
        displayProjects(projects); // Display all projects initially
    })
    .catch(error => console.error('Error fetching projects:', error));

// Function to display projects
function displayProjects(projectsToDisplay) {
    // Select the project list container
    const projectsContainer = document.querySelector('.projects-container');

    // Clear any existing content in the projects container
    projectsContainer.innerHTML = '';

    // Loop through each project and create a project item
    projectsToDisplay.forEach(project => {
        const projectItem = document.createElement('div');
        projectItem.className = 'project-item';

        // Create the project title and link
        const projectTitle = document.createElement('h2');
        projectTitle.textContent = project.title; // Use the title from the project data

        const projectLink = document.createElement('a');
        projectLink.href = project.url;
        projectLink.textContent = 'View Project';

        // Create an image element for the project
        const projectImage = document.createElement('img');
        projectImage.src = project.image; // Set the source to the project's image
        projectImage.alt = project.title; // Set alt text for the image
        
        // Append title, link, and image to the project item
        projectItem.appendChild(projectTitle);
        projectItem.appendChild(projectImage);
        projectItem.appendChild(projectLink);

        // Append the project item to the projects container
        projectsContainer.appendChild(projectItem);
    });
}