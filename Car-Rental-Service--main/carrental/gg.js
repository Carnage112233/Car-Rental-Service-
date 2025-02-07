// Smooth Scrolling for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Search Form Functionality
document.querySelector('.search-form').addEventListener('submit', function (e) {
    e.preventDefault();

    // Get form values
    const carName = document.getElementById('car-name').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    // Validate inputs
    if (!carName || !startDate || !endDate) {
        alert('Please fill in all fields.');
        return;
    }

    if (new Date(startDate) > new Date(endDate)) {
        alert('End date must be after the start date.');
        return;
    }

    // Perform search (you can replace this with your actual search logic)
    console.log('Searching for:', { carName, startDate, endDate });
    alert(`Searching for ${carName} from ${startDate} to ${endDate}`);
});