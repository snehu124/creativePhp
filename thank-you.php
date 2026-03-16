<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thank You | Achiever's Castle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #fdfbfb, #ebedee);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .thank-card {
            background: #fff;
            padding: 50px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }

        .check-icon {
            font-size: 70px;
            color: #28a745;
            margin-bottom: 20px;
        }

        h1 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
        }

        .home-btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff5a7b, #ff8a9c);
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .home-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,90,123,0.3);
        }

        @media(max-width: 480px) {
            .thank-card {
                padding: 35px 20px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="thank-card">
        <div class="check-icon">✔</div>
        <h1>Appointment Booked Successfully!</h1>
        <p>Thank you for scheduling a visit with Achiever's Castle.  
        We will contact you shortly to confirm your appointment.</p>

        <a href="index.php" class="home-btn">Back to Home</a>
    </div>

</body>
</html>
