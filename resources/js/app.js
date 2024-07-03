import React from 'react';
import ReactDOM from 'react-dom';
import GaugeChart from './components/GaugeChart';

if (document.getElementById('app')) {
    ReactDOM.render(<GaugeChart />, document.getElementById('app'));
}
