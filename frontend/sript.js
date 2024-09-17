document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const resultsDiv = document.getElementById('results');
    const maxFeeSlider = document.getElementById('maxFee');
    const feeValue = document.getElementById('feeValue');

    // Update fee value display
    maxFeeSlider.addEventListener('input', () => {
        feeValue.textContent = `$${maxFeeSlider.value}`;
    });

    // Initial fee value display
    feeValue.textContent = `$${maxFeeSlider.value}`;

    searchForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const searchTerm = searchInput.value;
        const maxFee = maxFeeSlider.value;
        const stateFilters = Array.from(document.querySelectorAll('input[name="state"]:checked')).map(cb => cb.value);
        const typeFilters = Array.from(document.querySelectorAll('input[name="collegeType"]:checked')).map(cb => cb.value);
        const courseFilters = Array.from(document.querySelectorAll('input[name="course"]:checked')).map(cb => cb.value);
        const facilityFilters = Array.from(document.querySelectorAll('input[name="facility"]:checked')).map(cb => cb.value);

        const response = await fetch('../backend/search.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `search=${searchTerm}&maxFee=${maxFee}&states=${stateFilters.join(',')}&types=${typeFilters.join(',')}&courses=${courseFilters.join(',')}&facilities=${facilityFilters.join(',')}`
        });

        const data = await response.json();
        displayResults(data);
    });

    function displayResults(colleges) {
        resultsDiv.innerHTML = '';
        colleges.forEach(college => {
            const collegeCard = document.createElement('div');
            collegeCard.className = 'college-card';
            collegeCard.innerHTML = `
                <h2>${college.name}</h2>
                <p>Type: ${college.type}</p>
                <p>State: ${college.state}</p>
                <p>Fees: $${college.fees}</p>
                <p>Courses: ${college.courses.join(', ')}</p>
                <p>Facilities: ${college.facilities.join(', ')}</p>
            `;
            resultsDiv.appendChild(collegeCard);
        });
    }

    // Fetch and populate filter options
    async function populateFilters() {
        const response = await fetch('../backend/get_filters.php');
        const filters = await response.json();

        const stateFilters = document.getElementById('stateFilters');
        const courseFilters = document.getElementById('courseFilters');
        const facilityFilters = document.getElementById('facilityFilters');

        filters.states.forEach(state => {
            stateFilters.innerHTML += `<label><input type="checkbox" name="state" value="${state}"> ${state}</label>`;
        });

        filters.courses.forEach(course => {
            courseFilters.innerHTML += `<label><input type="checkbox" name="course" value="${course}"> ${course}</label>`;
        });

        filters.facilities.forEach(facility => {
            facilityFilters.innerHTML += `<label><input type="checkbox" name="facility" value="${facility}"> ${facility}</label>`;
        });
    }

    populateFilters();
});