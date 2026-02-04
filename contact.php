<!doctype html>
<?php include('header.php'); ?>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Contact Us | Achievers Castel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Breadcumb -->
    <div class="breadcumb-wrapper" data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact Us</h1>
                <p class="breadcumb-text">Montessori Is A Nurturing And Holistic Approach To Learning</p>
                <ul class="breadcumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-style2">
                        <div class="info-icon"><img src="assets/img/icon/c-b-1-1.svg" alt="icon"></div>
                        <h3 class="info-title">Phone No</h3>
                        <p class="info-text"><a href="tel:+4402076897888">+44 (0) 207 689 7888</a></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-style2">
                        <div class="info-icon"><img src="assets/img/icon/c-b-1-2.svg" alt="icon"></div>
                        <h3 class="info-title">Monday to Friday</h3>
                        <p class="info-text">8.30am – 02.00pm</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-style2">
                        <div class="info-icon"><img src="assets/img/icon/c-b-1-3.svg" alt="icon"></div>
                        <h3 class="info-title">Email Address</h3>
                        <p class="info-text"><a href="mailto:user@domainname.com">user@domainname.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="space-extra-bottom">
        <div class="container">
            <div class="row flex-row-reverse gx-60 justify-content-between">
                <div class="col-xl-auto">
                    <img src="assets/img/about/con-2-1.png" alt="girl" class="w-100">
                </div>
                <div class="col-xl col-xxl-6 align-self-center">
                    <div class="title-area">
                        <span class="sec-subtitle">Have Any Questions?</span>
                        <h2 class="sec-title">Feel Free to Contact!</h2>
                    </div>
                    <form action="contact_mail.php" method="post" class="form-style3 layout2">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name <span class="required">*</span></label>
                                <input name="firstname" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name <span class="required">*</span></label>
                                <input name="lastname" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email Address <span class="required">*</span></label>
                                <input name="email" type="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone Number <span class="required">*</span></label>
                                <input name="number" type="text" required>
                            </div>
                            <div class="col-12 form-group">
                                <label>Message <span class="required">*</span></label>
                                <textarea name="message" rows="6" required></textarea>
                            </div>
                            <div class="col-auto form-group">
                                <button class="vs-btn" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Map -->
    <section class="space-bottom">
        <div class="container">
            <div class="title-area">
                <h2>How To Find Us</h2>
            </div>
            <div class="map-style1">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="450" style="border:0;" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <!-- Scripts -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

<?php include('footer.php'); ?>
</body>
</html>
