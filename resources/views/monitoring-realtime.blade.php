<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Real-Time Monitoring</span>
                    <span>Nama Pasien: {{ Auth::user()->nama }}, No RM: {{ Auth::user()->noRekamMedis }}</span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Tanggal Update Terakhir</th>
                            <th scope="col">Timestamp</th>
                            <th scope="col">Volume Air</th>
                            <th scope="col">Volume Urin</th>
                        </tr>
                        </thead>
                        <tbody id="realtime-data">
                        <!-- Data will be dynamically added here -->
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                        <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-database-compat.js"></script>
<script>
    // Initialize Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyButORfCnXSdc2YVxcmuW6j_LUZMFY6oRU",
        authDomain: "sipair-pkm2024.firebaseapp.com",
        databaseURL: "https://sipair-pkm2024-default-rtdb.firebaseio.com",
        projectId: "sipair-pkm2024",
        storageBucket: "sipair-pkm2024.appspot.com",
        messagingSenderId: "732555989903",
        appId: "1:732555989903:web:efd2c5dd3b5328fc0171fa"
    };
    firebase.initializeApp(firebaseConfig);

    // Get a reference to the database service
    const db = firebase.database();

    // Replace with your no_rm value
    const no_rm = '{{ Auth::user()->noRekamMedis }}';
    const realtimeDataRef = db.ref('Realtime/' + no_rm);

    // Listen for changes in the database
    realtimeDataRef.on('value', (snapshot) => {
        const data = snapshot.val();
        console.log('Received data:', data); // Log the received data

        const realtimeTableBody = document.getElementById('realtime-data');
        realtimeTableBody.innerHTML = ''; // Clear existing data

        // Populate table rows with new data
        if (data) {
            const timestamp = data['Timestamp'] ? data['Timestamp'] : 'N/A';
            const formattedTimestamp = timestamp.replace(/-/g, ':'); // Replace '-' with ':'

            const lastUpdate = data['Tanggal Update Terakhir'] ? data['Tanggal Update Terakhir'] : 'N/A';
            const formattedLastUpdate = lastUpdate.replace(/-/g, '/'); // Replace '-' with '/'

            const row = `
                <tr>
                    <td>${formattedLastUpdate}</td>
                    <td>${formattedTimestamp}</td>
                    <td>${data['Berat Air'] || 'N/A'}</td>
                    <td>${data['Berat Urin'] || 'N/A'}</td>
                </tr>
            `;
            realtimeTableBody.innerHTML += row;
        } else {
            const row = `
                <tr>
                    <td colspan="4">No data available</td>
                </tr>
            `;
            realtimeTableBody.innerHTML += row;
        }
    });
</script>
</body>
</html>
