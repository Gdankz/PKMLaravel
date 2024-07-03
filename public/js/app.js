// App.js

import React, { useEffect, useState } from 'react';
import { database } from './firebase'; // Sesuaikan dengan lokasi file firebase.js
import { ref, onValue } from 'firebase/database';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

function App() {
    const [data, setData] = useState({});

    useEffect(() => {
        const dataRef = ref(database, 'path/to/data');

        onValue(dataRef, (snapshot) => {
            const val = snapshot.val();
            setData(val);
        });
    }, []);

    useEffect(() => {
        if (Object.keys(data).length > 0) {
            createChart(data);
        }
    }, [data]);

    const createChart = (data) => {
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Monitoring Data',
                    data: Object.values(data),
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    };

    return (
        <div className="App">
            <h1>Real-time Monitoring Chart</h1>
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    );
}

export default App;
