function checkUnratedRequests() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'query/check_rated.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);

                const requestTypeMap = {
                    'ict_maintenance': 'ICT Maintenance',
                    'software_development': 'Software Development',
                    'ict_equipment_inspection': 'ICT Equipment Inspection',
                    'documentation': 'Documentation',
                    'audio_visual_editing': 'Audio Visual Editing',
                    'deped_email_request': 'DepEd Email',
                    'password_reset': 'Email Concern',
                    'id_card_printing': 'ID Card Printing'
                };

                if (response.unratedRequests && response.unratedRequests.length > 0) {
                    response.unratedRequests.forEach(request => {
                        const requestType = requestTypeMap[request.request_type_table] || 'Unknown Request Type';

                        const message = `Type: ${requestType}<br>ID: ${request.request_id}`;

                        // Create a click handler that navigates to the status page
                        const clickHandler = function() {
                            window.location.href = `status?request_id=${request.request_id}`;
                        };

                        toastr.warning(message, 'Rating Reminder', {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            timeOut: 5000,
                            style: {
                                backgroundColor: '#dc3545', 
                                color: '#fff', 
                                borderRadius: '5px',
                                padding: '10px' 
                            },
                            onclick: clickHandler // Set the click handler
                        });
                    });
                } else {
                    console.log('No unrated requests found.');
                }
            } catch (e) {
                console.error('Error parsing response JSON:', e);
            }
        }
    };

    xhr.onerror = function () {
        console.error('Error with the request.');
    };

    xhr.send();
}

window.onload = function () {
    checkUnratedRequests();
};

setInterval(checkUnratedRequests, 10000);