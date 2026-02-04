<?php
include('header.php');
include 'db_config.php';

$sql_courses = "SELECT * FROM advance_courses ORDER BY id DESC";
$result_courses = $conn->query($sql_courses);
$currencySymbol = '$'; 
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Advanced Learners - Achiever's Castle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Favicons & Google Fonts -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Jost:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/layerslider.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/slick.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

      <style>
      .breadcumb-wrapper .container{
        display:flex;
        align-items:center;
      }
      .breadcumb-content{
        padding:0 !important;
        margin:0 !important;
      }
      .breadcumb-title{
        margin:0 !important;
        padding:0 !important;
        font-size:48px;
        font-weight:700;
        line-height:1;
      }
      /* ================= ENROLL BUTTON ================= */
      .enroll-btn{
        display:inline-block;
        margin-top:15px;
        padding:10px 30px;
        background:#ff5a7b;
        color:#fff;
        border-radius:30px;
        font-weight:600;
        text-decoration:none;
        transition:.3s;
      }
      .enroll-btn:hover{
        background:#ff8a00;
        color:#fff;
      }

      /* ================= MODAL CLOSE FIX ================= */
      .enroll-modal{
        position:relative;
        border-radius:20px;
        overflow:hidden;
      }
      .custom-close{
        position:absolute;
        top:12px;
        right:14px;
        width:36px;
        height:36px;
        background:#fff;
        border-radius:50%;
        font-size:26px;
        font-weight:bold;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        z-index:9999;
        box-shadow:0 5px 15px rgba(0,0,0,.25);
      }
      .custom-close:hover{
        background:#ff5a7b;
        color:#fff;
      }
        .grade-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(255,90,123,0.12);
            transition: all 0.4s ease;
            background: #fff;
        }
        .grade-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 30px rgba(255,90,123,0.2);
        }
        .subject-tag {
            background: #fff0f5;
            color: #ff5a7b;
            padding: 6px 14px;
            border-radius: 30px;
            margin: 0 6px 8px 0;
            display: inline-block;
            font-size: 0.95rem;
            font-weight: 600;
        }
        .section-title { color: #ff5a7b; font-weight: 700; }
        .hero-img { height: 280px; object-fit: cover; filter: brightness(0.92); }
    </style>
</head>
<body>

<!-- Breadcrumb -->
<div class="breadcumb-wrapper" data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Advanced Learners</h1>
            <p class="breadcumb-text">Building Strong Foundations for Future Success</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li>Advanced Learners</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="space-extra position-relative" style="background: linear-gradient(135deg, #f5f8ff 0%, #eef2ff 100%); padding: 70px 0;">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-down">
      <h2 class="display-4 fw-bold section-title">Advanced Learners</h2>
      <p class="lead text-muted">Grade 3 onwards • Conceptual Depth & Exam Readiness</p>
    </div>

    <div class="row g-5 align-items-center">
      <div class="col-lg-6" data-aos="fade-right">
        <p class="fs-5 lh-lg mb-4">
          Our Advanced Learners program is designed to develop deep conceptual understanding, critical thinking, and strong problem-solving skills — preparing students for school exams, board exams, and competitive entrances.
        </p>
        <h4 class="fw-bold mb-3 section-title">Key Focus Areas</h4>
        <ul class="list-unstyled fs-5">
          <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 text-success"></i>Advanced Mathematics & Logical Reasoning</li>
          <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 text-success"></i>Science Concepts & Application</li>
          <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 text-success"></i>English – Comprehension, Writing & Grammar</li>
          <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 text-success"></i>Structured Exam Preparation & Strategy</li>
        </ul>
      </div>

      <div class="col-lg-6" data-aos="fade-left">
        <img src="https://images.unsplash.com/photo-1588075592446-265fd1e6e76f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
             alt="Students solving advanced problems" class="img-fluid rounded-4 shadow hero-img">
      </div>
    </div>
  </div>
</section>

<!-- Tuition Fees Section -->
<!-- ================= TUITION FEES SECTION – same style as Elementary ================= -->
<section class="space-extra bg-white">
  <div class="container">
    <h2 class="text-center section-title mb-5" data-aos="fade-up">Tuition Fees (Monthly)</h2>

    <div class="text-center mb-5" style="font-size:1.3rem; font-weight:600; color:#d63384;" data-aos="zoom-in">
      ★ Sibling Discount of $20 will be applied when 1st child is also studying at the centre ★
    </div>

    <div class="row g-4 justify-content-center">
      <!-- One Program -->
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="grade-card p-4 text-center">
          <h4 class="fw-bold mb-3" style="color:#ff5a7b;">One Program</h4>
          <p style="font-size:2.5rem; font-weight:700; margin:0.5rem 0;">$160</p>
          <p class="text-muted">Math / Science / English / Other subjects</p>
        </div>
      </div>

      <!-- Two Programs -->
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="grade-card p-4 text-center">
          <h4 class="fw-bold mb-3" style="color:#ff5a7b;">Two Programs</h4>
          <p style="font-size:2.5rem; font-weight:700; margin:0.5rem 0;">$310</p>
          <p class="text-muted">Any two subjects combined</p>
        </div>
      </div>

      <!-- Three Programs -->
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="grade-card p-4 text-center">
          <h4 class="fw-bold mb-3" style="color:#ff5a7b;">Three Programs</h4>
          <p style="font-size:2.5rem; font-weight:700; margin:0.5rem 0;">$460</p>
          <p class="text-muted">Full access to all selected subjects</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Available Courses -->
<section id="courses" class="space-top space-extra-bottom">
  <div class="container">
    <h2 class="text-center section-title mb-5" data-aos="fade-up">Available Advanced Courses</h2>

    <div class="row gx-50 gy-gx">
      <?php if ($result_courses && $result_courses->num_rows > 0): ?>
        <?php while($row = $result_courses->fetch_assoc()): ?>
          <div class="col-md-6" data-aos="fade-up">
            <div class="class-style1">
              <div class="class-img">
                <img src="<?php echo htmlspecialchars($row['image'] ?? 'assets/img/default-course.jpg'); ?>" 
                     alt="<?php echo htmlspecialchars($row['title'] ?? 'Course Image'); ?>">
              </div>
              <div class="class-content">
                <h3 class="class-title"><?php echo htmlspecialchars($row['title'] ?? 'Untitled Course'); ?></h3>
                
                <p class="class-info">
                  <strong>Grade Range:</strong> 
                  <span class="info"><?php echo htmlspecialchars($row['grade_range'] ?? 'N/A'); ?></span>
                </p>
                
                <?php if (!empty($row['seats'])): ?>
                  <p class="class-info">
                    <strong>Seats Available:</strong> 
                    <span class="info"><?php echo (int)$row['seats']; ?></span>
                  </p>
                <?php endif; ?>
                
                <p class="class-price">
                  <?php echo $currencySymbol . number_format((float)($row['price'] ?? 0), 2); ?>
                </p>
                
                <a href="javascript:void(0)" class="enroll-btn" data-course="<?php echo $row['id']; ?>">
                  Enroll Now
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center fs-5 text-muted">No advanced courses available at the moment. Check back soon!</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content enroll-modal">
      <span class="custom-close" data-bs-dismiss="modal">×</span>
      <div class="modal-body p-0">
        <iframe id="enrollFrame" style="width:100%;height:520px;border:none;"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

<script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
$(document).on('click', '.enroll-btn', function(){
  let courseId = $(this).data('course');
  let url = 'https://creativetheka.in/enroll.php?course_id=' + courseId;
  $('#enrollFrame').attr('src', url);
  $('#enrollModal').modal('show');
});
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ once: true, duration: 900, easing: 'ease-out-back' });
</script>

<?php include('footer.php'); ?>
</body>
</html>