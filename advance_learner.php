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
  /* ================= HERO IMAGE ================= */
  .hero-img{
    width:100%;
    height:280px;
    object-fit:cover;
  }

  /* ================= ENROLL BUTTON ================= */
  .enroll-btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 28px;
    background:#ff5a7b;
    color:#fff;
    border-radius:30px;
    font-weight:600;
    text-decoration:none;
    transition:.3s;
    width:auto;
  }

  .enroll-btn:hover{
    background:#ff8a00;
    color:#fff;
  }

  /* ================= GRADE CARD ================= */
  .grade-card{
    border-radius:16px;
    box-shadow:0 8px 20px rgba(255,90,123,0.12);
    transition:.3s;
  }

  .grade-card:hover{
    transform:translateY(-8px);
  }

  /* ================= MODAL ================= */
  .enroll-modal{
    border-radius:20px;
    overflow:hidden;
  }

  #enrollFrame{
    width:100%;
    height:520px;
    border:none;
  }

  /* ================= MODERN COURSE CARDS ================= */
  .section-title {
    font-family: 'Fredoka', sans-serif;
    color: #2c3e50;
    position: relative;
    /* display: inline-block; */
    font-weight: 700;
  }

  .section-title::after {
    content: '';
    position: absolute;
    width: 70px;
    height: 5px;
    background: #ff5a7b;
    bottom: -14px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 3px;
  }

  .course-card-wrapper {
    height: 100%;
  }

  .course-card {
    height: 100%;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    border: 1px solid #f0f0f0;
  }

  .course-card:hover {
    transform: translateY(-14px);
    box-shadow: 0 25px 50px rgba(255, 90, 123, 0.22);
    border-color: #ff5a7b;
  }

  .course-img-container {
    position: relative;
    overflow: hidden;
  }

  .course-img-container img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    transition: transform 0.7s ease;
  }

  .course-card:hover .course-img-container img {
    transform: scale(1.1);
  }

  .course-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .course-card:hover .course-img-overlay {
    opacity: 1;
  }

  .course-content {
    padding: 24px 22px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    flex: 1;
  }

  .course-title {
    font-size: 1.55rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.3;
    font-family: 'Fredoka', sans-serif;
  }

  .course-info {
    font-size: 0.98rem;
    color: #555;
    margin: 4px 0;
  }

  .course-info strong {
    color: #2c3e50;
    font-weight: 600;
  }

  .course-price {
    font-size: 2.2rem;
    font-weight: 800;
    color: #ff5a7b;
    margin: 12px 0 8px;
    line-height: 1;
  }

  .course-price small {
    font-size: 1.05rem;
    font-weight: 500;
    color: #888;
  }

  .seats-badge {
    display: inline-block;
    background: #fff0f5;
    color: #e91e63;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.92rem;
    margin-top: 6px;
  }

  .enroll-btn-modern {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 32px;
    background: linear-gradient(135deg, #ff5a7b 0%, #ff8a9c 100%);
    color: white;
    font-weight: 600;
    font-size: 1.05rem;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(255, 90, 123, 0.25);
    margin-top: auto;
    border: none;
  }

  .enroll-btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(255, 90, 123, 0.4);
    background: linear-gradient(135deg, #ff8a9c 0%, #ff5a7b 100%);
  }

    ul.list-unstyled.fs-5 {
        margin-top: 20px;
    }

    p.lead.text-muted {
    margin-top: 27px;
    }
    
  /* Responsive adjustments for course cards */
  @media (max-width: 992px) {
    .course-img-container img {
      height: 220px;
    }
    .course-title {
      font-size: 1.45rem;
    }
  }

  @media (max-width: 768px) {
    .course-img-container img {
      height: 200px;
    }
    .course-title {
      font-size: 1.38rem;
    }
    .course-price {
      font-size: 2rem;
    }
    .enroll-btn-modern {
      padding: 12px 28px;
      width: 100%;
    }
  }

  @media (max-width: 480px) {
    .course-img-container img {
      height: 180px;
    }
    .course-title {
      font-size: 1.3rem;
    }
    .course-price {
      font-size: 1.9rem;
    }
  }

  /* ================= TABLET ================= */
  @media (max-width:992px){
    .breadcumb-wrapper{
      min-height:220px;
    }
    .breadcumb-title{
      font-size:36px;
    }
    .hero-img{
      height:240px;
    }
  }

  /* ================= MOBILE ================= */
  @media (max-width:768px){
    /* Breadcrumb */
    .breadcumb-wrapper{
      min-height:190px;
      padding:30px 0;
      text-align:center;
    }
    .breadcumb-title{
      font-size:28px;
      line-height:1.2;
    }
    .breadcumb-text{
      font-size:14px;
    }
    /* Hero */
    .hero-img{
      height:200px;
      margin-top:20px;
    }
    /* Buttons */
    .enroll-btn{
      width:100%;
      text-align:center;
    }
    /* Modal */
    #enrollFrame{
      height:420px;
    }
  }

  /* ================= SMALL MOBILE ================= */
  @media (max-width:480px){
    .breadcumb-title{
      font-size:24px;
    }
    .hero-img{
      height:170px;
    }
    #enrollFrame{
      height:360px;
    }
  }

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
        <h4 class="fw-bold mb-3 section-title" style="display: inline-block;">Key Focus Areas</h4>
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