import React, { useEffect, useRef } from 'react';
import { database } from '../firebase'; // Sesuaikan dengan lokasi file firebase.js
import { ref, onValue } from 'firebase/database';
import Chart from 'chart.js/auto';

const PieChartUrin = () => {
const chartRef = useRef(null);

useEffect(() => {
const urinDataRef = ref(database, 'path/to/urinData');

const fetchData = () => {
onValue(urinDataRef, (snapshot) => {
const val = snapshot.val();
console.log('Data dari Firebase:', val); // Tambahkan log ini untuk melihat data

if (typeof val === 'object' && val !== null) {
createChart(val);
} else {
console.error('Data dari Firebase bukan objek atau array:', val);
}
});
};

fetchData();

// Cleanup listener
return () => {
// Unsubscribe from Firebase listener if necessary
// Example: off(urinDataRef);
};
}, []);

const createChart = (data) => {
if (!chartRef.current) return;

const ctx = chartRef.current.getContext('2d');
new Chart(ctx, {
type: 'pie',
data: {
labels: Object.keys(data),
datasets: [{
label: 'Urin Data',
data: Object.values(data),
backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
}],
},
});
};

return (
<div>
<canvas ref={chartRef} id="pieChartUrin"></canvas>
</div>
);
};

export default PieChartUrin;
