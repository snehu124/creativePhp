<?php
    include 'db_config.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Elementary – Achiever's Castle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Comic+Neue:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/layerslider.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/slick.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #ff5a7b;
            --primary-light: #ff8aac;
            --primary-dark: #e0456a;
            --accent: #ff8a00;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-soft: #fff5f9;
        }

        body {
            font-family: 'Jost', sans-serif;
            color: var(--text-dark);
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Fredoka', sans-serif;
        }

        .hero-img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 16px;
        }

        .section-title {
            position: relative;
            font-weight: 400;
            color: var(--text-dark);
            font-family: "Love Ya Like A Sister", cursive;
        }

        /* .section-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            bottom: -14px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 3px;
        } */

        /* Cards & Buttons */
        .feature-card, .grade-card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 12px 40px rgba(255,90,123,0.12);
            transition: all 0.38s ease;
            overflow: hidden;
        }

        .feature-card:hover, .grade-card:hover {
            transform: translateY(-14px);
            box-shadow: 0 30px 70px rgba(255,90,123,0.25);
        }

        .enroll-btn-modern {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px 38px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 8px 25px rgba(255,90,123,0.3);
            transition: all 0.4s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .enroll-btn-modern:hover {
            transform: translateY(-4px) scale(1.04);
            box-shadow: 0 16px 40px rgba(255,90,123,0.45);
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        }

        .highlight-box {
            background: linear-gradient(135deg, #fff8fb 0%, #fff0f5 100%);
            border-radius: 16px;
            padding: 32px;
            border: 2px dashed var(--primary-light);
        }

        .check-list li {
            font-size: 1.1rem;
            margin-bottom: 14px;
            display: flex;
            align-items: flex-start;
        }

        .check-list i {
            color: #10b981;
            font-size: 1.4rem;
            margin-right: 14px;
            margin-top: 4px;
        }

        .img-zoom-wrapper {
            overflow: hidden;
            border-radius: 20px;
        }

        .img-zoom-wrapper img {
            transition: transform 0.7s ease;
            height: 509px;
        }

        .img-zoom-wrapper:hover img {
            transform: scale(1.12);
        }

        .class-img img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .class-content {
            padding: 24px 22px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
        }

        .class-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
            line-height: 1.3;
        }

        .class-info {
            font-size: 0.98rem;
            color: #555;
            margin: 4px 0;
        }

        .class-info strong {
            color: #2c3e50;
            font-weight: 600;
        }

        .class-price {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            margin: 12px 0 8px;
        }

        .enroll-btn {
            display: inline-block;
            padding: 10px 28px;
            background: var(--primary);
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: .3s;
        }

        .enroll-btn:hover {
            background: var(--accent);
            color: #fff;
        }

        /* Modal */
        .enroll-modal {
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
            padding: 0;
        }

        .custom-close {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            background: rgba(0,0,0,0.6);
            width: 45px;
            height: 45px;
            line-height: 42px;
            text-align: center;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .custom-close:hover {
            background: var(--primary);
            transform: rotate(90deg);
        }

        #enrollFrame {
            width: 100%;
            height: 580px;
            border: none;
        }

        .course-card-modern {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(255, 90, 123, 0.12);
        transition: all 0.35s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(255, 90, 123, 0.08);
        }

        .course-card-modern:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 60px rgba(255, 90, 123, 0.28);
        border-color: var(--primary);
        }

        .course-image-wrap {
        position: relative;
        overflow: hidden;
        height: 220px;
        }

        .course-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
        }

        .course-card-modern:hover .course-image-wrap img {
        transform: scale(1.08);
        }

        .course-info-wrap {
        padding: 24px 22px 28px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex: 1;
        }

        .course-name {
        font-size: 1.65rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
        line-height: 1.25;
        font-family: 'Fredoka', sans-serif;
        }

        .course-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 0.95rem;
        }

        .grade-tag, .seats-tag {
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        }

        .grade-tag {
        background: #fff0f5;
        color: var(--primary);
        }

        .seats-tag {
        background: #ffebee;
        }

        .course-price-area {
        margin: 12px 0;
        }

        .course-price-area .price {
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        }

        .course-price-area .price small {
        font-size: 1.05rem;
        font-weight: 500;
        color: #888;
        vertical-align: middle;
        }

        /* Elementary Our Approach Cards */
        .elementary-approach .feature-card {
            height: auto;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            border-radius: 18px;
        }

        /* Icon Circle */
        .elementary-approach .icon-wrap {
            width: 46px;
            height: 46px;
            background: #fff0f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Text */
        .elementary-approach .text-wrap strong {
            display: block;
            font-size: 1.05rem;
            margin-bottom: 4px;
        }

        .elementary-approach .text-wrap span {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Hover */
        .elementary-approach .feature-card:hover {
            transform: translateX(5px);
        }

        .course-info-wrap{
            display:flex;
            flex-direction:column;
            flex:1;
        }

        .subjects-container{
            flex:1;
        }

        .enroll-now-single{
            margin-top:auto;
        }

        .subject-selectable{
            background:white;
            border:1px solid #eee;
            cursor:pointer;
            transition:0.25s;
        }

        .subject-selectable:hover{
            background:#fff5f9;
            border-color:var(--primary-light);
        }

        .subject-selectable.selected{
            background:#fff0f5;
            border-color:var(--primary);
            box-shadow:0 0 0 3px rgba(255,90,123,0.15);
        }

        .subject-selectable.selected .check-icon{
            background:var(--primary);
            color:white;
            border-color:var(--primary);
        }

        .check-icon{
            width:22px;
            height:22px;
            border-radius:50%;
            border:2px solid var(--primary);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .breadcumb-title { font-size: 2.1rem; }
            .breadcumb-text { font-size: 1rem; }
            .section-title { font-size: 2.1rem; }
            .class-img img { height: 220px; }
            .class-title { font-size: 1.4rem; }
            .class-price { font-size: 2.1rem; }
            .enroll-btn-modern,
            .btn-outline-primary.btn-lg {
                font-size: 1.1rem;
                padding: 14px 20px !important;
            }
        }

        @media (max-width: 992px) {
            .breadcumb-title { font-size: 36px; }
            .class-img img { height: 220px; }
            #enrollFrame { height: 520px; }
            .course-image-wrap { height: 200px; }
            .course-name { font-size: 1.5rem; }
        }

        @media (max-width: 768px) {
            .breadcumb-title { font-size: 28px; }
            .class-img img { height: 200px; }
            .class-title { font-size: 1.38rem; }
            .class-price { font-size: 2rem; }
            .enroll-btn, .enroll-btn-modern {
                width: 100%;
                text-align: center;
            }
            #enrollFrame { height: 460px; }
            .highlight-box { padding: 24px; }
            .course-info-wrap { padding: 20px; }
            .course-name { font-size: 1.45rem; }
            .course-price-area .price { font-size: 2.1rem; }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

    <!--==============================
     Preloader
  ==============================-->
    <div class="preloader  ">
        <button class="vs-btn preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <div class="loader"></div>
        </div>
    </div>
    
    <!-- Breadcrumb -->
    <div class="breadcumb-wrapper" data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Elementary</h1>
                <p class="breadcumb-text">Strong Foundations for Future Achievers</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="index.php">Home</a></li>
                        <li>Elementary</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Elementary Intro -->
    <section class="space-extra bg-white">
        <div class="container">
            <div class="text-center mb-5 pb-3" data-aos="fade-down">
                <h2 class="display-4 section-title">Elementary Program</h2>
                <p class="lead text-muted mt-3">
                    At Achiever's Castle, we understand that the elementary years are crucial for shaping a child's academic journey.<br>
                    Our Elementary School Program is designed to foster a love for learning, build confidence, and develop the essential skills students need to succeed in school and beyond.
                </p>
            </div>

            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="highlight-box">
                        <h4 class=" mb-4" style="font-family: 'Love Ya Like A Sister', cursive; font-size: 40px; font-weight:400;">What We Focus On</h4>
                        <h5 class="fw-bold mt-4 mb-3">Reading and Literacy</h5>
                        <ul class="check-list list-unstyled">
                            <li><i class="fas fa-check-circle"></i>Enhance comprehension, vocabulary, and fluency through engaging reading activities.</li>
                            <li><i class="fas fa-check-circle"></i>Develop critical reading skills to analyze and interpret text.</li>
                        </ul>

                        <h5 class="fw-bold mt-5 mb-3">Mathematics</h5>
                        <ul class="check-list list-unstyled">
                            <li><i class="fas fa-check-circle"></i>Strengthen foundational math skills with hands-on problem-solving techniques.</li>
                            <li><i class="fas fa-check-circle"></i>Build confidence in tackling concepts from basic arithmetic to early algebra.</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="img-zoom-wrapper">
                        <img src="./assets/img/class/elementary-reading-lit.jpg" alt="Elementary students learning" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="row g-5 mt-5">
                <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                    <div class="highlight-box">
                        <h5 class="fw-bold mt-4 mb-3">Mathematics</h5>
                        <ul class="check-list list-unstyled">
                            <li><i class="fas fa-check-circle"></i>Strengthen foundational math skills with hands-on problem-solving techniques.</li>
                        </ul>
                        <h5 class="fw-bold mt-4 mb-3">Science</h5>
                        <ul class="check-list list-unstyled">
                            <li><i class="fas fa-check-circle"></i>Encourage curiosity with interactive experiments and discussions.</li>
                            <li><i class="fas fa-check-circle"></i>Develop critical thinking and analytical skills by exploring the natural world.</li>
                        </ul>

                        <h5 class="fw-bold mt-5 mb-3">Study Habits and Organization</h5>
                        <ul class="check-list list-unstyled">
                            <li><i class="fas fa-check-circle"></i>Teach effective study strategies and time management.</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                    <div class="img-zoom-wrapper">
                        <img src="assets/img/class/organic_science.jpg" alt="Kids doing science experiment" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Approach -->
    <section class="space-extra" style="background: linear-gradient(135deg, #fff0f5 0%, #fff8fb 100%);">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5" data-aos="fade-right">
                    <h2 class="section-title mb-4">Our Approach</h2>
                 <div class="row g-3 elementary-approach">
                <div class="col-12">
                    <div class="feature-card">
                        <div class="icon-wrap">
                            <i class="fas fa-heart" style="color:var(--primary)"></i>
                        </div>

                        <div class="text-wrap">
                            <strong>Nurturing Environment</strong>
                            <span>We create a safe, supportive space where students feel encouraged to ask questions and explore new ideas.</span>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="feature-card">
                        <div class="icon-wrap">
                            <i class="fas fa-heart" style="color:var(--primary)"></i>
                        </div>

                        <div class="text-wrap">
                            <strong>Personalized Learning</strong>
                            <span>Our tutors tailor lessons to meet each student’s individual needs, ensuring steady growth and understanding.</span>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="feature-card">
                        <div class="icon-wrap">
                            <i class="fas fa-heart" style="color:var(--primary)"></i>
                        </div>

                        <div class="text-wrap">
                            <strong>Interactive Lessons</strong>
                            <span>Through interactive activities and multimedia tools, we make learning dynamic and enjoyable.</span>
                        </div>
                    </div>
                </div>

            </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left">
                    <div class="text-center mb-5">
                        <h3 class="display-6"  style="font-family: 'Love Ya Like A Sister', cursive; font-size: 40px;">Why Choose Achiever's Castle?</h3>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="feature-card p-4 text-center h-100">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-3" style="color:#ff5a7b"></i>
                                <p class="fw-bold mb-1">Experienced Tutors</p>
                                <small class="text-muted">Passionate teachers who love helping children grow</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card p-4 text-center h-100">
                                <i class="fas fa-trophy fa-2x mb-3" style="color:#fbbf24"></i>
                                <p class="fw-bold mb-1">Proven Results</p>
                                <small class="text-muted">Build confidence and academic excellence</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card p-4 text-center h-100">
                                <i class="fas fa-brain fa-2x mb-3" style="color:#60a5fa"></i>
                                <p class="fw-bold mb-1">Holistic Growth</p>
                                <small class="text-muted">Academics + essential life skills</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tuition Fees -->
    <section class="space-extra bg-white text-center">
        <div class="container">
            <h2 class="display-5 mb-5 section-title" data-aos="zoom-in">
                Monthly Tuition Fees
            </h2>

            <div class="highlight-box mx-auto mb-5" style="max-width:700px;" data-aos="fade-up">
                <div class="text-center mb-4" style="font-size:1.3rem; font-weight:600; color:#d63384;">
                    ★ Sibling Discount of $10 will be applied when 1st child is also studying at the centre ★
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="grade-card p-4">
                            <h4 class=" mb-3" style="color:var(--primary)">One Program</h4>
                            <p style="font-size:3.2rem; font-weight:800; color:var(--primary); line-height:1;">$140</p>
                            <p class="text-muted mt-2">Math / Science / Reading & Writing</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="grade-card p-4">
                            <h4 class="mb-3" style="color:var(--primary)">Two Programs</h4>
                            <p style="font-size:3.2rem; font-weight:800; color:var(--primary); line-height:1;">$270</p>
                            <p class="text-muted mt-2">Any two of the core subjects</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="grade-card p-4">
                            <h4 class=" mb-3" style="color:var(--primary)">Three Programs</h4>
                            <p style="font-size:3.2rem; font-weight:800; color:var(--primary); line-height:1;">$400</p>
                            <p class="text-muted mt-2">All three core subjects</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-3 d-md-flex justify-content-center" data-aos="zoom-in" data-aos-delay="200">
                <a href="#courses" class="enroll-btn-modern btn-lg px-5 py-3">
                    Explore Courses →
                </a>
                <a href="tel:+911234567890" class="btn btn-outline-primary btn-lg px-5 py-3" style="border-color:var(--primary); color:var(--primary);">
                    <i class="fas fa-phone-alt me-2"></i> Contact Us Today
                </a>
            </div>
        </div>
    </section>

  <!-- Available Courses -->
        <section id="courses" class="space-top space-extra-bottom" style="background: var(--bg-soft);">
        <div class="container">

        <h2 class="text-center section-title mb-5" data-aos="fade-up">
        Available Elementary Courses
        </h2>

        <?php
        $sql = "
        SELECT 
            ec.id,
            ec.title,
            ec.subject_id,
            ec.grade_range,
            ec.price,
            ec.image,
            s.subject_name
        FROM elementary_courses ec
        LEFT JOIN subjects s ON ec.subject_id = s.id
        ORDER BY ec.grade_range ASC, ec.id ASC
        ";

        $result = $conn->query($sql);

        /* Group by Grade */
        $grouped = [];
        $images = [];

        while($row = $result->fetch_assoc()){

            $grade = $row['grade_range'];

            $grouped[$grade][] = $row;

            if(!isset($images[$grade])){
                $images[$grade] = $row['image'] ?: 'assets/img/default-course.jpg';
            }
        }
        ?>

        <?php if(!empty($grouped)): ?>

        <div class="row g-4 g-lg-5 justify-content-center">

        <?php $delay = 0; ?>

        <?php foreach($grouped as $grade => $subjects): ?>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay ?>">

        <div class="course-card-modern h-100">

        <!-- Image -->
        <div class="course-image-wrap">
        <img src="<?= htmlspecialchars($images[$grade]) ?>" loading="lazy">
        </div>


        <!-- Content -->
        <div class="course-info-wrap">

        <h3 class="course-name text-center mb-4" style="color:var(--primary);">
        Grade <?= htmlspecialchars($grade) ?>
        </h3>


        <!-- SUBJECT LIST -->
        <div class="subjects-container mb-4">

        <?php foreach($subjects as $sub): ?>

        <div class="subject-selectable d-flex align-items-center justify-content-between p-3 mb-2 rounded"

        data-id="<?= $sub['id'] ?>"
        data-price="<?= $sub['price'] ?>"
        data-name="<?= htmlspecialchars($sub['subject_name'] ?? $sub['title']) ?>"
        >

        <div class="d-flex align-items-center">

        <div class="check-icon me-3"
        style="width:24px;height:24px;border:2px solid var(--primary-light);border-radius:50%;display:flex;align-items:center;justify-content:center;color:transparent;">
        <i class="fas fa-check"></i>
        </div>

        <strong>
        <?= htmlspecialchars($sub['subject_name'] ?? $sub['title']) ?>
        </strong>

        </div>

        <span class="price-tag fw-bold text-primary">
        $<?= number_format($sub['price'],2) ?>
        </span>

        </div>

        <?php endforeach; ?>

        </div>


        <!-- TOTAL -->
        <div class="total-for-grade text-center py-3 rounded"
        style="background:#fff0f5;display:none;">

        <strong>Total Selected: </strong>
        <span class="total-amount fw-bold text-primary">$0.00</span>

        </div>


        <!-- BUTTON -->
        <button class="enroll-btn-modern w-100 mt-3 enroll-now-single" disabled>
        Enroll Now →
        </button>


        </div>
        </div>
        </div>

        <?php $delay+=100; endforeach; ?>

        </div>

        <?php else: ?>

        <div class="text-center py-5">
        <p class="fs-4 text-muted">No courses available.</p>
        </div>

        <?php endif; ?>

        </div>
        </section>

    <!-- Modal -->
    <div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content enroll-modal position-relative">
                <span class="custom-close" data-bs-dismiss="modal" aria-label="Close">×</span>
                <div class="modal-body p-0">
                    <iframe id="enrollFrame" style="width:100%;height:580px;border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/main.js"></script>

   <script>
        $(document).ready(function(){

        /* SUBJECT CLICK */
        $(document).on('click','.subject-selectable',function(){

            $(this).toggleClass('selected');

            let card = $(this).closest('.course-info-wrap');

            let total = 0;
            let lastId = null;

            card.find('.subject-selectable.selected').each(function(){
                total += parseFloat($(this).data('price'));
                lastId = $(this).data('id');
            });

            let totalBox = card.find('.total-for-grade');
            let totalAmt = card.find('.total-amount');
            let btn      = card.find('.enroll-now-single');

            if(total > 0){
                totalBox.show();
                totalAmt.text('$' + total.toFixed(2));
                btn.prop('disabled',false).attr('data-course',lastId);
            }else{
                totalBox.hide();
                btn.prop('disabled',true).attr('data-course','');
            }
        });

        /* ENROLL CLICK */
        $(document).on('click','.enroll-now-single',function(){

            let id = $(this).data('course');
            if(!id) return;

            let url = 'https://creativetheka.in/enroll.php?course_id=' + id;

            $('#enrollFrame').attr('src',url);
            $('#enrollModal').modal('show');
        });

        /* CLEAR MODAL */
        $('#enrollModal').on('hidden.bs.modal',function(){
            $('#enrollFrame').attr('src','');
        });

        });
        </script>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 1000, easing: 'ease-out-back' });
    </script>

    <script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                const headerOffset = 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.scrollY - headerOffset;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    </script>

<?php include('footer.php'); ?>
</body>
</html>