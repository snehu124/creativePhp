<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Book Appointment | Achiever's Castle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #1f669c;
            --accent: #ff5a7b;
            --light-bg: #fff5f8;
        }

        .appointment-wrapper {
            background: linear-gradient(145deg, #ffffff, var(--light-bg));
            border-radius: 24px;
            padding: 65px 50px;
            box-shadow: 0 16px 60px rgba(0,0,0,0.09);
        }

        .send-btn-modern {
            display: inline-flex;
            align-items: center;
            padding: 14px 42px;
            background: linear-gradient(135deg, var(--accent) 0%, #ff8a9c 100%);
            color: white;
            font-weight: 600;
            font-size: 1.15rem;
            border-radius: 50px;
            border: none;
            transition: 0.35s ease;
        }

        .send-btn-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 35px rgba(255,90,123,0.45);
        }

        /* Mobile Fix */
        @media (max-width: 425px) {

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .appointment-wrapper {
                padding: 35px 10px !important;
                border-radius: 16px;
            }

            .send-btn-modern {
                width: 100%;
                justify-content: center;
                font-size: 1rem;
                padding: 14px 20px;
            }

            .appointment-wrapper h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

<?php include('header.php'); ?>

<!-- Breadcrumb -->
<div class="breadcumb-wrapper" data-bg-src="assets/img/hero/hero-1-1.jpg">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Book Appointment</h1>
            <p class="breadcumb-text">Schedule a visit for your child today!</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li>Book Appointment</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Form -->
<section class="space-extra-bottom">
    <div class="container">
        <div class="appointment-wrapper">

            <div class="text-center">
                <h2 style="color:#1f669c;font-weight:700;">Schedule Your Visit</h2>
                <p class="text-muted">Fill the form below and we will confirm your appointment shortly.</p>
            </div>

            <form action="appointment_mail.php" method="post" class="row g-4">

                <div class="col-md-6">
                    <input type="text" name="parent_name" placeholder="Parent Name *" required class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="text" name="child_name" placeholder="Child Name *" required class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="number" name="child_age" placeholder="Child Age *" required class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="tel" name="phone" placeholder="Phone Number *" required class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="email" name="email" placeholder="Email Address *" required class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="date" name="appointment_date" required class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="time" name="appointment_time" required class="form-control">
                </div>

                <div class="col-12">
                    <textarea name="message" rows="5" placeholder="Additional Notes" class="form-control"></textarea>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="send-btn-modern">
                        BOOK APPOINTMENT →
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>

<?php include('footer.php'); ?>

</body>
</html>
