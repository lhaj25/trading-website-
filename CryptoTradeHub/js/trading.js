/**
 * CryptoTrade - Trading JavaScript File
 * Contains all trading functionality and order management
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the trading page
    const tradingPage = document.querySelector('.trading-page');
    if (!tradingPage) return;
    
    // Trading form calculations
    const buyAmountInput = document.getElementById('buy-amount');
    const buyPriceInput = document.getElementById('buy-price');
    const buyTotalInput = document.getElementById('buy-total');
    
    const sellAmountInput = document.getElementById('sell-amount');
    const sellPriceInput = document.getElementById('sell-price');
    const sellTotalInput = document.getElementById('sell-total');
    
    // Calculate total when amount is changed for buy form
    if (buyAmountInput && buyPriceInput && buyTotalInput) {
        buyAmountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            const price = parseFloat(buyPriceInput.value) || 0;
            buyTotalInput.value = (amount * price).toFixed(2);
        });
    }
    
    // Calculate total when amount is changed for sell form
    if (sellAmountInput && sellPriceInput && sellTotalInput) {
        sellAmountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            const price = parseFloat(sellPriceInput.value) || 0;
            sellTotalInput.value = (amount * price).toFixed(2);
        });
    }
    
    // Handle amount shortcuts (25%, 50%, 75%, 100%)
    const buyShortcuts = document.querySelectorAll('#buy-tab .shortcut-btn');
    buyShortcuts.forEach(button => {
        button.addEventListener('click', function() {
            const percent = parseInt(this.getAttribute('data-percent')) || 0;
            const maxAmount = 1; // In a real app, this would be the user's balance
            
            buyAmountInput.value = (maxAmount * (percent / 100)).toFixed(4);
            buyAmountInput.dispatchEvent(new Event('input'));
        });
    });
    
    const sellShortcuts = document.querySelectorAll('#sell-tab .shortcut-btn');
    sellShortcuts.forEach(button => {
        button.addEventListener('click', function() {
            const percent = parseInt(this.getAttribute('data-percent')) || 0;
            const maxAmount = 0.5; // In a real app, this would be the user's balance
            
            sellAmountInput.value = (maxAmount * (percent / 100)).toFixed(4);
            sellAmountInput.dispatchEvent(new Event('input'));
        });
    });
    
    // Handle buy form submission
    const buyForm = document.getElementById('buy-form');
    if (buyForm) {
        buyForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const amount = parseFloat(buyAmountInput.value) || 0;
            const price = parseFloat(buyPriceInput.value) || 0;
            const total = parseFloat(buyTotalInput.value) || 0;
            
            if (amount <= 0) {
                showNotification('Please enter a valid amount', 'error');
                return;
            }
            
            // In a real app, you would send this order to a server
            // For this demo, we'll simulate a successful order
            const symbol = document.querySelector('.selected-market h2')?.textContent.match(/\(([^)]+)\)/)?.[1] || 'BTC';
            
            // Add the order to the open orders table
            addOrderToTable('open-orders-tab', {
                date: new Date(),
                pair: symbol + '/USD',
                type: 'Market',
                side: 'Buy',
                price: price,
                amount: amount,
                filled: 0,
                total: total
            });
            
            // Reset form
            buyForm.reset();
            
            // Show success notification
            showNotification(`Successfully placed order to buy ${amount} ${symbol}`, 'success');
            
            // Simulate order being filled after 3 seconds
            setTimeout(() => {
                // Remove from open orders
                const openOrdersTable = document.querySelector('#open-orders-tab tbody');
                if (openOrdersTable && openOrdersTable.children.length > 1) {
                    openOrdersTable.removeChild(openOrdersTable.children[1]); // Skip empty state row
                    
                    // Check if table is now empty
                    if (openOrdersTable.children.length <= 1) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.className = 'empty-state';
                        emptyRow.innerHTML = '<td colspan="9">No open orders</td>';
                        openOrdersTable.appendChild(emptyRow);
                    }
                }
                
                // Add to order history
                addOrderToTable('order-history-tab', {
                    date: new Date(),
                    pair: symbol + '/USD',
                    type: 'Market',
                    side: 'Buy',
                    price: price,
                    amount: amount,
                    filled: amount,
                    total: total,
                    status: 'Filled'
                });
                
                // Update user balance
                updateUserBalance(symbol, amount, -total);
                
                // Show notification
                showNotification(`Order to buy ${amount} ${symbol} has been filled`, 'success');
            }, 3000);
        });
    }
    
    // Handle sell form submission
    const sellForm = document.getElementById('sell-form');
    if (sellForm) {
        sellForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const amount = parseFloat(sellAmountInput.value) || 0;
            const price = parseFloat(sellPriceInput.value) || 0;
            const total = parseFloat(sellTotalInput.value) || 0;
            
            if (amount <= 0) {
                showNotification('Please enter a valid amount', 'error');
                return;
            }
            
            // Check if user has enough balance
            const symbol = document.querySelector('.selected-market h2')?.textContent.match(/\(([^)]+)\)/)?.[1] || 'BTC';
            const currentBalance = parseFloat(document.querySelector(`.balance-item:nth-child(2) .balance-value`).textContent) || 0;
            
            if (amount > currentBalance) {
                showNotification(`Insufficient ${symbol} balance`, 'error');
                return;
            }
            
            // Add the order to the open orders table
            addOrderToTable('open-orders-tab', {
                date: new Date(),
                pair: symbol + '/USD',
                type: 'Market',
                side: 'Sell',
                price: price,
                amount: amount,
                filled: 0,
                total: total
            });
            
            // Reset form
            sellForm.reset();
            
            // Show success notification
            showNotification(`Successfully placed order to sell ${amount} ${symbol}`, 'success');
            
            // Simulate order being filled after 3 seconds
            setTimeout(() => {
                // Remove from open orders
                const openOrdersTable = document.querySelector('#open-orders-tab tbody');
                if (openOrdersTable && openOrdersTable.children.length > 1) {
                    openOrdersTable.removeChild(openOrdersTable.children[1]); // Skip empty state row
                    
                    // Check if table is now empty
                    if (openOrdersTable.children.length <= 1) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.className = 'empty-state';
                        emptyRow.innerHTML = '<td colspan="9">No open orders</td>';
                        openOrdersTable.appendChild(emptyRow);
                    }
                }
                
                // Add to order history
                addOrderToTable('order-history-tab', {
                    date: new Date(),
                    pair: symbol + '/USD',
                    type: 'Market',
                    side: 'Sell',
                    price: price,
                    amount: amount,
                    filled: amount,
                    total: total,
                    status: 'Filled'
                });
                
                // Update user balance
                updateUserBalance(symbol, -amount, total);
                
                // Show notification
                showNotification(`Order to sell ${amount} ${symbol} has been filled`, 'success');
            }, 3000);
        });
    }
    
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(`${tab}-tab`).classList.add('active');
        });
    });
    
    // Order history tab switching
    const orderTabs = document.querySelectorAll('.order-tab');
    const orderTabContents = document.querySelectorAll('.order-table-container');
    
    orderTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and containers
            orderTabs.forEach(t => t.classList.remove('active'));
            orderTabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding container
            this.classList.add('active');
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Market search functionality
    const marketSearch = document.getElementById('market-search');
    if (marketSearch) {
        marketSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const marketItems = document.querySelectorAll('.market-item');
            
            marketItems.forEach(item => {
                const symbol = item.querySelector('.symbol').textContent.toLowerCase();
                const name = item.querySelector('.name').textContent.toLowerCase();
                
                if (symbol.includes(searchTerm) || name.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});

// Helper function to add an order to a table
function addOrderToTable(tableId, order) {
    const table = document.querySelector(`#${tableId} tbody`);
    if (!table) return;
    
    // Remove empty state row if present
    const emptyRow = table.querySelector('.empty-state');
    if (emptyRow) {
        table.removeChild(emptyRow);
    }
    
    // Create new row
    const row = document.createElement('tr');
    
    // Format date
    const formattedDate = order.date.toLocaleString([], {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Create row content based on table type
    if (tableId === 'open-orders-tab') {
        row.innerHTML = `
            <td>${formattedDate}</td>
            <td>${order.pair}</td>
            <td>${order.type}</td>
            <td class="${order.side.toLowerCase()}">${order.side}</td>
            <td>$${order.price.toFixed(2)}</td>
            <td>${order.amount.toFixed(6)}</td>
            <td>${order.filled.toFixed(6)} / ${order.amount.toFixed(6)}</td>
            <td>$${order.total.toFixed(2)}</td>
            <td><button class="btn btn-small cancel-order">Cancel</button></td>
        `;
        
        // Add event listener to cancel button
        const cancelButton = row.querySelector('.cancel-order');
        cancelButton.addEventListener('click', function() {
            table.removeChild(row);
            
            // Check if table is now empty
            if (table.children.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-state';
                emptyRow.innerHTML = '<td colspan="9">No open orders</td>';
                table.appendChild(emptyRow);
            }
            
            // Show notification
            showNotification('Order cancelled successfully', 'success');
        });
    } else {
        row.innerHTML = `
            <td>${formattedDate}</td>
            <td>${order.pair}</td>
            <td>${order.type}</td>
            <td class="${order.side.toLowerCase()}">${order.side}</td>
            <td>$${order.price.toFixed(2)}</td>
            <td>${order.amount.toFixed(6)}</td>
            <td>$${order.total.toFixed(2)}</td>
            <td>${order.status}</td>
        `;
    }
    
    // Add row to table
    table.appendChild(row);
}

// Helper function to update user balance
function updateUserBalance(symbol, symbolAmount, usdAmount) {
    // Update USD balance
    const usdBalanceElement = document.querySelector('.balance-item:first-child .balance-value');
    if (usdBalanceElement) {
        const currentUsd = parseFloat(usdBalanceElement.textContent.replace('$', '').replace(',', '')) || 0;
        usdBalanceElement.textContent = `$${(currentUsd + usdAmount).toFixed(2)}`;
    }
    
    // Update crypto balance
    const cryptoBalanceElement = document.querySelector('.balance-item:nth-child(2) .balance-value');
    if (cryptoBalanceElement) {
        const currentCrypto = parseFloat(cryptoBalanceElement.textContent) || 0;
        cryptoBalanceElement.textContent = (currentCrypto + symbolAmount).toFixed(4);
    }
}

// Helper function to show notifications
function showNotification(message, type = 'info') {
    // Create notification element if it doesn't exist
    let notification = document.querySelector('.trading-notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.className = 'trading-notification';
        document.body.appendChild(notification);
    }
    
    // Set notification content and type
    notification.textContent = message;
    notification.className = `trading-notification ${type}`;
    
    // Show notification
    notification.classList.add('show');
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Add custom CSS for notifications
const style = document.createElement('style');
style.textContent = `
.trading-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 4px;
    color: white;
    font-weight: 600;
    z-index: 9999;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s ease;
}

.trading-notification.show {
    opacity: 1;
    transform: translateX(0);
}

.trading-notification.success {
    background-color: #28a745;
}

.trading-notification.error {
    background-color: #dc3545;
}

.trading-notification.info {
    background-color: #17a2b8;
}

.trading-notification.warning {
    background-color: #ffc107;
    color: #212529;
}

td.buy {
    color: #28a745;
    font-weight: 600;
}

td.sell {
    color: #dc3545;
    font-weight: 600;
}
`;
document.head.appendChild(style);
