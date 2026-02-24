<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About – Achiever's Castle</title>

<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
<!-- GOOGLE FONT -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ================= RESET ================= */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

/* ================= ABOUT BANNER ================= */
.main-title-section-wrapper{
  position:relative;
  width:100%;
  min-height:260px;
  background:#e60023;
  display:flex;
  align-items:center;
  justify-content:center;
  overflow:hidden;
}

.main-title-section-wrapper::before{
  content:"";
  position:absolute;
  top:-35px;
  left:0;
  width:100%;
  height:90px;
  background:url("images/cloud-top.png") repeat-x;
  background-size:220px auto;
  z-index:1;
}

.main-title-section-container{
  position:relative;
  z-index:5;
  text-align:center;
  color:#fff;
}

.about-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:90px;
  font-weight:400;
  letter-spacing:2px;
  line-height:1.1;
  text-shadow:
    2px 2px 0 rgba(0,0,0,.25),
    4px 4px 10px rgba(0,0,0,.35);
}

.breadcrumb{
  margin-top:10px;
  font-size:16px;
  align-items: center;
  justify-content: center;
}

.breadcrumb a{
  color:#fff;
  text-decoration:none;
}

.main-title-section-bg{
  position:absolute;
  inset:0;
  background:url("images/about-overlay.png") no-repeat center bottom / contain;
  opacity:.95;
  z-index:3;
}

.main-title-section-wrapper::after{
  content:"";
  position:absolute;
  inset:0;
  background:rgba(0,0,0,.05);
  z-index:4;
}

/* ================= WELCOME SECTION ================= */

.kidba-welcome{
  padding:90px 20px;
  background:#fff;
  text-align:center;
}

.container{
  max-width:1200px;
  margin:auto;
}

.section-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:58px;
  font-weight:400;
  color:#083c4d;
  margin-bottom:25px;
}

.kidba-subtitle{
  max-width:720px;
  margin:0 auto 70px;
  font-size:16px;
  color:#666;
  line-height:1.6;
}

/* ================= FEATURES GRID ================= */
.kidba-features{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:50px;
}

.kidba-item{
  text-align:center;
}

/* ICON */
.kidba-icon{
  width:100px;
  height:100px;
  margin:0 auto 22px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
}

.kidba-icon img{
  width:44px;
}

