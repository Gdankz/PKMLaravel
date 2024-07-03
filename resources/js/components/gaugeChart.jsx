import React, { useEffect, useState } from 'react';
import { Chart } from 'react-google-charts';
import { initializeApp } from 'firebase/app';
import { getDatabase, ref, onValue } from 'firebase/database';

// Konfigurasi Firebase
const firebaseConfig = {
    apiKey: "AIzaSyCyMqMTTTMbkzamN2_4HDCpJRR2SFrZA_0",
    authDomain: "dummytes-sipair.firebaseapp.com",
    databaseURL: "https://dummytes-sipair-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "dummytes-sipair",
    storageBucket: "dummytes-sipair.appspot.com",
    messagingSenderId: "424489212182",
    appId: "1:424489212182:web:9db5ec4785086d6d6f1837"
};

// Inisialisasi Firebase
const app = initializeApp(firebaseConfig);
const database = getDatabase(app);

const GaugeChart = () => {
    const [data, setData] = useState([['Label', 'Value'], ['Berat Urin', 0]]);

    useEffect(() => {
        const urinRef = ref(database, 'Realtime/135035/Berat Urin');
        onValue(urinRef, (snapshot) => {
            const value = snapshot.val();
            setData([['Label', 'Value'], ['Berat Urin', value]]);
        });
    }, []);

    const options = {
        width: 400,
        height: 120,
        redFrom: 90,
        redTo: 100,
        yellowFrom: 75,
        yellowTo: 90,
        minorTicks: 5
    };

    return (
        <Chart
            chartType="Gauge"
            width="100%"
            height="400px"
            data={data}
            options={options}
        />
    );
};

export default GaugeChart;
