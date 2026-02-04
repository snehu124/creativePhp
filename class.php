<?php 
include('header.php');
include 'db_config.php';
$sql = "SELECT * FROM courses WHERE visible_to_teachers = 1 ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Super Fun Classes – Kiddino</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Comic+Neue:wght@700&display=swap" rel="stylesheet">

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
            font-family: 'Comic Neue', cursive;
            font-size: 3.4rem;
            font-weight: 700;
            background: linear-gradient(90deg, #ec4899, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.2rem;
            animation: floatTitle 6s ease-in-out infinite;
        }

        @keyframes floatTitle {
            0%,100% { transform: translateY(0); }
            50%     { transform: translateY(-8px); }
        }

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
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            height: 100%;
        }

        .class-card:hover {
            transform: translateY(-18px) rotate(1.5deg);
            box-shadow: 0 40px 90px rgba(0,0,0,0.22);
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
            transform: scale(1.18) rotate(3deg);
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
            padding: 8px 20px;
            border-radius: 16px;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.06);
        }

        .btn-explore {
            padding: 14px 34px;
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

        @media (max-width: 992px) {
            .section-title { font-size: 2.8rem; }
        }

        @media (max-width: 576px) {
            .class-title   { font-size: 1.45rem; }
            .price-badge   { font-size: 1.6rem; padding: 6px 16px; }
            .btn-explore   { padding: 12px 28px; font-size: 1rem; }
        }
    </style>
</head>
<body>

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
                <p class="breadcumb-text">Montessori Is A Nurturing And Holistic Approach To Learning</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="index.html">Home</a></li>
                        <li>Our Classes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes Section -->
    <section class="space-top space-extra-bottom classes-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-4 section-title" style="font-family: 'Fredoka', sans-serif; color: #ff6b6b; font-size: 2.8rem;">
                Explore Our Fun Classes!
            </h2>

                <div class="filter-group d-flex justify-content-center flex-wrap">
                    <button class="filter-btn all active" data-filter="all"><i class="fas fa-star me-2"></i>All Classes</button>
                    <button class="filter-btn early"     data-filter="early"><i class="fas fa-baby me-2"></i>Early Learners</button>
                    <button class="filter-btn elementary" data-filter="elementary"><i class="fas fa-book-open me-2"></i>Elementary</button>
                    <button class="filter-btn advanced"   data-filter="advanced"><i class="fas fa-graduation-cap me-2"></i>Advanced</button>
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
                <div class="col-md-6 col-lg-4 class-item" data-level="<?= $level ?>">
                    <div class="class-card">
                        <div class="class-img-container">
                            <?php if (!empty($image)): ?>
                                <img src="<?= htmlspecialchars($image) ?>" class="class-img" alt="<?= htmlspecialchars($row['title']) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="placeholder-img">
                                    <i class="fas fa-<?= $level === 'early' ? 'baby' : ($level === 'elementary' ? 'book-open' : 'graduation-cap') ?>"></i>
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
                                <div class="price-badge">$<?= $price ?></div>

                                <a href="<?php 
                                    if ($level === 'early')     echo 'early_learner.php';
                                    elseif ($level === 'elementary') echo 'elementary.php';
                                    elseif ($level === 'advanced')   echo 'advance_learner.php';
                                    else echo '#';
                                ?>" 
                                class="btn-explore <?= $level ?>-btn">
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
        btn.addEventListener('click', function() {
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
    if (lvl && ['early','elementary','advanced'].includes(lvl)) {
        document.querySelector(`[data-filter="${lvl}"]`)?.click();
    }
    </script>

<?php include('footer.php'); ?>
</body>
</html>