/* GRADIENTS + SHADOW */
.green{
  background:linear-gradient(135deg,#6edc5f,#32c85b);
  box-shadow:0 18px 40px rgba(50,200,91,.45);
}

.blue{
  background:linear-gradient(135deg,#22c1c3,#5f8cff);
  box-shadow:0 18px 40px rgba(95,140,255,.45);
}

.orange{
  background:linear-gradient(135deg,#ffb347,#ff7a18);
  box-shadow:0 18px 40px rgba(255,122,24,.45);
}

.pink{
  background:linear-gradient(135deg,#ff5fbf,#ff3f7f);
  box-shadow:0 18px 40px rgba(255,63,127,.45);
}

/* FEATURE HEADING */
.kidba-item h4{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:26px;
  font-weight:400;
  color:#083c4d;
  margin-bottom:10px;
}

/* COLOR LINE */
.line{
  display:block;
  width:60px;
  height:4px;
  margin:0 auto 15px;
  border-radius:4px;
}

.line.green{background:#32c85b;}
.line.blue{background:#22c1c3;}
.line.orange{background:#ff7a18;}
.line.pink{background:#ff3f7f;}

/* TEXT */
.kidba-item p{
  font-size:14px;
  color:#777;
  line-height:1.6;
  
}

/* ================= RESPONSIVE ================= */
@media(max-width:992px){
  .about-title{font-size:64px}
  .kidba-features{grid-template-columns:repeat(2,1fr)}
}

@media(max-width:768px){
  .about-title{font-size:42px}
  .section-title{font-size:38px}
  .kidba-features{grid-template-columns:1fr}
}

@media(max-width:480px){
  .about-title{font-size:34px}
}

/* ================= PROGRAM SECTION ================= */
.program-section{
  position:relative;
  padding:100px 100px;
  background:url("images/hero-bg.jpg") center/cover no-repeat;
  overflow:hidden;
}

/* SOFT WHITE OVERLAY */
.program-section::before{
  content:"";
  position:absolute;
  inset:0;
  background:rgba(255,255,255,0.1);
  z-index:1;
}

/* ================= CONTAINER ================= */
.program-container{
  position:relative;
  z-index:2;
  max-width:1200px;
  margin:auto;
  display:grid;
  grid-template-columns:1.1fr 1fr;
  align-items:center;
  gap:60px;
}

/* ================= LEFT CONTENT ================= */
.program-content{
  max-width:520px;
}

.program-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:48px;
  font-weight:400;
  line-height:1.15;
  color:#222;
  margin-bottom:24px;
}

.program-text{
  font-size:15px;
  color:#555;
  line-height:1.7;
}

/* ================= RIGHT IMAGE ================= */
.program-image{
  position:relative;
  overflow:hidden;
 box-shadow:0 25px 60px rgba(0,0,0,0.15);
}

.program-image img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}

/* ================= RESPONSIVE ================= */
@media(max-width:992px){
  .program-container{
    grid-template-columns:1fr;
    gap:50px;
  }

  .program-title{
    font-size:44px;
  }

  .program-content{
    max-width:100%;
  }
}

@media(max-width:576px){
  .program-section{
    padding:70px 16px;
  }

  .program-title{
    font-size:36px;
  }
}
/* ================= COUNTER SECTION ================= */
.stats-section{
  position:relative;
  padding:110px 20px;
  background:url("images/counter-bg.webp") center/cover no-repeat;
  overflow:hidden;
}

/* CONTAINER */
.stats-container{
  position:relative;
  z-index:2;
  max-width:1200px;
  margin:auto;
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:50px;
  text-align:center;
  color:#fff;
}

/* BOX */
.stat-box i{
  font-size:42px;
  margin-bottom:18px;
  opacity:0.95;
}

.stat-box h3{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:48px;
  font-weight:400;
  color:#fff;
  margin-bottom:10px;
  
}

.stat-box p{
  font-size:18px;
  font-weight:500;
  opacity:0.95;
}

/* RESPONSIVE */
@media(max-width:992px){
  .stats-container{
    grid-template-columns:repeat(2,1fr);
  }
}

@media(max-width:576px){
  .stats-container{
    grid-template-columns:1fr;
  }

  .stat-box h3{
    font-size:48px;
  }
}
/* ================= UNIQUE SECTION ================= */
.unique-section{
  background:url("images/unique-bg.png") center/cover no-repeat;
  padding:110px 20px;
}

/* ================= HEADER ================= */
.unique-head{
  text-align:center;
  margin-bottom:70px;
}

.unique-head span{
  font-size:13px;
  letter-spacing:2px;
  color:#ff8c11;
  text-transform:uppercase;
}

.unique-head h2{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:48px;
  font-weight:400;
  color:#000;
  margin-bottom:10px;
}

/* ================= WRAPPER ================= */
.unique-wrap{
  max-width:950px;
  margin:auto;
  display:flex;
  flex-direction:column;
  gap:50px;
}

/* ================= BOX COMMON ================= */
.unique-box{
  position:relative;
  padding:28px 40px;
  border-radius:36px;
  border:2px dashed rgba(0,0,0,0.25);
  color:#fff;
 overflow:visible;
}

/* BACKGROUND COLORS */
.box-mission{ background:#2596be; }

.box-values{
  background:#8cbc27;
  padding-left:140px;        /* desktop fix for left image */
}

.box-vision{ background:#cf0f2d; }
.box-mission,
.box-vision{
  padding-right:160px;
}
/* ================= CONTENT ================= */
.unique-content{
  position:relative;
  z-index:2;
}

.unique-content h3{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:32px;
  margin-bottom:6px;
}

.unique-content p{
  font-size:16px;
  margin-bottom:8px;
}

.unique-content ul{
  list-style:none;
  margin-top:10px;
  padding:0;
}

.unique-content li{
  margin-bottom:6px;
  padding-left:18px;
  position:relative;
  font-size:15px;
}

.unique-content li::before{
  content:"➜";
  position:absolute;
  left:0;
}

/* ================= KIDS IMAGES ================= */
.kid-img{
  position:absolute;
  width:120px;
  z-index:1;
}

/* IMAGE POSITIONS (DESKTOP) */
.kid-right{ right:-25px; top:-30px; }
.kid-left{ left:-25px; top:-30px; }
.kid-bottom{ right:-20px; bottom:-30px; }

/* =================================================
   TABLET (<= 991px)
================================================= */
@media(max-width:991px){

  .unique-section{
    padding:90px 20px;
  }

  .unique-head h2{
    font-size:42px;
  }

  .unique-box{
    padding:30px 35px;
  }

  /* reduce left padding on values */
  .box-values{
    padding-left:100px;
  }

  .kid-img{
    width:100px;
  }
}

/* =================================================
   MOBILE (<= 768px)
================================================= */
@media(max-width:768px){

  .unique-section{
    padding:70px 15px;
  }

  .unique-head{
    margin-bottom:45px;
  }

  .unique-head h2{
    font-size:34px;
    line-height:1.2;
  }

  .unique-wrap{
    gap:35px;
  }

  .unique-box{
    padding:30px 25px;
    text-align:center;
  }

  /* RESET left padding completely */
  .box-values{
    padding-left:25px;
  }

  /* stack images above text */
  .kid-img{
    position:static;
    display:block;
    margin:0 auto 15px;
    width:90px;
  }

  .unique-content h3{
    font-size:26px;
  }

  .unique-content li{
    padding-left:0;
  }

  .unique-content li::before{
    position:static;
    margin-right:6px;
  }
}

/* =================================================
   SMALL MOBILE (<= 480px)
================================================= */
@media(max-width:480px){

  .unique-head h2{
    font-size:28px;
  }

  .unique-content h3{
    font-size:22px;
  }

  .unique-content p,
  .unique-content li{
    font-size:14px;
  }

  .kid-img{
    width:80px;
  }
}




</style>
</head>

<body>
  <?php include 'header.php'; ?>
<!-- ===== ABOUT BANNER ===== -->
<section class="main-title-section-wrapper">
  <div class="main-title-section-container">
    <h1 class="about-title">About Us</h1>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / About Us
    </div>
  </div>
  <div class="main-title-section-bg"></div>
</section>

<!-- ===== WELCOME SECTION ===== -->
<section class="kidba-welcome">
  <div class="container">

    <h2 class="section-title">Welcome to Our Castle</h2>

    <p class="kidba-subtitle">
      A joyful place where children learn, explore and grow with confidence.
  We create meaningful learning experiences that nurture curiosity,
  creativity and lifelong skills in a safe, caring environment.
    </p>

    <div class="kidba-features">

      <div class="kidba-item">
        <div class="kidba-icon green">
          <img src="images/active-learning.webp" alt="">
        </div>
        <h4>Holistic Learning</h4>
        <span class="line green"></span>
        <p>We go beyond academics, nurturing confidence, curiosity and a lifelong love for learning.

</p>
      </div>

      <div class="kidba-item">
        <div class="kidba-icon blue">
          <img src="images/parents-day.webp" alt="">
        </div>
        <h4>Expert Support</h4>
        <span class="line blue"></span>
        <p>Expert tutors provide personalized support, fostering confidence and academic success.</p>
      </div>

      <div class="kidba-item">
        <div class="kidba-icon orange">
          <img src="images/expert-teacher.webp" alt="">
        </div>
        <h4>
Positive Space</h4>
        <span class="line orange"></span>
        <p>A warm and positive learning environment where every child feels safe and motivated.</p>
      </div>

      <div class="kidba-item">
        <div class="kidba-icon pink">
          <img src="images/growth.png" alt="">
        </div>
        <h4>
Creative Growth</h4>
        <span class="line pink"></span>
        <p>Creative activities help children develop expression, imagination, and emotional strength.</p>
      </div>

    </div>
  </div>
</section>
<!-- ===== CORE PROGRAM SECTION ===== -->
<section class="program-section">
  <div class="program-container">

    <!-- LEFT CONTENT -->
    <div class="program-content">
      <h2 class="program-title">
        Education That Inspires Confidence
      </h2>

      <p class="program-text">
        At Achiever's Castle, we believe that education is the most powerful tool for
        personal transformation. Since our founding, our mission has been to make
        high-quality, personalized education accessible to students everywhere.
        We saw a gap in the traditional education system — a need for more
        individualized attention, innovative teaching approaches, and flexible
        learning solutions. We answered that need by creating an academy where
        students of all ages can access world-class after-school programs, develop
        essential academic skills, and cultivate the confidence to tackle any
        challenge life throws their way.
      </p>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="program-image">
      <img src="./assets/img/class/confident-castel.jpg" alt="Preschool Learning">
    </div>

  </div>
</section>
<!-- ===== COUNTER SECTION ===== -->
<!-- 
<section class="stats-section" id="statsCounter">
  <div class="stats-overlay"></div>

  <div class="stats-container">

    <div class="stat-box">
      <i class="fa-solid fa-user-graduate"></i>
      <h3 class="counter" data-target="2500">0</h3>
      <p>Students Enrolled</p>
    </div>

    <div class="stat-box">
      <i class="fa-solid fa-trophy"></i>
      <h3 class="counter" data-target="10">0</h3>
      <p>Years Experience</p>
    </div>

    <div class="stat-box">
      <i class="fa-solid fa-pencil-ruler"></i>
      <h3 class="counter" data-target="50">0</h3>
      <p>Expert Tutors</p>
    </div>

    <div class="stat-box">
      <i class="fa-solid fa-book-open-reader"></i>
      <h3 class="counter" data-target="500">0</h3>
      <p>Happy Parents</p>
    </div>

  </div>
</section> -->

<!-- UNIQUE -->
<section class="unique-section">
  <div class="unique-head">
    <span>OUR LEARNING APPROACH</span>
    <h2>A Thoughtful Approach to Learning & Growth</h2>
  </div>

  <div class="unique-wrap">

    <div class="unique-box box-mission">
      <div class="unique-content">
        <h3>Our Mission 🎯</h3>
        <p>Our mission is to provide personalized after-school education that supports academic excellence, emotional growth, and confidence. We create a caring environment where every child feels motivated to learn and succeed.</p>
        <!-- <ul>
          <li>Value-based learning</li>
          <li>Individual attention</li>
          <li>Strong foundation</li>
        </ul> -->
      </div>
      <img src="images/kid-1.png" class="kid-img kid-right">
    </div>

    <div class="unique-box box-values">
      <div class="unique-content">
        <h3>Our Values ⭐</h3>
        <p>We believe education should inspire, support, and uplift every child. Our values define how we teach, guide, and connect with students and families, ensuring a safe and motivating learning space for all.</p>
        <!-- <ul>
          <li>Safe environment</li>
          <li>Creativity</li>
          <li>Emotional growth</li>
        </ul> -->
      </div>
      <img src="images/kid-2.png" class="kid-img kid-left">
    </div>

    <div class="unique-box box-vision">
      <div class="unique-content">
        <h3>Our Vision 🔍</h3>
        <p>Our vision is to build a global learning community where education goes beyond grades, inspiring lifelong learning and nurturing thoughtful, capable, and compassionate individuals.</p>
        <!-- <ul>
          <li>Future-ready kids</li>
          <li>Balanced skills</li>
          <li>Strong morals</li>
        </ul> -->
      </div>
      <img src="images/kid-3.png" class="kid-img kid-bottom">
    </div>

  </div>
</section>


<script>

const counters = document.querySelectorAll('.counter');
let started = false;

function runCounters(){
  counters.forEach(counter=>{
    const target = +counter.dataset.target;
    let count = 0;
    const speed = 160;

    const update = () => {
      const inc = Math.ceil(target / speed);
      if(count < target){
        count += inc;
        counter.innerText = count.toLocaleString();
        setTimeout(update, 20);
      } else {
        counter.innerText = target.toLocaleString();
      }
    };
    update();
  });
}

window.addEventListener('scroll',()=>{
  const section = document.getElementById('statsCounter');
  if(section.getBoundingClientRect().top < window.innerHeight - 100 && !started){
    runCounters();
    started = true;
  }
});


</script>
<?php include 'footer.php'; ?>
</body>
</html>
