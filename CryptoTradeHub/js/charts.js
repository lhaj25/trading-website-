/**
 * CryptoTrade - Charts JavaScript File
 * Contains all functions for creating and updating charts on the trading page
 */

// Mock price data for charts
function generateMockPriceData(basePrice, days, volatility) {
    const data = [];
    let currentPrice = basePrice;
    const now = new Date();
    
    for (let i = days; i >= 0; i--) {
        const date = new Date(now);
        date.setDate(date.getDate() - i);
        
        // Add some randomness to the price
        const change = (Math.random() - 0.5) * volatility;
        currentPrice = Math.max(0.01, currentPrice * (1 + change));
        
        data.push({
            date: date,
            price: currentPrice,
            open: currentPrice * (1 - Math.random() * 0.02),
            high: currentPrice * (1 + Math.random() * 0.03),
            low: currentPrice * (1 - Math.random() * 0.03),
            volume: Math.round(Math.random() * 100000)
        });
    }
    
    return data;
}

// Function to create price chart
function createPriceChart(canvasId, cryptoData, timeframe = '1d', chartType = 'candle') {
    // Get the canvas element
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    // Get the selected crypto data
    if (!cryptoData) return;
    
    // Generate mock price history data based on current price
    let days;
    switch (timeframe) {
        case '1h': days = 1; break;
        case '1d': days = 30; break;
        case '1w': days = 90; break;
        case '1m': days = 180; break;
        case '1y': days = 365; break;
        default: days = 30;
    }
    
    const priceData = generateMockPriceData(cryptoData.price, days, 0.02);
    
    // Prepare data for Chart.js based on chart type
    let chartData, chartOptions;
    
    if (chartType === 'line') {
        // Line chart configuration
        chartData = {
            labels: priceData.map(data => {
                // Format date based on timeframe
                if (timeframe === '1h') {
                    return data.date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                } else if (timeframe === '1d') {
                    return data.date.toLocaleDateString([], { month: 'short', day: 'numeric' });
                } else {
                    return data.date.toLocaleDateString([], { month: 'short', day: 'numeric' });
                }
            }),
            datasets: [{
                label: `${cryptoData.symbol} Price (USD)`,
                data: priceData.map(data => data.price),
                borderColor: '#3a7bd5',
                backgroundColor: 'rgba(58, 123, 213, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.2,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHitRadius: 10
            }]
        };
        
        chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Price: $${context.raw.toFixed(2)}`;
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 10
                    }
                },
                y: {
                    position: 'right',
                    grid: {
                        borderDash: [5, 5]
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            }
        };
    } else {
        // Candlestick chart using a plugin
        // For simplicity, we'll simulate a candlestick chart using a bar chart
        const greenColor = 'rgba(40, 167, 69, 0.8)';
        const redColor = 'rgba(220, 53, 69, 0.8)';
        
        const calculateBarColors = () => {
            return priceData.map(data => data.price >= data.open ? greenColor : redColor);
        };
        
        chartData = {
            labels: priceData.map(data => {
                if (timeframe === '1h') {
                    return data.date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                } else if (timeframe === '1d') {
                    return data.date.toLocaleDateString([], { month: 'short', day: 'numeric' });
                } else {
                    return data.date.toLocaleDateString([], { month: 'short', day: 'numeric' });
                }
            }),
            datasets: [
                {
                    // High-Low line
                    label: 'Range',
                    data: priceData.map(data => ({
                        y: [data.low, data.high],
                        x: null // This will be set by Chart.js
                    })),
                    borderWidth: 1,
                    borderColor: priceData.map(data => data.price >= data.open ? greenColor : redColor),
                    type: 'bar',
                    barPercentage: 0.1
                },
                {
                    // Open-Close body
                    label: 'OHLC',
                    data: priceData.map(data => ({
                        y: [
                            Math.min(data.open, data.price),
                            Math.max(data.open, data.price)
                        ],
                        x: null
                    })),
                    backgroundColor: calculateBarColors(),
                    borderColor: calculateBarColors(),
                    borderWidth: 0,
                    type: 'bar',
                    barPercentage: 0.5
                }
            ]
        };
        
        chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const data = priceData[index];
                            return [
                                `O: $${data.open.toFixed(2)}`,
                                `H: $${data.high.toFixed(2)}`,
                                `L: $${data.low.toFixed(2)}`,
                                `C: $${data.price.toFixed(2)}`,
                                `V: ${data.volume.toLocaleString()}`
                            ];
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 10
                    }
                },
                y: {
                    position: 'right',
                    grid: {
                        borderDash: [5, 5]
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            }
        };
    }
    
    // Destroy previous chart if exists
    if (window.priceChart) {
        window.priceChart.destroy();
    }
    
    // Create new chart
    window.priceChart = new Chart(canvas, {
        type: chartType === 'line' ? 'line' : 'bar',
        data: chartData,
        options: chartOptions
    });
    
    return window.priceChart;
}

// Function to update chart when user changes timeframe or chart type
function updateChart(timeframe, chartType) {
    // Get the current crypto data from the page
    const selectedSymbol = document.querySelector('.selected-market h2')?.textContent.match(/\(([^)]+)\)/)?.[1] || 'BTC';
    const currentPrice = parseFloat(document.querySelector('.current-price')?.textContent.replace('$', '').replace(',', '') || '0');
    
    const cryptoData = {
        symbol: selectedSymbol,
        price: currentPrice
    };
    
    createPriceChart('priceChart', cryptoData, timeframe, chartType);
}

// Initialize charts when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the trading page
    const priceChartCanvas = document.getElementById('priceChart');
    if (!priceChartCanvas) return;
    
    // Get the selected cryptocurrency data
    const selectedSymbol = document.querySelector('.selected-market h2')?.textContent.match(/\(([^)]+)\)/)?.[1] || 'BTC';
    const currentPrice = parseFloat(document.querySelector('.current-price')?.textContent.replace('$', '').replace(',', '') || '0');
    
    if (!selectedSymbol || !currentPrice) return;
    
    const cryptoData = {
        symbol: selectedSymbol,
        price: currentPrice
    };
    
    // Create initial chart
    createPriceChart('priceChart', cryptoData);
    
    // Set up event listeners for timeframe buttons
    const timeframeButtons = document.querySelectorAll('.timeframe-btn');
    timeframeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all timeframe buttons
            timeframeButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the selected timeframe and chart type
            const timeframe = this.getAttribute('data-timeframe');
            const chartType = document.querySelector('.chart-type-btn.active').getAttribute('data-type');
            
            // Update the chart
            updateChart(timeframe, chartType);
        });
    });
    
    // Set up event listeners for chart type buttons
    const chartTypeButtons = document.querySelectorAll('.chart-type-btn');
    chartTypeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all chart type buttons
            chartTypeButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the selected timeframe and chart type
            const timeframe = document.querySelector('.timeframe-btn.active').getAttribute('data-timeframe');
            const chartType = this.getAttribute('data-type');
            
            // Update the chart
            updateChart(timeframe, chartType);
        });
    });
});
