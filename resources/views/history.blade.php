<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>History Data</span>
                    <span>Nama Pasien: {{ Auth::user()->nama }}, No RM: {{ Auth::user()->noRekamMedis }}</span>
                </div>
                <div class="card-body">
                    <!-- History data table will be dynamically added here -->
                    <div id="history-data"></div>
                    <!-- Line charts for history data -->
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="volumeAirChart" width="400" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="volumeUrinChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
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
    const no_rm = '{{ Auth::user()->noRekamMedis }}';
    const historyDataRef = db.ref('Riwayat/' + no_rm); // Replace with database reference

    // Listen for changes in the database
    historyDataRef.on('value', (snapshot) => {
        const data = snapshot.val();
        console.log('Received data:', data); // Log the received data

        const historyTableBody = document.getElementById('history-data');
        const volumeAirCtx = document.getElementById('volumeAirChart').getContext('2d');
        const volumeUrinCtx = document.getElementById('volumeUrinChart').getContext('2d');
        historyTableBody.innerHTML = ''; // Clear existing data

        let labels = [];
        let beratAirData = [];
        let beratUrinData = [];

        // Populate table rows with new data and prepare data for the chart
        if (data) {
            for (const date in data) {
                const records = data[date];
                let tableContent = `
                    <h4>Date: ${date.replace(/-/g, '/')}</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Waktu</th>
                                <th scope="col">Volume Air</th>
                                <th scope="col">Volume Urin</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                for (const time in records) {
                    const record = records[time];
                    const formattedTime = record['Waktu'].replace(/-/g, ':'); // Format time
                    tableContent += `
                        <tr>
                            <td>${formattedTime}</td>
                            <td>${record['Berat Air']}</td>
                            <td>${record['Berat Urin']}</td>
                        </tr>
                    `;

                    labels.push(`${date} ${formattedTime}`);
                    beratAirData.push(record['Berat Air']);
                    beratUrinData.push(record['Berat Urin']);
                }

                tableContent += `
                        </tbody>
                    </table>
                `;

                historyTableBody.innerHTML += tableContent;
            }

            // Create the Volume Air chart
            new Chart(volumeAirCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Volume Air',
                            data: beratAirData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Volume'
                            }
                        }
                    }
                }
            });

            // Create the Volume Urin chart
            new Chart(volumeUrinCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Volume Urin',
                            data: beratUrinData,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Volume'
                            }
                        }
                    }
                }
            });

        } else {
            historyTableBody.innerHTML = '<p>No history data available</p>';
        }
    });
</script>
</body>
</html>
