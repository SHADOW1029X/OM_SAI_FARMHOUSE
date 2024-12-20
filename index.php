<?php
// Database connection
$servername = "localhost"; // No change needed
$username = "root"; // Change to your MySQL username
$password = ""; // Leave empty if using XAMPP default
$dbname = "our_website"; // Make sure this is your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$sql = "SELECT `check-in`, `check-out`, `payment_status` FROM user_data_table"; // Ensure this table name is correct
$result = $conn->query($sql);

$user_data = [];
if ($result && $result->num_rows > 0) { // Check for valid result
    while ($row = $result->fetch_assoc()) {
        // Ensure proper date formatting for JavaScript parsing
        $row['check-in'] = date('Y-m-d', strtotime($row['check-in']));
        $row['check-out'] = date('Y-m-d', strtotime($row['check-out']));
        $user_data[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Sai Farmhouse - Home</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: url('pg1.jpeg') no-repeat center center fixed;
            background-size: cover;
            opacity: 0;
            /* Start with opacity 0 for fade-in effect */
            animation: fadeIn 1s forwards;
            /* Apply fade-in animation */
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
                /* End with full opacity */
            }
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }
        
        .container {
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 1200px;
            margin: 20px;
            position: relative;
            z-index: 1;
        }
        
        .heading {
            font-size: 40px;
            font-weight: 600;
            margin: 60px 0 20px 0;
            /* Added top margin to push it below the navbar */
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            background: linear-gradient(90deg, #66a3ff, #80d4ff);
            -webkit-background-clip: text;
            color: transparent;
            position: relative;
            z-index: 1;
        }
        
        .address {
            font-size: 20px;
            text-align: center;
            margin-bottom: 30px;
            color: red;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }
        /* Navigation Bar Styles */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
            padding: 10px 0;
            /* Reduced padding to save space */
            z-index: 100;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        
        .navbar a {
            margin-right: 30px;
            color: white;
            text-decoration: none;
            font-size: 18px;
            /* Adjusted font size */
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        
        .navbar a::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #66a3ff;
            transition: width 0.3s ease, background-color 0.3s ease;
            position: absolute;
            left: 50%;
            bottom: -5px;
            transform: translateX(-50%);
        }
        
        .navbar a:hover {
            color: #80d4ff;
            transform: scale(1.1);
        }
        
        .navbar a:hover::after {
            width: 100%;
            background-color: #007bff;
        }
        /* Active link style */
        
        .navbar a.active {
            color: #80d4ff;
            /* Highlight color for active link */
            font-weight: 700;
            /* Make it bold */
        }
        
        .section {
            display: flex;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        
        .section img {
            width: 50%;
            object-fit: cover;
        }
        
        .section .text {
            width: 50%;
            padding: 20px;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        
        .section .text h2 {
            margin: 0 0 10px 0;
            font-size: 26px;
            font-weight: 600;
            color: #34495e;
        }
        
        .section .text p {
            margin: 0;
            font-size: 18px;
            color: #7f8c8d;
            line-height: 1.6;
            font-weight: 400;
        }
        
        .book-now-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 30px;
            background: linear-gradient(135deg, #66a3ff, #007bff);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 24px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.4s ease;
            z-index: 1000;
            perspective: 500px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            animation: bounce 2s infinite ease-in-out;
        }
        /* 3D hover effect with glowing border */
        
        .book-now-btn:hover {
            transform: rotateX(20deg) translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 255, 255, 0.7);
            background: linear-gradient(135deg, #0056b3, #007bff);
        }
        
        .book-now-btn:active {
            transform: scale(0.95) translateY(2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        /* Bouncing animation */
        
        @keyframes bounce {
            0%,
            100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        .calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #34495e;
    color: white;
    border-radius: 10px;
}

.calendar-header h2 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    animation: fadeInHeader 0.5s ease-in-out;
}

@keyframes fadeInHeader {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.calendar-header button {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.3s ease, color 0.3s ease;
}

.calendar-header button:hover {
    color: #80d4ff;
    transform: scale(1.1);
}

.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.day {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    background: linear-gradient(to bottom, #ffffff, #f0f0f0);
    border: 1px solid #ddd;
    border-radius: 10px;
    height: 50px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.day.paid {
    background: linear-gradient(to bottom, #ff4d4d, #ff9999);
    color: white;
    font-weight: bold;
}

.day.pending {
    background: linear-gradient(to bottom, #ffeb3b, #ffe066);
    color: black;
    font-weight: bold;
}

.day:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}
.current-day {
    background-color: #007bff; /* Change this to your desired background color */
    color: blue; /* White text for the current day */
    font-weight: bold; /* make the current day bold */
}
.tooltip {
    display: none;
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 10;
}

.day:hover .tooltip {
    display: block;
}

.info {
    margin-top: 10px;
    font-size: 14px;
    color: #555; /* Slightly darker text for info */
    text-align: center;
}
.calendar-section {
    display: flex;
    margin-bottom: 20px; /* Space between sections */
    border-radius: 10px; /* Rounded corners */
    overflow: hidden; /* To ensure child elements don't overflow */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Shadow for depth */
}

.calendar-container {
    max-width: 1010px !important;  /* Increase the max-width to make the calendar wider */
    width: 100%;
    margin: 20px auto;
    padding: 40px;  /* Increase padding for more space inside the container */
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    animation: fadeIn 0.5s ease-in-out;
}


.text {
    width: 780px; /* Increase the width to make the text section wider */
    padding: 20px; /* Keep padding for spacing */
    background: white !important; /* Ensures white background */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center content vertically */
    z-index: 10; /* Ensure it appears above other elements */
    position: relative; /* Adjust position to avoid overlap */
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    font-family: 'Arial', sans-serif; /* Modern font for readability */
    line-height: 1.6;
    color: #555; /* Neutral text color retained */
}

.text h2 {
    margin-bottom: 15px;
    font-size: 28px;
    color: #2c3e50; /* Darker shade for headings */
    text-align: center;
}

.text p {
    margin: 0; /* Reset margin */
    font-size: 16px; /* Font size for paragraph */
    color: #555; /* Darker text for better readability */
    line-height: 1.5; /* Line height for better readability */
}
.info-list {
    list-style: none; /* Remove default list styling */
    padding: 0;
    margin: 0;
}

.info-list li {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.color-box {
    width: 16px;
    height: 16px;
    display: inline-block;
    margin-right: 10px;
    border-radius: 40px; /* Slight rounding for a polished look */
}

.color-box.red {
    background-color: #ff4d4d; /* Red for booked dates */
}

.color-box.yellow {
    background-color: #ffeb3b; /* Yellow for pending dates */
}

.color-box.white {
    background-color: #ffffff; /* White for open dates */
    border: 1px solid #ccc; /* Border for visibility on white background */
}

.info-list strong {
    color: #34495e; /* Highlighted text for emphasis */
}

.recommendation {
    margin-top: 15px;
    color: #555;
    font-size: 14px;
    text-align: center;
    font-style: italic; /* Distinct styling for recommendations */
}

    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php" class="active">Home</a>
        <a href="TNEW2.php">About Us</a>
        <a href="TNEW3.php">Booking</a>
        <a href="MyBooking.php">My Booking</a>
    </div>

    <div class="heading">
        WELCOME TO OM SAI FARMHOUSE
    </div>

    <div class="address"><b>
        AT. SARONDA, TAL-UMBERGAON, DIST-VALSAD, GUJARAT-396135, NEAR LAXMI INDUSTRIAL PARK.
    </b></div>

    <div class="container">
        <!-- Upper Section: Hotel Building -->
        <div class="section upper-left">
            <img src="img1.jpeg" alt="Hotel Building Collage">
            <div class="text upper-right">
                <h2>Speciality Of Our Om Sai Farmhouse</h2>
                <p>Experience the serene and tranquil atmosphere of our nature-friendly farmhouse for just 1,500 INR per Day & Night(24 hours). Surrounded by lush greenery, beautiful trees, and chirping birds, our farmhouse offers a unique blend of comfort
                    and natural beauty.</p>
            </div>
        </div>

        <!-- Middle Section: Tourist Places -->
        <div class="section middle-left">
            <div class="text middle-right">
                <h2>Explore Nearby Attractions</h2>
                <p>Stay at Om Sai Farmhouse and explore the best of Daman! From the pristine beaches of Saronda and Nargol to the sacred Nirmala Devi Temple, our location offers easy access to a variety of popular tourist destinations.</p>
            </div>
            <img src="img2.jpeg" alt="Tourist Places Collage">
        </div>

        <!-- Lower Section: Greenery, Entrance-Exit Path, and Parking Area -->
        <div class="section lower-left">
            <img src="img3.jpeg" alt=" Greenery and Entrance-Exit Path Collage">
            <div class="text lower-right">
                <h2>Convenient Access and Natural Surroundings</h2>
                <p>Enjoy easy access through our well-maintained entrance-exit path, ample parking space, and be surrounded by lush greenery that enhances the peaceful ambiance of Om Sai Farmhouse.</p>
            </div>
        </div>
    </div>
    <div class="calendar-section">
    <div class="calendar-container">
        <div class="calendar-header">
            <button class="button" id="prevMonth">Previous</button>
            <h2 id="monthYear"></h2>
            <button class="button" id="nextMonth">Next</button>
        </div>
        <div class="calendar" id="calendar"></div>
    </div>
    <div class="text">
    <h2>Booking Information</h2>
    <ul class="info-list">
        <li>
            <span class="color-box red"></span>
            <strong>Red Dates:</strong> These dates are already booked and confirmed with payment, making them unavailable for other reservations.
        </li>
        <li>
            <span class="color-box yellow"></span>
            <strong>Yellow Dates:</strong> These dates are tentatively booked, but payment is pending. If you’re interested, you can still book and confirm them by completing the payment.
        </li>
        <li>
            <span class="color-box white"></span>
            <strong>White Dates:</strong> These dates are open and ready for booking, with no prior reservations.
        </li>
    </ul>
    <p class="recommendation">
        <em>We recommend confirming your booking early to secure your preferred dates!</em>
    </p>
</div>

    <script>
    const userData = <?php echo json_encode($user_data); ?>;
    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    function createCalendar(year, month) {
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = ''; // Clear previous calendar
    const monthYear = document.getElementById('monthYear');
    monthYear.innerText = `${month + 1}/${year}`; // Display current month and year

    // Array of day names
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    // Add day names to the calendar
    dayNames.forEach(day => {
        const dayCell = document.createElement('div');
        dayCell.classList.add('day');
        dayCell.innerText = day;
        calendar.appendChild(dayCell);
    });

    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();

    // Add empty cells for days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.classList.add('day');
        calendar.appendChild(emptyCell);
    }

    // Add day cells
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(Date.UTC(year, month, day)); // Ensure UTC date
        const cell = document.createElement('div');
        cell.classList.add('day');
        cell.innerText = day;

        userData.forEach(user => {
            const checkInDate = new Date(user['check-in'] + 'T00:00:00Z');
            const checkOutDate = new Date(user['check-out'] + 'T00:00:00Z');
            const paymentStatus = user.payment_status;

            // Highlight all dates between check-in and check-out, including check-in date
            if (date >= checkInDate && date <= checkOutDate) {
                if (paymentStatus === 'paid') {
                    cell.classList.add('paid');
                } else if (paymentStatus === 'pending') {
                    cell.classList.add('pending');
                }

                // Add tooltip with additional information
                const tooltip = document.createElement('div');
                tooltip.classList.add('tooltip');
                tooltip.innerText = `Status: ${paymentStatus}`;
                cell.appendChild(tooltip);
            }
        });

        calendar.appendChild(cell);
    }
}

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        createCalendar(currentYear, currentMonth);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        createCalendar(currentYear, currentMonth);
    });

    // Create calendar for the current month
    createCalendar(currentYear, currentMonth);
    
</script>

    <!-- NEXT Button -->
    <a href="TNEW2.php" class="book-now-btn">NEXT</a>

</body>

</html>