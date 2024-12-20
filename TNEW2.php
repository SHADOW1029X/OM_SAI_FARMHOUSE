<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Sai Farmhouse - About Us</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Lora:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('pg2.jpeg');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            min-height: 100vh;
            background-attachment: fixed;
            color: #333;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
        h2,
        h3 {
            font-family: 'Lora', serif;
        }
        
        h2 {
            font-size: 2.2em;
            color: orange;
        }
        
        h3 {
            font-size: 1.8em;
            color: rgb(187, 0, 255);
        }
        
        .rules h3 {
            color: red;
        }
        
        p {
            color: #555;
            line-height: 1.6;
            font-size: 1.1em;
        }
        
        li {
            color: #444;
            font-size: 1.05em;
        }
        
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 60px;
        }
        
        .swiper {
            width: 88%;
            height: 435px;
            /* Set a height that is visually appealing */
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 25px;
            /* Add margin below the swiper */
        }
        
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            background-position: center;
            background-size: cover;
        }
        
        .swiper-slide img {
            display: block;
            width: 83%;
            height: auto;
            /* Maintain aspect ratio */
            border-radius: 15px;
        }
        
        .hotel-info,
        .rules,
        .contact-info,
        .location-map {
            margin-top: 20px;
            padding: 0 10px;
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        
        .contact-info i {
            color: #2980b9;
            font-size: 1.5em;
            margin-right: 10px;
        }
        
        .contact-info p {
    display: flex;
    align-items: center;
    margin: 0px 0; /* Reduced spacing between name, phone, and email */
}
        
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 10px;
            }
            .swiper {
                height: 250px;
                /* Adjust height for smaller screens */
            }
        }
        /* Navbar styling */
        
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
        
        .confirm-btn {
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
        
        .confirm-btn:hover {
            transform: rotateX(20deg) translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 255, 255, 0.7);
            background: linear-gradient(135deg, #0056b3, #007bff);
        }
        
        .confirm-btn:active {
            transform: scale(0.95) translateY(2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        @keyframes bounce {
            0%,
            100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        .contact-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px; /* Add spacing from other elements */
}

.phone-wrapper {
    display: flex;
    align-items: center;
    gap: 0; /* Keep gap at zero */
}

.scanner-wrapper {
    flex-shrink: 0;
    margin-left: 50px; /* Adjust this value to increase space */
}

.contact-info {
    flex: 1; /* Allow the contact info to take up remaining space */
    padding-right: 10px;
}

.scanner-small {
    width: 100px;
    height: auto;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.scanner-small:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}


.scanner-modal {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    z-index: 2000;
}

.scanner-modal img.scanner-large {
    width: 60%;
    max-width: 600px;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.6);
}
.payment-link {
    font-size: 1.2em;
    color: #2980b9;
    margin-left: 10px;
}

.payment-link-large {
    font-size: 1.5em;
    color: #2980b9;
    margin-top: 20px;
    display: block;
    text-align: center;
}

    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="TNEW2.php" class="active">About Us</a>
        <a href="TNEW3.php">Booking</a>
        <a href="MyBooking.php">My Booking</a>
    </div>

    <div class="container">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="4img.jpeg" alt="Hotel Image 1" />
                </div>
                <div class="swiper-slide">
                    <img src="5img.jpeg" alt="Hotel Image 2" />
                </div>
                <div class="swiper-slide">
                    <img src="6img.jpeg" alt="Hotel Image 3" />
                </div>
                <div class="swiper-slide">
                    <img src="7img.jpeg" alt="Hotel Image 4" />
                </div>
                <div class="swiper-slide">
                    <img src="8img.jpeg" alt="Hotel Image 5" />
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="hotel-info">
            <h2>What We Offer</h2>
            <p>At Om Sai Farmhouse, we prioritize your comfort and enjoyment, offering a peaceful stay for just 1,500 INR per Day & Night(24 hours). Our room is equipped with a luxurious bed and a fan to ensure a restful night. For your entertainment, a
                TV is available. You'll also find an indoor swing to relax and unwind. The room is furnished with four comfortable chairs, one stool, and a small table for your convenience. We provide filtered drinking water and a mini refrigerator to
                keep your beverages cool and refreshing. Our bathroom is equiped with water-heater, jug-bucket and bathing-soap for you comfort. Our amenities are designed to make your stay as comfortable and enjoyable as possible.</p>
        </div>

        <div class="rules">
            <h3>Hotel Rules</h3>
            <ul>
                <li>Please ensure you leave the premises before 8:00 AM on your Check-out date to avoid any inconvenience.</li>
                <li>Customers will be charged an extra amount for any damage to the hotel’s property (including plants in garden) or spreading garbage.</li>
                <li>Dates which are booked and confirmed with payment will making them unavailable for other reservations. Dates which are booked but payment is pending, then we assume that customer is not sure about visiting so those dates will be open for other reservations until you make payment and confirm you reservation. Click the scanner below to scan and pay. Mail the screenshot of payment & receipt to confirm reservation.</li>
                <li>If you cancel your booking within two days of confirmation, you'll receive a full refund. If cancellation made after two days, a 8% deduction will apply to the refund amount for each additional day that passes.</li>
            </ul>
        </div>

        <div class="contact-wrapper">
    <div class="contact-info">
        <h3>Contact owner for more info</h3>
        <p><i class="fas fa-user"></i><span style="color: #eb0606;">Sanjay Prabhubhai Bhandari</span></p>
        <p class="phone-wrapper">
            <i class="fas fa-phone"></i>
            <a href="tel:9427785937" style="color: #2980b9;">91+9427785937</a>
            <span class="scanner-wrapper">
                <img src="scanner.jpeg" alt="Payment Scanner" class="scanner-small" onclick="showScanner()">
                <a href="upi://pay?pa=dhrumitbhandari@oksbi&pn=Dhrumit%20Bhandari&aid=uGICAgMDyqrnfXQ" class="payment-link">Pay Now</a>
            </span>
        </p>
        <p><i class="fas fa-envelope"></i><a href="mailto:omsaifarmhouse2024@gmail.com" style="color: #2980b9;">omsaifarmhouse2024@gmail.com</a></p>
    </div>
    <div id="scanner-modal" class="scanner-modal" onclick="closeScanner()">
        <img src="scanner.jpeg" alt="Scanner Enlarged View" class="scanner-large">
        <a href="upi://pay?pa=dhrumitbhandari@oksbi&pn=Dhrumit%20Bhandari&aid=uGICAgMDyqrnfXQ" class="payment-link-large">Pay Now</a>
    </div>
</div>

<div class="location-map">
    <h3>Our Location</h3>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.360688934918!2d72.76536037469421!3d20.252388513991953!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be0d50056a60269%3A0xf2c0e31799bc52c5!2sOm%20Sai%20Farmhouse%20Hotel!5e1!3m2!1sen!2sin!4v1731411305566!5m2!1sen!2sin"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>


    <button class="confirm-btn" onclick="bookNow()">BOOK NOW</button>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        function bookNow() {
            window.location.href = "TNEW3.php";
        }

        var swiper = new Swiper(".mySwiper", {
            effect: "cube",
            grabCursor: true,
            cubeEffect: {
                shadow: true,
                slideShadows: true,
                shadowOffset: 20,
                shadowScale: 0.94,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            autoplay: {
                delay: 3000, // Set delay to 3 seconds
                disableOnInteraction: false, // Continue autoplay even after user interaction
            },
        });
    </script>
    <script>
    function showScanner() {
        document.getElementById('scanner-modal').style.display = 'flex';
    }

    function closeScanner() {
        document.getElementById('scanner-modal').style.display = 'none';
    }
</script>


</body>

</html>