<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Contact Us | Achiever's Castle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

   <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Jost:wght@400;500&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1f669c;
            --accent: #ff5a7b;
            --yellow: #ffd600;
            --light-bg: #fff5f8;
        }

        body {
            font-family: 'Jost', sans-serif;
        }

        h1, h2, h3, .section-title {
            font-family: 'Fredoka', sans-serif;
        }
        /* Responsive - same as your other pages */
        @media (max-width: 992px) {
            .breadcumb-wrapper { min-height: 220px; }
            .breadcumb-title { font-size: 36px; }
        }

        @media (max-width: 768px) {
            .breadcumb-wrapper { 
                min-height: 190px; 
                padding: 30px 0; 
                text-align: center; 
            }
            .breadcumb-title { font-size: 28px; line-height: 1.2; }
            .breadcumb-text { font-size: 14px; }
            .breadcumb-menu { padding: 10px 24px; font-size: 1rem; }
        }

        @media (max-width: 480px) {
            .breadcumb-title { font-size: 24px; }
            .breadcumb-menu { padding: 8px 20px; font-size: 0.95rem; }
        }

        /* Your original styles - completely unchanged below */
        .modern-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 90px 0 100px;
        }

        .contact-info-card {
            background: white;
            border-radius: 20px;
            padding: 45px 30px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .contact-info-card:hover {
            transform: translateY(-14px);
            box-shadow: 0 25px 60px rgba(255,90,123,0.25);
            border-color: var(--accent);
        }

        .card-icon-circle {
            width: 90px;
            height: 90px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 2.3rem;
            margin: 0 auto 25px;
            transition: all 0.4s ease;
        }

        .contact-info-card:hover .card-icon-circle {
            background: var(--accent);
            transform: scale(1.12) rotate(10deg);
        }

        .contact-info-card h3 {
            font-size: 1.65rem;
            margin-bottom: 16px;
            color: #222;
            font-weight: 600;
        }

        .contact-info-card a,
        .contact-info-card p {
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
        }

        .contact-form-wrapper {
            background: linear-gradient(145deg, #ffffff, var(--light-bg));
            border-radius: 24px;
            padding: 65px 50px;
            box-shadow: 0 16px 60px rgba(0,0,0,0.09);
        }

        .form-title h2 {
            color: var(--primary);
            font-weight: 700;
            position: relative;
            padding-bottom: 18px;
            display: inline-block;
        }

        .form-title h2::after {
            content: '';
            position: absolute;
            width: 110px;
            height: 5px;
            background: var(--accent);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;
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
            transition: all 0.35s ease;
            box-shadow: 0 8px 25px rgba(255,90,123,0.3);
        }

        .send-btn-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 35px rgba(255,90,123,0.45);
            background: linear-gradient(135deg, #ff8a9c 0%, var(--accent) 100%);
        }

        .contact-row {
            display: flex;
            align-items: stretch;
        }

        .contact-image-box {
            height: auto;
            display: flex;
        }

        .contact-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px;
        }

        .contact-form-wrapper {
            height: 100%;
        }

        @media (max-width: 991px) {
            .contact-form-wrapper { padding: 50px 35px; }
        }

        @media (min-width: 992px) {
            .form-title h2::after { left: 0; transform: none; }
            .form-title { text-align: left; }
        }
    </style>
</head>

<body>
    
<?php include('header.php'); ?>
<!-- Breadcrumb with your requested hero image -->
<div class="breadcumb-wrapper" data-bg-src="assets/img/hero/hero-1-1.jpg">
    <div class="container z-index-common">
        <div class="breadcumb-content" data-aos="fade-up">
            <h1 class="breadcumb-title">Contact Us</h1>
            <p class="breadcumb-text">We're here to help your child shine brighter!</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
    </div>
</div>
    <!-- Quick Contact Cards (unchanged) -->
    <div class="container">
        <div class="modern-contact-grid">

            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-icon-circle">
                    <i class="fas fa-phone-volume"></i>
                </div>
                <h3>Call Us Anytime</h3>
                <a href="tel:+4402076897888">(639) 384 - 2844</a>
            </div>

            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-icon-circle">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <a href="mailto:info@achieverscastle.com">info@achieverscastle.com</a>
            </div>

            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-icon-circle">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>We're Here</h3>
                <p>Monday – Saturday<br>11:00 am – 8:30 pm</p>
            </div>

        </div>
    </div>

    <!-- Contact Form + Map (unchanged - your same image remains) -->
    <section class="space-extra-bottom pt-0">
        <div class="container">
            <div class="row gx-5 align-items-stretch">

                <!-- Form -->
                <div class="col-lg-6 mb-60 mb-lg-0" data-aos="fade-right">
                    <div class="contact-form-wrapper">
                        <div class="form-title mb-50 text-center text-lg-start">
                            <span class="sec-subtitle text-muted">Have Questions?</span>
                            <h2 class = "blog-title">Send Us a Message</h2>
                            <p class="mt-3 text-muted">We'll get back to you as soon as possible!</p>
                        </div>

                        <form action="contact_mail.php" method="post" class="row g-4">
                            <div class="col-md-6">
                                <input name="firstname" type="text" placeholder="First Name *" required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input name="lastname" type="text" placeholder="Last Name *" required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input name="email" type="email" placeholder="Email Address *" required class="form-control">
                            </div>
                            <div class="col-md-6">
                            <input name="number" type="tel" placeholder="Phone Number *"required class="form-control" pattern="[0-9]{10}" maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);" title="Please enter a valid 10-digit mobile number">
                            </div>
                            <div class="col-12">
                                <textarea name="message" rows="6" placeholder="Your Message *" required class="form-control"></textarea>
                            </div>
                            <div class="col-12 text-center text-lg-start">
                                <button type="submit" class="send-btn-modern">
                                    SEND MESSAGE →
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

             <div class="col-lg-6 contact-image-box" data-aos="fade-left">
                <img src="assets/img/about/con-2-1.png"
                    alt="happy children learning">
            </div>
            </div>
        </div>
    </section>

 <!-- Google Map Section (Last Section) -->
<section class="map-section" data-aos="fade-up">
  <div class="container-fluid px-0">
    <div class="map-wrapper">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2882.95478628633!2d-106.68788708450146!3d52.1330191797398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x530506c134b5dfb7%3A0x7d27a3d761157402!2s11%2D102%20Cope%20Crescent%2C%20Saskatoon%2C%20SK%20S7J%205S4%2C%20Canada!5e0!3m2!1sen!2sin!4v1707669139475!5m2!1sen!2sin"
        width="100%"
        height="450"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </div>
  </div>
</section>


    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <!-- Scripts -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-back'
        });
    </script>

<?php include('footer.php'); ?>
</body>
</html>