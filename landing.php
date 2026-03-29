<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxuryStay – Hotel Booking</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            background:#f4f4f4;
        }

        /* ------------------ HEADER ------------------ */
        header{
            width:100%;
            padding:20px 8%;
            position:fixed;
            top:0;
            left:0;
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:rgba(0,0,0,0.4);
            backdrop-filter:blur(10px);
            z-index:1000;
        }

        header h1{
            color:#fff;
            font-size:28px;
            letter-spacing:1px;
        }

        header nav a{
            color:#fff;
            margin-left:25px;
            text-decoration:none;
            font-size:16px;
            font-weight:500;
        }

        header nav a:hover{
            color:#ff9f1c;
        }

        /* ------------------ HERO SECTION ------------------ */
        .hero{
            width:100%;
            height:100vh;
            background:url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb') no-repeat center/cover;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
            color:white;
            text-align:center;
            padding:0 20px;
        }

        .hero h2{
            font-size:50px;
            margin-bottom:20px;
            text-shadow:0 4px 12px rgba(0,0,0,0.7);
        }

        .hero p{
            font-size:18px;
            width:70%;
            max-width:700px;
            text-shadow:0 4px 10px rgba(0,0,0,0.6);
        }

        .btn{
            margin-top:30px;
            padding:15px 40px;
            background:#ff9f1c;
            color:white;
            border:none;
            border-radius:30px;
            font-size:18px;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover{
            background:#ff7a00;
        }

        /* ------------------ ROOMS SECTION ------------------ */
        .rooms{
            padding:80px 8%;
            text-align:center;
        }

        .rooms h2{
            font-size:34px;
            margin-bottom:40px;
        }

        .room-container{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
            gap:30px;
        }

        .room{
            background:white;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
            transition:0.3s;
        }

        .room:hover{
            transform:scale(1.02);
        }

        .room img{
            width:100%;
            height:200px;
            object-fit:cover;
        }

        .room h3{
            padding:20px 0 10px;
            font-size:22px;
        }

        .room p{
            padding:0 20px 20px;
            color:#555;
        }

        .book-btn{
            display:block;
            margin:15px auto 25px;
            padding:10px 25px;
            background:#4CAF50;
            color:white;
            border:none;
            border-radius:25px;
            cursor:pointer;
            font-size:16px;
            transition:0.3s;
        }

        .book-btn:hover{
            background:#3d8b40;
        }

        /* ------------------ FOOTER ------------------ */
        footer{
            background:#333;
            padding:30px;
            text-align:center;
            color:white;
            margin-top:50px;
        }

        @media(max-width:600px){
            .hero h2{ font-size:32px; }
            .hero p{ width:100%; font-size:16px; }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header>
        <h1>LuxuryStay</h1>
        <nav>
            <a href="#">Home</a>
            <a href="#rooms">Rooms</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="admin_login.php">Admin</a>   <!-- ✅ Added Admin Link -->
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section class="hero">
        <h2>Experience Luxury & Comfort</h2>
        <p>Book your stay at one of the finest hotels with premium rooms, world-class service, and unforgettable hospitality.</p>
        <button class="btn" onclick="window.location.href='login.php'">Book Now</button>
    </section>

    <!-- ROOMS SECTION -->
    <section class="rooms" id="rooms">
        <h2>Our Rooms</h2>

        <<div class="room">
    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=900&q=80" alt="Deluxe Room">
    <h3>Deluxe Room</h3>
    <p>Beautiful room with king-sized bed, Wi-Fi, AC, and a scenic view.</p>
    <button class="book-btn" onclick="window.location.href='room.php?room=Deluxe'">Book Now</button>
</div>


            <div class="room">
                <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39" alt="">
                <h3>Luxury Suite</h3>
                <p>Spacious suite with living area, premium interiors, and full amenities.</p>
                <button class="book-btn" onclick="window.location.href='room.php?room=Suite'">Book Now</button>
            </div>

            <div class="room">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" alt="">
                <h3>Family Room</h3>
                <p>Perfect for families with multiple beds, comfort, and privacy.</p>
                <button class="book-btn" onclick="window.location.href='room.php?room=Family'">Book Now</button>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        &copy; 2025 LuxuryStay Hotel | All Rights Reserved
    </footer>

</body>
</html>
