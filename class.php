<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Super Fun Classes | Achiever's Castle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Comic+Neue:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

<style>
    :root {
        --purple:   #c084fc;
        --cyan:     #22d3ee;
        --yellow:   #fde047;
        --orange:   #fb923c;
        --pink:     #f472b6;
        --red:      #f87171;
        --dark:     #1e293b;
        --gray:     #64748b;
        --bg-light: #f8faff;
    }

    body {
        font-family: 'Fredoka', sans-serif;
        background: white;
        overflow-x: hidden;
    }

    .classes-section {
        font-family: 'Fredoka', sans-serif;
        background: white;
        position: relative;
        overflow: hidden;
    }

    .classes-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="10" cy="10" r="2" fill="%23a78bfa" opacity="0.15"/><circle cx="90" cy="30" r="3" fill="%23fbbf24" opacity="0.12"/><circle cx="40" cy="80" r="2.5" fill="%236ee7b7" opacity="0.18"/></svg>') repeat;
        pointer-events: none;
        z-index: 0;
    }

    .classes-section > .container {
        position: relative;
        z-index: 2;
    }

    .section-title {
        font-family: "Love Ya Like A Sister", cursive;
        font-size: 3.4rem;
        font-weight: 400;
        background:  black;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 4.5rem;
        /* animation: floatTitle 6s ease-in-out infinite; */
       
    }

    /* @keyframes floatTitle {
        0%,100% { transform: translateY(0); }
        50%     { transform: translateY(-8px); }
    } */

    .filter-group {
        gap: 14px;
        margin-bottom: 3.5rem;
    }

    .filter-btn {
        padding: 14px 32px;
        font-size: 1.15rem;
        font-weight: 600;
        border: none;
        border-radius: 999px;
        color: white;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.14);
        position: relative;
        overflow: hidden;
    }

    .filter-btn::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0.25), transparent);
        transform: translateX(-100%);
        transition: 0.6s;
    }

    .filter-btn:hover::after,
    .filter-btn.active::after {
        transform: translateX(100%);
    }

    .filter-btn:hover,
    .filter-btn.active {
        transform: translateY(-6px) scale(1.08);
        box-shadow: 0 16px 40px rgba(0,0,0,0.22);
    }

    .all       { background: linear-gradient(135deg, #c084fc, #a855f7); }
    .early     { background: linear-gradient(135deg, #22d3ee, #06b6d4); }
    .elementary{ background: linear-gradient(135deg, #fde047, #facc15); }
    .advanced  { background: linear-gradient(135deg, #fb923c, #f97316); }

    .class-card {
        border-radius: 2rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
        transition: all 0.38s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%;
    }

    .class-card:hover {
         transform: translateY(-14px) scale(1.02);
        box-shadow: 0 28px 70px rgba(0,0,0,0.16);
    }

    .class-img-container {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: linear-gradient(135deg, #e0f2fe, #dbeafe);
    }

    .class-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .class-card:hover .class-img {
        transform: scale(1.18) ;
    }

    .placeholder-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 6rem;
        color: white;
        background: linear-gradient(135deg, var(--purple), var(--cyan));
        opacity: 0.85;
    }

    .level-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
        z-index: 2;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .class-content {
        padding: 1.8rem 1.6rem 2.2rem;
        flex-grow: 1;
    }

    .class-title {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.9rem;
        line-height: 1.3;
        min-height: 3.4em;
    }

    .class-desc {
        color: #6b7280;
        font-size: 1.08rem;
        line-height: 1.6;
        margin-bottom: 1.6rem;
        flex-grow: 1;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .price-badge {
        font-size: 1.9rem;
        font-weight: 800;
        color: #ef4444;
        background: rgba(239,68,68,0.1);
        padding: 7px 12px;
        border-radius: 999px;
        box-shadow: inset 0 2px 6px rgba(0,0,0,0.06);
    }

    .btn-explore {
        padding: 7px 12px;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        border-radius: 999px;
        transition: all 0.4s ease;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        background-size: 200% 200%;
        background-position: right bottom;
    }

    .btn-explore:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.25);
        background-position: left top;
    }

    .early-btn     { background: linear-gradient(135deg, #22d3ee, #0891b2); }
    .elementary-btn{ background: linear-gradient(135deg, #fde047, #facc15); }
    .advanced-btn  { background: linear-gradient(135deg, #fb923c, #f97316); }

    /* ================= LARGE TABLETS (iPad Pro / Landscape) ================= */
    @media (max-width: 1200px) {
        .section-title {
            font-size: 2.6rem;
        }
        .class-img-container {
            height: 220px;
        }
        .class-title {
            font-size: 1.5rem;
        }
        .filter-btn {
            padding: 12px 26px;
            font-size: 1.05rem;
        }
    }

    /* ================= TABLETS (iPad / Portrait) ================= */
    @media (max-width: 992px) {
        .section-title {
            font-size: 2.3rem;
        }
        .filter-group {
            gap: 10px;
            margin-bottom: 2.5rem;
        }
        .filter-btn {
            padding: 10px 22px;
            font-size: 1rem;
        }
        .class-img-container {
            height: 200px;
        }
        .class-title {
            font-size: 1.4rem;
            min-height: auto;
        }
        .class-desc {
            font-size: 1rem;
        }
        .price-badge {
            font-size: 1.6rem;
        }
        .btn-explore {
            padding: 12px 26px;
            font-size: 1rem;
        }
    }

    /* ================= MOBILE DEVICES ================= */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
            line-height: 1.2;
        }
        .filter-group {
            flex-direction: column;
            align-items: center;
        }
        .filter-btn {
            width: 100%;
            max-width: 260px;
            padding: 12px 20px;
            font-size: 1rem;
        }
        .class-img-container {
            height: 180px;
        }
        .class-content {
            padding: 1.4rem;
            text-align: center;
        }
        .card-footer {
            flex-direction: column;
            gap: 12px;
        }
        .price-badge {
            width: 100%;
            text-align: center;
        }
        .btn-explore {
            width: 100%;
            text-align: center;
        }
    }

    /* ================= SMALL MOBILE (iPhone SE etc.) ================= */
    @media (max-width: 480px) {
        .section-title {
            font-size: 1.7rem;
        }
        .class-img-container {
            height: 160px;
        }
        .class-title {
            font-size: 1.25rem;
        }
        .class-desc {
            font-size: 0.95rem;
        }
        .price-badge {
            font-size: 1.4rem;
            padding: 6px 14px;
        }
        .btn-explore {
            font-size: 0.95rem;
            padding: 10px 22px;
        }
    }

    @media (max-width: 992px) {
        .section-title { font-size: 2.8rem; }
    }

    @media (max-width: 576px) {
        .class-title   { font-size: 1.45rem; }
        .price-badge   { font-size: 1.6rem; padding: 6px 16px; }
        .btn-explore   { padding: 12px 28px; font-size: 1rem; }
    }

    /* =============================================================================
       ADDED & IMPROVED STYLES FOR CORE LEARNING PROGRAMS SECTION
       (everything below this comment is new / enhanced)
    ============================================================================= */

    .core-programs {
        padding: 5rem 0 4rem;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        position: relative;
        overflow: hidden;
         

    }

    .core-programs::before {
        content: "";
        position: absolute;
        inset: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><circle cx="10" cy="10" r="3" fill="%236ee7b7" opacity="0.12"/><circle cx="70" cy="60" r="2.5" fill="%23fbbf24" opacity="0.15"/></svg>') repeat;
        opacity: 0.6;
        pointer-events: none;
    }

    /* .core-programs .section-title {
        position: relative;
        z-index: 2;
        margin-bottom: 3.5rem;
        font-family: "Love Ya Like A Sister", cursive;
        font-weight:400;
        color:black;
    } */

    .core-card {
        border-radius: 1.8rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        transition: all 0.38s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%;
        border: 1px solid rgba(226, 232, 240, 0.7);
        display: flex;
        flex-direction: column;
    }

    .core-card:hover {
        transform: translateY(-14px) scale(1.02);
        box-shadow: 0 28px 70px rgba(0,0,0,0.16);
    }

    .core-header {
        padding: 1.5rem 1.8rem;
        color: white;
        font-size: 1.6rem;
        font-weight: 700;
        text-align: center;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 6px rgba(0,0,0,0.25);
    }

    .math-header    { background: linear-gradient(135deg, #a78bfa, #7c3aed); }
    .science-header { background: linear-gradient(135deg, #38bdf8, #0891b2); }
    .reading-header { background: linear-gradient(135deg, #f472b6, #c026d3); }
    .writing-header { background: linear-gradient(135deg, #fb923c, #c2410c); }

    .core-body {
        padding: 2rem 1.8rem 2.2rem;
        font-size: 1.05rem;
        line-height: 1.68;
        color: #334155;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .core-body h4 {
        color: var(--dark);
        font-size: 1.32rem;
        font-weight: 700;
        margin: 0 0 1rem;
        line-height: 1.3;
    }

    .core-body strong {
        color: var(--dark);
        font-weight: 600;
    }

    .core-body ul {
        padding-left: 1.6rem;
        margin: 0.8rem 0 1.4rem;
        list-style: none;
    }

    .core-body li {
        margin-bottom: 0.55rem;
        position: relative;
    }

    .core-body li::before {
        content: "★";
        color: var(--purple);
        position: absolute;
        left: -1.6rem;
        font-size: 0.9rem;
    }

    .btn-core {
        display: block;
        width: fit-content;
        margin: 1.5rem auto 0.5rem;
        margin-top: auto;
        padding: 13px 36px;
        border-radius: 999px;
        color: white;
        font-weight: 600;
        font-size: 1.05rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.35s ease;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn-math    { background: linear-gradient(135deg, #7c3aed, #5b21b6); }
    .btn-science { background: linear-gradient(135deg, #0891b2, #0e7490); }
    .btn-reading { background: linear-gradient(135deg, #db2777, #9d174d); }
    .btn-writing { background: linear-gradient(135deg, #ea580c, #c2410c); }

    .btn-core:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.22);
    }

    /* Responsive adjustments for core section */
    @media (max-width: 1200px) {
        .core-programs { padding: 4rem 0 3rem; }
    }

    @media (max-width: 992px) {
        .core-header { font-size: 1.45rem; padding: 1.3rem; }
        .core-body { padding: 1.6rem; font-size: 1.02rem; }
    }

    @media (max-width: 768px) {
        .core-programs { padding: 3rem 0 2.5rem; }
        .core-body h4 { font-size: 1.25rem; }
        .btn-core { padding: 12px 32px; font-size: 1rem; }
    }

    @media (max-width: 576px) {
        .core-header { font-size: 1.35rem; }
        .core-body { font-size: 0.98rem; line-height: 1.6; }
    }
</style>
</head>

<body>
<?php 
include('header.php');
include 'db_config.php';
$sql = "SELECT * FROM courses WHERE visible_to_teachers = 1 ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
    <!--[if lte IE 9]>
    	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->



    <!--********************************
   		Code Start From Here 
	******************************** -->




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
    <div class="breadcumb-wrapper " data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Our Classes</h1>
                <p class="breadcumb-text">Where Every Student Learns, Grows, and Succeeds</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="index.php">Home</a></li>
                        <li>Our Classes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Core Learning Programs -->
    <section class="core-programs">
        <div class="container">
            <h2 class=" section-title">
                Our Core Learning Programs
            </h2>

            <div class="row gx-4 gy-5">

                <!-- Maths -->
                <div class="col-lg-6 col-xl-3">
                    <div class="core-card">
                        <div class="core-header math-header">Mathematics</div>
                        <div class="core-body">
                            <h4>Empowering Students to Excel in Numbers</h4>
                            <p><strong>What we offer in Math Tutoring</strong></p>
                            <ul>
                                <li>Foundational Numeracy</li>
                                <li>Algebra and Geometry</li>
                                <li>Advanced Topics (Calculus, Trigonometry, Statistics)</li>
                            </ul>
                            <p><strong>Customized Learning Plans</strong></p>
                            <p><strong>Why Choose Us for Math?</strong></p>
                            <ul>
                                <li>Interactive Problem-Solving Approach</li>
                                <li>Real-World Applications</li>
                                <li>Boosting Confidence</li>
                                <li>Support for All Levels</li>
                            </ul>
                            <a href="#class-grid" class="btn-core btn-math">Explore Classes →</a>
                        </div>
                    </div>
                </div>

                <!-- Science -->
                <div class="col-lg-6 col-xl-3">
                    <div class="core-card">
                        <div class="core-header science-header">Science</div>
                        <div class="core-body">
                            <h4>Exploring the Wonders of the World</h4>
                            <p><strong>What We Offer in Science Tutoring</strong></p>
                            <ul>
                                <li>Physics – Motion, Energy, Universe</li>
                                <li>Chemistry – Atoms, Reactions, Everyday Life</li>
                                <li>Biology – Cells to Ecosystems</li>
                            </ul>
                            <p><strong>Why Choose Us for Science?</strong></p>
                            <ul>
                                <li>Hands-On Experiments</li>
                                <li>Visual and Interactive Tools</li>
                                <li>Critical Thinking & Problem Solving</li>
                                <li>Personalized Learning Plans</li>
                            </ul>
                            <a href="#class-grid" class="btn-core btn-science">Explore Classes →</a>
                        </div>
                    </div>
                </div>

                <!-- Reading -->
                <div class="col-lg-6 col-xl-3">
                    <div class="core-card">
                        <div class="core-header reading-header">Reading</div>
                        <div class="core-body">
                            <h4>Building Strong, Confident Readers</h4>
                            <p><strong>For Young Learners</strong></p>
                            <ul>
                                <li>Phonics Mastery</li>
                                <li>Vocabulary Development</li>
                                <li>Comprehension Skills</li>
                            </ul>
                            <p><strong>For Older Students</strong></p>
                            <ul>
                                <li>Critical Reading</li>
                                <li>Analytical Skills</li>
                                <li>Literature Appreciation</li>
                            </ul>
                            <p><strong>Why Choose Our Reading Programs?</strong> Engaging stories • Structured exercises
                                • Personalized plans</p>
                            <a href="#class-grid" class="btn-core btn-reading">Explore Classes →</a>
                        </div>
                    </div>
                </div>

                <!-- Writing -->
                <div class="col-lg-6 col-xl-3">
                    <div class="core-card">
                        <div class="core-header writing-header">Writing</div>
                        <div class="core-body">
                            <h4>Unlock the Power of Language</h4>
                            <p><strong>Program Highlights</strong></p>
                            <ul>
                                <li>Grammar and Foundations</li>
                                <li>Creative Writing (Storytelling, Poetry)</li>
                                <li>Academic Writing (Essays, Research)</li>
                                <li>Practical Skills (Letters, Emails)</li>
                                <li>Personalized Feedback</li>
                            </ul>
                            <p><strong>Why Choose Achiever's Castle?</strong> Experienced tutors • Engaging activities •
                                Progress tracking</p>
                            <a href="#class-grid" class="btn-core btn-writing">Explore Classes →</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Classes Section -->
    <section class="space-top space-extra-bottom classes-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-4 section-title">
                    Explore Our Classes!
                </h2>

                <div class="filter-group d-flex justify-content-center flex-wrap text-center">
                    <button class="filter-btn all active" data-filter="all"><i class="fas fa-star me-2"></i>All
                        Classes</button>
                    <button class="filter-btn early" data-filter="early"><i class="fas fa-baby me-2"></i>Early
                        Learners</button>
                    <button class="filter-btn elementary" data-filter="elementary"><i
                            class="fas fa-book-open me-2"></i>Elementary</button>
                    <button class="filter-btn advanced" data-filter="advanced"><i
                            class="fas fa-graduation-cap me-2"></i>Advanced</button>
                </div>
            </div>

            <div class="row gx-4 gy-5" id="class-grid">
                <?php while($row = $result->fetch_assoc()): 
                    $level = strtolower($row['level'] ?? 'early');
                    $badgeText = 'Fun Class';
                    $badgeColor = 'var(--purple)';

                    if ($level === 'early')     { $badgeText = 'Early Explorer'; $badgeColor = 'linear-gradient(135deg, #22d3ee, #0891b2)'; }
                    elseif ($level === 'elementary') { $badgeText = 'Elementary Genius'; $badgeColor = 'linear-gradient(135deg, #fde047, #facc15)'; }
                    elseif ($level === 'advanced')   { $badgeText = 'Advanced Wizard'; $badgeColor = 'linear-gradient(135deg, #fb923c, #f97316)'; }

                    $price = number_format($row['price'] ?? 0, 2);
                    $image = $row['image'] ?? '';
                ?>
                <div class="col-12 col-sm-6 col-lg-4 class-item" data-level="<?= $level ?>">
                    <div class="class-card">
                        <div class="class-img-container">
                            <?php if (!empty($image)): ?>
                            <img src="<?= htmlspecialchars($image) ?>" class="class-img img-fluid" loading="lazy"
                                alt="<?= htmlspecialchars($row['title']) ?>">

                            <?php else: ?>
                            <div class="placeholder-img">
                                <i
                                    class="fas fa-<?= $level === 'early' ? 'baby' : ($level === 'elementary' ? 'book-open' : 'graduation-cap') ?>"></i>
                            </div>
                            <?php endif; ?>

                            <span class="level-badge" style="background:<?= $badgeColor ?>;">
                                <?= $badgeText ?>
                            </span>
                        </div>

                        <div class="class-content">
                            <h3 class="class-title">
                                <?= htmlspecialchars($row['title']) ?>
                            </h3>

                            <p class="class-desc">
                                <?= htmlspecialchars(substr($row['description'] ?? 'An amazing adventure in learning begins here...', 0, 120)) ?>…
                            </p>

                            <div class="card-footer">
                                <div class="price-badge">$
                                    <?= $price ?>
                                </div>

                                <a href="<?php 
                                    if ($level === 'early')     echo 'early_learner.php';
                                    elseif ($level === 'elementary') echo 'elementary.php';
                                    elseif ($level === 'advanced')   echo 'advance_learner.php';
                                    else echo '#';
                                ?>" class="btn-explore <?= $level ?>-btn">
                                    Explore Now →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if ($result->num_rows == 0): ?>
            <div class="text-center py-5">
                <h3 class="text-muted fs-4">No magical classes yet... coming soon! 🪄🌟</h3>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        document.querySelectorAll('[data-filter]').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                document.querySelectorAll('.class-item').forEach(item => {
                    item.style.display = (filter === 'all' || item.dataset.level === filter) ? 'block' : 'none';
                });

                document.getElementById('class-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        const params = new URLSearchParams(location.search);
        const lvl = params.get('level');
        if (lvl && ['early', 'elementary', 'advanced'].includes(lvl)) {
            document.querySelector(`[data-filter="${lvl}"]`)?.click();
        }
    </script>

    <?php include('footer.php'); ?>
</body>

</html>