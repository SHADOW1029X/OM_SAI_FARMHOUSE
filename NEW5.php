<?php
session_start();

if (!isset($_SESSION['cancellation_success']) || $_SESSION['cancellation_success'] !== true) {
    // Redirect to booking find page or another page
    header("Location: MyBooking.php"); // Change to your booking find page
    exit();
}

// After displaying the receipt, you may want to unset the session variable
unset($_SESSION['cancellation_success']);
$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'our_website';

// Create connection
$con = mysqli_connect($hname, $uname, $pass, $db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the most recent cancellation
$query = "SELECT * FROM cancellation_data_table ORDER BY `sr.no` DESC LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Update the current date in the cancellation_date column
    $cancellation_date = date('Y-m-d');
    $update_query = "UPDATE cancellation_data_table 
                     SET cancellation_date = '$cancellation_date' 
                     WHERE `sr.no` = " . $row['sr.no'];
    if (!mysqli_query($con, $update_query)) {
        die("Error updating cancellation date: " . mysqli_error($con));
    }
} else {
    die("No recent cancellation found.");
}

// Close the connection after all operations
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Sai Farmhouse - Cancellation Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url('pg5.jpeg');
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

        .receipt-container {
            width: 90%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            margin-top: 70px; /* Adjusted for the fixed navbar */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .receipt-container:hover {
            transform: scale(1.02);
        }

        h2 {
    text-align: center;
    color: red; /* Changed color to red */
    margin-bottom: 20px;
    font-size: 2.5em;
    background: none; /* Removed gradient background */
    -webkit-text-fill-color: red; /* Set red color for text fill */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Retained text shadow for better visibility */
    padding: 10px 0;
}


        .details {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }

        .details strong {
            color: #333;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="TNEW2.php">About Us</a>
        <a href="TNEW3.php">Booking</a>
        <a href="MyBooking.php">My Booking</a>
    </div>
    <div class="receipt-container">
        <h2>BOOKING CANCELLED</h2>
        <div class="details">
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($row['c_booking_id']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['c_name']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['c_phone_no']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['c_email']); ?></p>
            <p><strong>Adults:</strong> <?php echo htmlspecialchars($row['c_adults']); ?></p>
            <p><strong>Children:</strong> <?php echo htmlspecialchars($row['c_children']); ?></p>
            <p><strong>Total Guests:</strong> <?php echo htmlspecialchars($row['c_total']); ?></p>
            <p><strong>Check-in:</strong> <?php echo htmlspecialchars($row['c_check_in']); ?></p>
            <p><strong>Check-out:</strong> <?php echo htmlspecialchars($row['c_check_out']); ?></p>
            <p><strong>Total Amount:</strong> <?php echo htmlspecialchars($row['c_total_amount']); ?> Rs</p>
            <p><strong>Special Request:</strong> <?php echo htmlspecialchars($row['c_request'] ?: 'None'); ?></p>
            <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($row['c_booking_date']); ?></p>
            <p><strong>Cancellation Date:</strong> <?php echo htmlspecialchars($cancellation_date); ?></p>
        </div>
        <div class="footer">
            <button onclick="window.print()">Download Receipt</button>
            <button onclick="location.href='index.php'">Go to Home-Page</button>
            <button onclick="location.href='TNEW3.php'">Make New Booking</button>
        </div>
    
</body>
</html>
