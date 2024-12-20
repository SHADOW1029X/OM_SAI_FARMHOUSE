<?php
session_start();

// Database connection details
$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'our_website';

// Create connection
$con = new mysqli($hname, $uname, $pass, $db);

// Check connection
if ($con->connect_error) {
    die("Cannot Connect to Database: " . $con->connect_error);
}

// Initialize variables
$booking_id = '';
$row_data = [];
$error_message = '';
$table_found = ''; // To track which table data comes from

// Handle search form submission
if (isset($_POST['search'])) {
    $booking_id = trim($_POST['booking-id']);

    // Check in user_data_table
    $stmt = $con->prepare("SELECT * FROM user_data_table WHERE `booking-id` = ?");
    $stmt->bind_param("s", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row_data = $result->fetch_assoc();
        $table_found = 'active';
    } else {
        // Check in cancellation_data_table
        $stmt = $con->prepare("SELECT * FROM cancellation_data_table WHERE `c_booking_id` = ?");
        $stmt->bind_param("s", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row_data = $result->fetch_assoc();
            $table_found = 'canceled';
        } else {
            $error_message = "No record found for Booking ID: " . htmlspecialchars($booking_id);
        }
    }
    $stmt->close();
}

// Handle cancellation
if (isset($_POST['cancel'])) {
    $booking_id = $_POST['cancel-booking-id'];

    // Fetch data from user_data_table
    $stmt = $con->prepare("SELECT * FROM user_data_table WHERE `booking-id` = ?");
    $stmt->bind_param("s", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row_data = $result->fetch_assoc();

        // Insert data into cancellation_data_table
        $insert_stmt = $con->prepare(
            "INSERT INTO cancellation_data_table 
            (c_name, c_phone_no, c_email, c_adults, c_children, c_total, c_check_in, c_check_out, c_total_amount, c_request, c_booking_date, c_booking_id, c_payment_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $insert_stmt->bind_param(
            "sssiiisssssss",
            $row_data['name'],
            $row_data['phone_no'],
            $row_data['email'],
            $row_data['adults'],
            $row_data['children'],
            $row_data['total'],
            $row_data['check-in'],
            $row_data['check-out'],
            $row_data['total_amount'],
            $row_data['request'],
            $row_data['booking_date'],
            $row_data['booking-id'],
            $row_data['payment_status']
        );
        $insert_stmt->execute();
        $insert_stmt->close();

        // Delete data from user_data_table
        $delete_stmt = $con->prepare("DELETE FROM user_data_table WHERE `booking-id` = ?");
        $delete_stmt->bind_param("s", $booking_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        // Set session variable to indicate cancellation was successful
    $_SESSION['cancellation_success'] = true;

        // Redirect to a success page
        header("Location: NEW5.php");
        exit;
    }
    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Sai Farmhouse - View Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('VR.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .fade-in {
    opacity: 0;
    animation: fadeIn 1s forwards; /* Adjust duration as needed */
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
        
        .search-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #4e54c8;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus {
            border-color: #4e54c8;
            outline: none;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #4e54c8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #3b3f8c;
        }
        
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .result {
            margin-top: 20px;
            text-align: left;
        }

        .cancel-button {
            margin-top: 10px;
            background-color: #e74c3c;
        }

        .cancel-button:hover {
            background-color: #c0392b;
        }
        .booking-details {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
}

.booking-details p {
    margin: 10px 0;
    font-size: 16px;
    color: #333;
}
    </style>
</head>
<body>
<div class="navbar">
        <a href="index.php">Home</a>
        <a href="TNEW2.php">About Us</a>
        <a href="TNEW3.php">Booking</a>
        <a href="MyBooking.php" class="active">My Booking</a>
    </div>
    <div class="search-container">
        <h1>Find Your Booking</h1>
        <form action="" method="POST" id="searchForm">
            <div class="form-group">
                <label for="booking-id">Enter Booking ID:</label>
                <input type="text" id="booking-id" name="booking-id" required>
            </div>
            <button type="submit" name="search">Search</button>
            <?php if ($error_message): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </form>

        <?php if (!empty($row_data)): ?>
    <div class="result">
        <h2><?php echo $table_found === 'active' ? 'Active Booking Details:' : 'Cancelled Booking Details:'; ?></h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'name' : 'c_name']); ?></p>
        <p><strong>Phone No:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'phone_no' : 'c_phone_no']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'email' : 'c_email']); ?></p>
        <p><strong>Adults:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'adults' : 'c_adults']); ?></p>
        <p><strong>Children:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'children' : 'c_children']); ?></p>
        <p><strong>Total:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'total' : 'c_total']); ?></p>
        <p><strong>Check-in:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'check-in' : 'c_check_in']); ?></p>
        <p><strong>Check-out:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'check-out' : 'c_check_out']); ?></p>
        <p><strong>Total Amount:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'total_amount' : 'c_total_amount']); ?></p>
        <p><strong>Request:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'request' : 'c_request']); ?></p>
        <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'booking_date' : 'c_booking_date']); ?></p>
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'booking-id' : 'c_booking_id']); ?></p>
        <p><strong>Cancellation Date:</strong> <?php echo htmlspecialchars($table_found === 'active' ? 'N/A' : $row_data['cancellation_date']); ?></p>
        <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($row_data[$table_found === 'active' ? 'payment_status' : 'c_payment_status']); ?></p>
        
        <div class="button-container">
            <!-- Download Receipt Button -->
            <button onclick="window.print()" class="download-button">Download Receipt</button>

            <?php if ($table_found === 'active'): ?>
                <!-- Cancel Booking Button -->
                <form method="POST" action="" onsubmit="return confirm('Are you sure that you want to cancel booking?');" style="margin: 0;">
                    <input type="hidden" name="cancel-booking-id" value="<?php echo htmlspecialchars($row_data['booking-id']); ?>">
                    <button type="submit" name="cancel" class="cancel-button">Cancel Booking</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.body.classList.add('fade-in');
    });
</script>
    
</body>
</html>
