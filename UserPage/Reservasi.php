<?php 

include "function.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/Reservasi.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="row">
                    <h1 class="page-name">Reservasi Meja</h1>
                </div>
                <div class="row">
                    <p>Masukkan jumlah orang yang akan datang dan pilih meja yang tersedia</p>
                </div>
            </div>
        </div>
    </div>

    <div class="min-vh-100 bg-light">
        <div class="container px-4 py-5">

            <!-- Top Section - Number of People -->
            <div class="card-section">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h3 mb-4 reservation-header">Jumlah Orang</h2>
                        <select id="numberOfPeople" class="form-select form-select-lg">
                            <option value="" selected disabled>Pilih jumlah orang</option>
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                            <option value="4">4 Orang</option>
                            <option value="5">5 Orang</option>
                            <option value="6">6 Orang</option>
                            <option value="7">7 Orang</option>
                            <option value="8">8 Orang</option>
                            <option value="8+">Lebih dari 8 Orang</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Availability Grid -->
            <div class="card-section">
                <h2 class="h3 mb-5 reservation-header">Ketersediaan Meja</h2>

                <div class="row g-4" id="tablesContainer">
                    <!-- Tables will be dynamically inserted here -->
                </div>

                <!-- Selected Info -->
                <div id="reservationSummary" class="reservation-summary d-none">
                    <h3 class="h5 reservation-header mb-3">Reservasi Anda</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Meja</p>
                            <p class="reservation-header mb-0" id="selectedTable">-</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Waktu</p>
                            <p class="reservation-header mb-0" id="selectedTime">-</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Jumlah Orang</p>
                            <p class="reservation-header mb-0" id="selectedPeople">-</p>
                        </div>
                    </div>
                </div>

                <!-- Confirm Button -->
                <div class="mt-5 text-end">
                    <button id="confirmButton" class="confirm-btn" disabled>
                        Konfirmasi Reservasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Table data
        const tables = [
            { id: "1", number: 1, capacity: 2, availableSlots: ["10:00", "12:00", "14:00"], bookedSlots: ["18:00", "20:00"] },
            { id: "2", number: 2, capacity: 4, availableSlots: ["10:00", "12:00", "18:00"], bookedSlots: ["14:00", "20:00"] },
            { id: "3", number: 3, capacity: 2, availableSlots: ["12:00", "14:00", "20:00"], bookedSlots: ["10:00", "18:00"] },
            { id: "4", number: 4, capacity: 6, availableSlots: ["10:00", "18:00", "20:00"], bookedSlots: ["12:00", "14:00"] },
            { id: "5", number: 5, capacity: 4, availableSlots: ["14:00", "18:00", "20:00"], bookedSlots: ["10:00", "12:00"] },
            { id: "6", number: 6, capacity: 8, availableSlots: ["10:00", "12:00"], bookedSlots: ["14:00", "18:00", "20:00"] },
            { id: "7", number: 7, capacity: 2, availableSlots: [], bookedSlots: ["10:00", "12:00", "14:00", "18:00", "20:00"] },
            { id: "8", number: 8, capacity: 4, availableSlots: ["10:00", "14:00", "18:00"], bookedSlots: ["12:00", "20:00"] },
        ];

        // State variables
        let selectedTable = null;
        let selectedTime = null;
        let numberOfPeople = "";

        // DOM elements
        const tablesContainer = document.getElementById('tablesContainer');
        const reservationSummary = document.getElementById('reservationSummary');
        const selectedTableElement = document.getElementById('selectedTable');
        const selectedTimeElement = document.getElementById('selectedTime');
        const selectedPeopleElement = document.getElementById('selectedPeople');
        const confirmButton = document.getElementById('confirmButton');
        const numberOfPeopleSelect = document.getElementById('numberOfPeople');

        // Initialize the table grid
        function renderTables() {
            tablesContainer.innerHTML = '';
            
            tables.forEach(table => {
                const isAvailable = table.availableSlots.length > 0;
                const isSelected = selectedTable === table.id;
                
                const tableCard = document.createElement('div');
                tableCard.className = `col-12 col-sm-6 col-lg-3`;
                
                tableCard.innerHTML = `
                    <div class="table-card ${isSelected ? 'selected' : ''} ${!isAvailable ? 'unavailable' : ''}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h5 reservation-header mb-0">Meja ${table.number}</h3>
                            <span class="text-muted small">${table.capacity} Orang</span>
                        </div>
                        
                        ${isAvailable ? `
                            <div class="availability-indicator">
                                <span class="availability-dot available"></span>
                                <span class="text-success small">Tersedia</span>
                            </div>
                            
                            <div class="time-slots">
                                ${table.availableSlots.map(slot => `
                                    <button class="time-slot available ${isSelected && selectedTime === slot ? 'selected' : ''}" 
                                            data-table="${table.id}" data-time="${slot}">
                                        ${slot}
                                    </button>
                                `).join('')}
                            </div>
                        ` : `
                            <div class="availability-indicator">
                                <span class="availability-dot unavailable"></span>
                                <span class="text-secondary small">Penuh</span>
                            </div>
                            
                            <div class="time-slots">
                                ${table.bookedSlots.slice(0, 3).map(slot => `
                                    <div class="time-slot unavailable">${slot}</div>
                                `).join('')}
                            </div>
                        `}
                    </div>
                `;
                
                tablesContainer.appendChild(tableCard);
            });
            
            // Add event listeners to time slot buttons
            document.querySelectorAll('.time-slot.available').forEach(button => {
                button.addEventListener('click', function() {
                    const tableId = this.getAttribute('data-table');
                    const time = this.getAttribute('data-time');
                    
                    selectTable(tableId, time);
                });
            });
            
            updateReservationSummary();
            updateConfirmButton();
        }

        // Handle table selection
        function selectTable(tableId, time) {
            selectedTable = tableId;
            selectedTime = time;
            renderTables();
        }

        // Update reservation summary
        function updateReservationSummary() {
            if (selectedTable && selectedTime) {
                const table = tables.find(t => t.id === selectedTable);
                selectedTableElement.textContent = `Meja ${table.number}`;
                selectedTimeElement.textContent = selectedTime;
                selectedPeopleElement.textContent = numberOfPeople ? `${numberOfPeople} Orang` : "-";
                reservationSummary.classList.remove('d-none');
            } else {
                reservationSummary.classList.add('d-none');
            }
        }

        // Update confirm button state
        function updateConfirmButton() {
            if (numberOfPeople && selectedTable && selectedTime) {
                confirmButton.disabled = false;
            } else {
                confirmButton.disabled = true;
            }
        }

        // Handle confirm reservation
        function handleConfirmReservation() {
            if (numberOfPeople && selectedTable && selectedTime) {
                const table = tables.find(t => t.id === selectedTable);
                alert(
                    `Reservasi dikonfirmasi!\n\nMeja: ${table.number}\nWaktu: ${selectedTime}\nJumlah Orang: ${numberOfPeople}`
                );
            } else {
                alert("Mohon lengkapi semua informasi reservasi");
            }
        }

        // Event listeners
        numberOfPeopleSelect.addEventListener('change', function() {
            numberOfPeople = this.value;
            updateReservationSummary();
            updateConfirmButton();
        });

        confirmButton.addEventListener('click', handleConfirmReservation);

        // Initial render
        renderTables();
    </script>
</body>
</html>