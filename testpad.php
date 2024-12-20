<?php
session_start();
$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'our_website';

// Create connection
$con = mysqli_connect($hname, $uname, $pass, $db);

// Check connection
if (!$con) {
    die("Cannot Connect to Database: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collecting data from the POST request
    $name = mysqli_real_escape_string($con, $_POST['fullname']);
    $phone_no = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $adults = mysqli_real_escape_string($con, $_POST['adults']);
    $children = mysqli_real_escape_string($con, $_POST['children']);
    $total = mysqli_real_escape_string($con, $_POST['totalGuests']);
    $checkin = mysqli_real_escape_string($con, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($con, $_POST['checkout']);
    $total_amount = mysqli_real_escape_string($con, $_POST['totalAmount']);
    $request = mysqli_real_escape_string($con, $_POST['special']);

    // Insert query with corrected column names
    $query = "INSERT INTO user_data_table (name, phone_no, email, adults, children, total, `check-in`, `check-out`, total_amount, request) 
              VALUES ('$name', '$phone_no', '$email', '$adults', '$children', '$total', '$checkin', '$checkout', '$total_amount', '$request')";

    if (mysqli_query($con, $query)) {
        // Set session variable to indicate booking was confirmed
    $_SESSION['booking_confirmed'] = true;
        echo "success"; // Return a simple success response
    } else {
        echo "Error: " . mysqli_error($con);
    }
    exit; // Ensure no further output is sent after this
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Sai Farmhouse - Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url('pg3.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
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
        
        .navbar a.active {
            color: #80d4ff;
            /* Highlight color for the active link */
            font-weight: bold;
            /* Make the active link bold */
        }
        
        .container {
            width:  90%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            color: #555;
        }
        
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        textarea {
            resize: vertical;
            height: 100px;
        }
        
        .amount {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            text-align: right;
        }
        
        .next-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        
        .next-btn:hover {
            background-color: #0056b3;
        }
        
        .error-message {
            color: red;
            font-size: 14px;
            display: none;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="TNEW2.php">About Us</a>
        <a href="TNEW3.php" class="active">Booking</a>
        <a href="MyBooking.php">My Booking</a>
    </div>
    <div class="container">
        <h2>Booking Details</h2>
        <form method="POST" action="">
            <label for="fullname">Enter Your Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="phone">Enter Your Phone Number:</label>
            <input type="tel" id="phone" name="phone" placeholder="10-digit Indian Phone Number" required maxlength="10" minlength="10" pattern="\d{10}">
            <div id="phone-error" class="error-message">Please enter a valid 10-digit phone number.</div>

            <label for="email">Enter Your E-mail:</label>
            <input type="email" id="email" name="email" required>
            <div id="email-error" class="error-message">Please enter a valid email address.</div>

            <label for="adults">Number of Adults Visiting:</label>
            <select id="adults" name="adults" required>
                <option value="1">1 Adult</option>
                <option value="2">2 Adults</option>
                <option value="3">3 Adults</option>
                <option value="4">4 Adults</option>
            </select>

            <label for="children">Number of Children Visiting:</label>
            <select id="children" name="children">
                <option value="0">0 Children</option>
                <option value="1">1 Child</option>
                <option value="2">2 Children</option>
                <option value="3">3 Children</option>
            </select>

            <label for="totalGuests">Total Number of Guests:</label>
            <input type="text" id="totalGuests" name="totalGuests" readonly>

            <label for="checkin">Check-in Date:</label>
            <input type="date" id="checkin" name="checkin" required>

            <label for="checkout">Check-out Date:</label>
            <input type="date" id="checkout" name="checkout" required>

            <label for="special">Any special request? (carries seperate charges)</label>
            <textarea id="special" name="special"></textarea>

            <div class="amount">
                Total Amount: <span id="totalAmount">0</span> Rs
            </div>

            <button type ="button" class="next-btn" onclick="handleSubmit()">CONFIRM BOOKING</button>
        </form>
    </div>

    <script>
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        const totalAmount = document.getElementById('totalAmount');
        const adultsInput = document.getElementById('adults');
        const childrenInput = document.getElementById('children');
        const totalGuestsInput = document.getElementById('totalGuests');
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phone-error');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');

        const today = new Date().toISOString().split('T')[0];
        checkinInput.min = today;

        function calculateAmount() {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);

            if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                const diffTime = Math.abs(checkoutDate - checkinDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const minimumStay = 1;
                const costPerDay = 1500;

                const totalCost = Math.max(diffDays, minimumStay) * costPerDay;
                totalAmount.textContent = totalCost;
            } else {
                totalAmount.textContent = '0';
            }
        }

        function updateTotalGuests() {
            const totalGuests = parseInt(adultsInput.value) + parseInt(childrenInput.value);
            totalGuestsInput.value = totalGuests;
        }

        function validateGuestCount() {
            const totalGuests = parseInt(adultsInput.value) + parseInt(childrenInput.value);
            if (totalGuests > 4) {
                alert("The total number of guests cannot exceed 4.");
                return false;
            }
            return true;
        }

        function initializeTotalGuests() {
            updateTotalGuests();
        }

        adultsInput.addEventListener('change', function() {
            updateTotalGuests();
            validateGuestCount();
        });

        childrenInput.addEventListener('change', function() {
            updateTotalGuests();
            validateGuestCount();
        });

        checkinInput.addEventListener('change', function() {
            const checkinDate = new Date(checkinInput.value);
            checkinDate.setDate(checkinDate.getDate() + 1);
            checkoutInput.min = checkinDate.toISOString().split('T')[0];
            calculateAmount();
        });

        checkoutInput.addEventListener('change', calculateAmount);

        function handleSubmit() {
            // Confirmation alert
            const confirmBooking = confirm("Are you sure, all the details are filled correct?");
            if (!confirmBooking) {
            return; // Exit the function if the user clicks "Cancel"
            }
            const fullname = document.getElementById('fullname').value;
            const phone = phoneInput.value;
            const email = emailInput.value;
            const adults = adultsInput.value;
            const children = childrenInput.value;
            const checkin = checkinInput.value;
            const checkout = checkoutInput.value;
            const special = document.getElementById('special').value;

            phoneError.style.display = 'none';
            emailError.style.display = 'none';

            if (!phone.match(/^\d{10}$/)) {
                phoneError.style.display = 'block';
                return;
            }

            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                emailError.style.display = 'block';
                return;
            }

            const checkinDate = new Date(checkin);
            const checkoutDate = new Date(checkout);

            if (checkinDate >= checkoutDate) {
                alert("Check-out date must be after the check-in date.");
                return;
            }

            if (!fullname || !phone || !email || !adults || !checkin || !checkout) {
                alert("Please fill in all the required fields.");
                return;
            }

            if (!validateGuestCount()) {
                return;
            }

            const bookingDetails = {
                fullname: fullname,
                phone: phone,
                email: email,
                adults: adults,
                children: children,
                checkin: checkin,
                checkout: checkout,
                special: special,
                totalGuests: totalGuestsInput.value,
                totalAmount: totalAmount.textContent
            };

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(bookingDetails)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    window.location.href = "NEW4.php"; // Redirect on success without alert
 } else {
                    console.error(data); // Log error
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("There was an error submitting your booking. Please try again.");
            });
        }

        // Initialize total guests on page load
        window.onload = initializeTotalGuests;
    </script>
</body>
</html>