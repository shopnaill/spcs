<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Requests</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container" id="app">
        <h1>Support Requests</h1>
        <ul id="supportRequests"></ul>
    </div>

    <!-- Include Bootstrap and Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- Include your custom JavaScript code -->
    <script>
        // Make AJAX request to fetch support requests
        function fetchSupportRequests() {
            axios.get('/api/support-requests')
                .then(response => {
                    const supportRequests = response.data;
                    renderSupportRequests(supportRequests);
                })
                .catch(error => {
                    console.error('Error fetching support requests:', error);
                });
        }

        // Render support requests to the DOM
        function renderSupportRequests(supportRequests) {
            const supportRequestsList = document.getElementById('supportRequests');
            supportRequestsList.innerHTML = ''; // Clear previous content

            supportRequests.forEach(request => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
            <strong>${request.requester_name}</strong> (${request.requester_email}): ${request.message}
        `;
                supportRequestsList.appendChild(listItem);
            });
        }

        // Initialize Laravel Echo for real-time updates
        function setupEcho() {
            const pusher = new Pusher('your-pusher-key', {
                cluster: 'eu'
            });

            const echo = new Echo({
                broadcaster: 'pusher',
                client: pusher
            });

            echo.channel('support-requests')
                .listen('SupportRequestReceived', (event) => {
                    const newRequest = event.supportRequest;
                    const supportRequests = [...document.getElementById('supportRequests').childNodes];
                    const lastRequestId = supportRequests.length > 0 ? supportRequests[supportRequests.length - 1]
                        .getAttribute('data-id') : null;

                    if (!lastRequestId || lastRequestId !== newRequest.id) {
                        renderSupportRequests([...supportRequests, newRequest]);
                    }
                });
        }

        // Fetch support requests and set up Echo when the DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            fetchSupportRequests();
            setupEcho();
        });
    </script>
</body>

</html>
