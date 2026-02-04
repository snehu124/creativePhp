<!DOCTYPE html>
<?php include('header.php'); ?>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Achiever's Castle</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<style>
/* ================= SECTION ================= */
    .kidba-section {
      padding: 100px 0;
      background: #fff;
    }

    /* ================= MAIN TITLE ================= */
    .kidba-title {
      font-family: "Love Ya Like A Sister", cursive;
      font-size: 52px;
      color: #05364d;
      margin-bottom: 15px;
    }

    .kidba-desc {
      max-width: 540px;
      font-size: 18px;
      font-weight: 500;
      color: #555;
      margin-bottom: 30px;
    }

    /* ================= FEATURE ITEM ================= */
    .kidba-item {
      margin-bottom: 40px;
      align-items: flex-start;
    }

    /* ================= ICON BOX ================= */
    .icon-box {
      width: 80px;
      height: 80px;
      margin-right: 18px;
      border-radius: 6px;
      background: #fff;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .icon-box img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* ================= HEADING + UNDERLINE ================= */
    .kidba-item h5 {
      font-size: 20px;
      color: #05364d;
      margin-bottom: 10px;
      position: relative;
      display: inline-block;
      font-weight: 700;
    }

    .kidba-item h5::after {
      content: "";
      display: block;
      width: 45px;
      height: 3px;
      border-radius: 3px;
      margin-top: 6px;
    }

    /* underline colors */
    .kidba-item:nth-child(1) h5::after {
      background: #6cc24a;
    }

    .kidba-item:nth-child(2) h5::after {
      background: #40b3e5;
    }

    .kidba-item:nth-child(3) h5::after {
      background: #ff9b21;
    }

    .kidba-item:nth-child(4) h5::after {
      background: #ff4f9a;
    }

    .kidba-item p {
      font-size: 14px;
      color: #777;
      margin: 0;
      max-width: 260px;
    }

    /* ================= RIGHT IMAGE ================= */
    .kidba-img {
      position: relative;
      display: inline-block;
    }

    .kidba-img img {
      width: 100%;
    }

    /* ================= MOBILE ================= */
    @media (max-width: 991px) {
      .kidba-title {
        font-size: 42px;
      }
    }

    @media (max-width: 767px) {
      .kidba-section {
        padding: 60px 0;
      }

      .kidba-title {
        font-size: 36px;
      }

      .kidba-item {
        flex-direction: column;
      }

      .icon-box {
        margin-bottom: 12px;
      }

      .kidba-item p {
        max-width: 100%;
      }
    }
    
/* ================= HERO SECTION ================= */
.kids-hero{
  min-height:100vh;
  background:url("images/hero-bg.jpg") center/cover no-repeat;
  display:flex;
  align-items:center;
  justify-content:center;
  text-align:center;
  position:relative;
}
.kids-hero::before{
  content:"";
  position:absolute;
  inset:0;
  background:rgba(255,255,255,0.6);
}
.kids-content{
  position:relative;
  max-width:900px;
}
.hero-top-text{
  font-size:14px;
  letter-spacing:2px;
  color:#ff7a3d;
  margin-bottom:25px;
}
.hero-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:64px;
  color:#333;
  line-height:1.3;
}
.hero-title img{
  width:70px;
  vertical-align:middle;
}
.flower-rotate{
  animation:spin 8s linear infinite;
}
@keyframes spin{
  from{transform:rotate(0)}
  to{transform:rotate(360deg)}
}
.hero-btn a{
  background:#6bcf9a;
  color:#fff;
  padding:14px 40px;
  border-radius:30px;
  display:inline-block;
  margin-top:35px;
  text-decoration:none;
}

/* ================= KIDS CARE SECTION (FIXED) ================= */
.kids-care{
  position:relative;
  padding:0;                
  overflow:hidden;
  background:#fff;
}

/* row full height */
.kids-care .row{
  min-height:100vh;
}

/* LEFT CONTENT CENTER */
.kids-care .col-lg-6:first-child{
  display:flex;
  flex-direction:column;
  justify-content:center;   
  padding:80px;            
}

/* LEFT CONTENT */
.care-tag{
  font-size:12px;
  letter-spacing:2px;
  color:#ff7a3d;
  font-weight:700;
}
.care-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:54px;
  margin:20px 0;
}
.care-desc{
  font-size:15px;
  color:#777;
  max-width:480px;
}
.care-progress{
  max-width:460px;
  height:6px;
  background:#eee;
  border-radius:5px;
  overflow:hidden;
  margin:30px 0;
}
.care-progress span{
  width:70%;
  height:100%;
  background:#f07c4a;
  display:block;
}
.care-btn{
  background:#6bcf9a;
  color:#fff;
  padding:14px 36px;
  border-radius:30px;
  text-decoration:none;
  display:inline-block;
}

/* RIGHT IMAGE FULL CONTAINER */
.care-image{
  padding:0;               
  height:100%;
}
.care-image img{
  width:100%;
  height:100vh;
  object-fit:cover;         
}

/* GIRAFFE POSITION */
.giraffe{
  position:absolute;
  bottom:0px;
  left:50%;
  transform:translateX(-50%);
  width:140px;
  z-index:5;
}

/* ================= VALUES STRIP ================= */
.values-strip{
  background:#fffaf0;
  text-align:center;
  padding:25px 0 0;
}
.values-inner{
  display:flex;
  justify-content:center;
  gap:50px;
  flex-wrap:wrap;
}
.values-inner span{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:36px;
}
.values-inner span::before{
  content:"# ";
  color:#ff7a3d;
}
.bottom-bar{
  height:12px;
  background:#2bb3c0;
  margin-top:18px;
}

/* ================= MOBILE ================= */
@media(max-width:991px){
  .hero-title{font-size:42px}
  .care-title{font-size:40px}
  .kids-care .row{min-height:auto}
  .kids-care .col-lg-6:first-child{padding:50px}
  .giraffe{width:100px;bottom:40px}
}
@media(max-width:767px){
  .kids-hero{min-height:auto;padding:80px 15px}
  .kids-care .col-lg-6:first-child{padding:30px}
  .giraffe{display:none}
  .values-inner span{font-size:24px}
}
/* ================= SECTION ================= */
.creative-section{
  background:#f07c4a;
  color:#fff;
  width:100%;
  min-height:30vh;      
  display:flex;
  align-items:center;
  padding:40px 0;      
}

/* ================= WRAP ================= */
.creative-wrap{
  width:100%;
  display:flex;
  align-items:center;
  justify-content:center;
  position:relative;
  padding:0 80px;
}

/* ================= LEFT ================= */
.creative-left{
  width:45%;
}

.creative-tag{
  font-size:12px;
  letter-spacing:2px;
  margin-bottom:20px;
}

.creative-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:64px;
  line-height:1.2;
  margin-bottom:30px;
}

.creative-btn{
  background:#f3c64d;
  color:#fff;
  padding:14px 42px;
  border-radius:30px;
  font-size:14px;
  font-weight:600;
  text-decoration:none;
  display:inline-block;
}

/* ================= DIVIDER ================= */
.creative-divider{
  width:1px;
  height:220px;
  background:rgba(255,255,255,0.4);
  margin:0 60px;
}

/* ================= RIGHT ================= */
.creative-right{
  width:45%;
  display:flex;
  align-items:center;
  justify-content:center;
  position:relative;
}

.creative-number{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:130px;
  font-weight:700;
}

/* vertical text */
.vertical-text{
  position:absolute;
  right:-70px;
  transform:rotate(90deg);
  font-size:14px;
  letter-spacing:2px;
  opacity:0.85;
}

/* ================= RESPONSIVE ================= */
@media (max-width:768px){
  .creative-section{
    padding:30px 0;
    min-height:auto;
  }
}
@media(max-width:991px){
  .creative-wrap{
    flex-direction:column;
    padding:60px 30px;
    text-align:center;
  }

  .creative-left,
  .creative-right{
    width:100%;
  }

  .creative-divider{
    width:60%;
    height:1px;
    margin:40px 0;
  }

  .creative-number{
    font-size:90px;
  }

  .vertical-text{
    position:static;
    transform:none;
    margin-top:15px;
  }
}

/* ================= QUALITY SECTION ================= */
.quality-section{
  padding:100px 20px;
  text-align:center;
  font-family:Arial, sans-serif;

  /* background image */
  background:url("images/bg-03.jpg") center top / contain no-repeat;
  position:relative;
  overflow:hidden;
}

/* soft white overlay (like screenshot) */
.quality-section::before{
  content:"";
  position:absolute;
  inset:0;
 background:rgba(255,255,255,0.45);
  z-index:0;
}

/* bring content above overlay */
.quality-section > *{
  position:relative;
  z-index:1;
}

/* ================= HEADER ================= */
.quality-tag{
  font-size:12px;
  letter-spacing:2px;
  color:#ff7a3d;
  display:block;
  margin-bottom:12px;
}

.quality-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:52px;
  margin:15px 0;
  color:#333;
}

.quality-desc{
  max-width:700px;
  margin:0 auto 30px;
  color:#777;
  font-size:15px;
}

/* ================= BUTTON ================= */
.quality-btn{
  display:inline-block;
  background:#6bcf9a;
  color:#fff;
  padding:14px 38px;
  border-radius:30px;
  text-decoration:none;
  font-size:14px;
  font-weight:600;
  margin-bottom:80px;
  transition:.3s;
}

.quality-btn:hover{
  background:#55b885;
}

/* ================= GRID ================= */
.kids-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:25px;
}

/* grid item */
.grid-item{
  position:relative;
  overflow:hidden;
  height:380px;
  border-radius:18px;
}

/* image */
.grid-item img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:transform .6s ease;
}

.grid-item:hover img{
  transform:scale(1.08);
}

/* overlay */
.grid-overlay{
  position:absolute;
  inset:0;
  background:linear-gradient(
    to top,
    rgba(0,0,0,0.7),
    rgba(0,0,0,0.15)
  );
  display:flex;
  flex-direction:column;
  justify-content:flex-end;
  padding:26px;
  color:#fff;
}

/* title */
.grid-overlay h3{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:24px;
  margin-bottom:8px;
}

/* text */
.grid-overlay p{
  font-size:14px;
  line-height:1.5;
}

/* footer text */
.quality-footer-text{
  margin:60px auto 0;
  text-align:center;
  font-size:15px;
  color:#666;
  max-width:720px;
}

/* ================= RESPONSIVE ================= */
@media(max-width:992px){
  .kids-grid{
    grid-template-columns:repeat(2,1fr);
  }
  .grid-item{ height:320px; }
  .quality-title{ font-size:42px; }
}

@media(max-width:576px){
  .kids-grid{
    grid-template-columns:1fr;
  }
  .grid-item{ height:280px; }
  .quality-title{ font-size:36px; }
}

/* ================= SECTION ================= */
.curriculum-section{
  background:#f4f4f4;
  padding:100px 40px;
  position:relative;
  overflow:hidden;
}

/* ================= LAYOUT ================= */
.curriculum-wrap{
  max-width:1300px;
  margin:0 auto;
  display:flex;
  align-items:center;
  gap:60px;
}

/* ================= LEFT ================= */
.curriculum-left{
  position:relative;
  width:45%;
  padding-left:20px;
}

/* blob IMAGE background */
.blob-bg{
  position:absolute;
  inset:-15px;                
  background:url("images/gradient-blob.webp") center/contain no-repeat;
  z-index:1;
  opacity:0.95;
}

/* main image */
.curriculum-image{
  position:relative;
  z-index:2;
}

.curriculum-image img{
  width:90%;                   
  margin-left:20px;            
  border-radius:40% 60% 55% 45%;
  display:block;
}
/* ================= SPIRAL IMAGE ================= */
.spiral-wrap{
  position:absolute;
  top:20px;
  left:20px;
  width:90px;
  height:90px;
  z-index:4;
}

/* rotating spiral */
.spiral-wrap img:first-child{
  width:100%;
  height:auto;
  animation:spin 10s linear infinite;
}

/* side sketch lines */
.spiral-lines{
  position:absolute;
  top:50%;
  left:-40px;
  width:70px;
  transform:translateY(-50%);
}

@keyframes spin{
  from{ transform:rotate(0deg); }
  to{ transform:rotate(360deg); }
}

/* ================= RIGHT ================= */
.curriculum-right{
  width:55%;
}

.small-tag{
  font-size:12px;
  letter-spacing:2px;
  font-weight:700;
  margin-bottom:10px;
}

.curriculum-title{
  font-family:"Love Ya Like A Sister", cursive;
  font-size:48px;
  font-weight:400;
  margin-bottom:20px;
}

.curriculum-desc{
  font-size:15px;
  color:#555;
  max-width:520px;
  margin-bottom:35px;
}

/* ================= FEATURES ================= */
.feature{
  display:flex;
  gap:20px;
  margin-bottom:22px;
}

.feature-box{
  width:64px;
  height:64px;
  border-radius:18px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:700;
  color:#fff;
  border:2px dashed #000;
}

.purple{ background:#b884f6; }
.pink{ background:#ff7fa8; }
.blue{ background:#8cc7ff; }

.feature-content h4{
  font-size:18px;
  margin-bottom:6px;
}

.feature-content p{
  font-size:14px;
  color:#666;
  max-width:420px;
}

/* ================= MOBILE ================= */
@media(max-width:992px){
  .curriculum-wrap{
    flex-direction:column;
  }

  .curriculum-left,
  .curriculum-right{
    width:100%;
  }

  .spiral-wrap{
    top:10px;
    left:10px;
    width:70px;
  }

  .curriculum-title{
    font-size:36px;
  }
}


</style>
</head>

<body>
<section class="kidba-section">
  <div class="container">
    <div class="row align-items-center">

      <!-- LEFT CONTENT -->
      <div class="col-lg-7">
        <h2 class="kidba-title">Welcome to Our Castle</h2>

        <p class="kidba-desc">
          Why Choose Achiever's Castle?
        </p>

        <div class="row">

          <!-- ITEM 1 -->
          <div class="col-md-6 d-flex kidba-item">
            <div class="icon-box">
              <img src="images/icon1.webp" alt="Holistic Learning">
            </div>
            <div>
              <h5>Holistic Learning</h5>
              <p>
                We go beyond academics, nurturing confidence, curiosity, and a lifelong love for learning.
              </p>
            </div>
          </div>

          <!-- ITEM 2 -->
          <div class="col-md-6 d-flex kidba-item">
            <div class="icon-box">
              <img src="images/icon2.webp" alt="Expert Support">
            </div>
            <div>
              <h5>Expert Support</h5>
              <p>
                Expert tutors provide personalized support, fostering confidence and academic success.
              </p>
            </div>
          </div>

          <!-- ITEM 3 -->
          <div class="col-md-6 d-flex kidba-item">
            <div class="icon-box">
              <img src="images/icon3.webp" alt="Positive Space">
            </div>
            <div>
              <h5>Positive Space</h5>
              <p>
                A warm and positive learning environment where every child feels safe and motivated.
              </p>
            </div>
          </div>

          <!-- ITEM 4 (EXTRA POINT) -->
          <div class="col-md-6 d-flex kidba-item">
            <div class="icon-box">
              <img src="images/icon4.webp" alt="Creative Growth">
            </div>
            <div>
              <h5>Creative Growth</h5>
              <p>
                Creative activities help children develop expression, imagination, and emotional strength.
              </p>
            </div>
          </div>

        </div>
      </div>

      <!-- RIGHT IMAGE -->
      <div class="col-lg-5 text-center">
        <div class="kidba-img">
          <img src="images/feature-img.webp" alt="Kid Image">
        </div>
      </div>

    </div>
  </div>
</section>
<!-- HERO -->
<section class="kids-hero">
  <div class="kids-content">
    <div class="hero-top-text">DISCOVER LEARNING AND WONDER</div>
    <h1 class="hero-title">
      Guided <img src="images/lion.png"> by Curiosity<br>
      Driven by Play, Empowered<br>
      by Growth <img src="images/flower.png" class="flower-rotate">
    </h1>
    <div class="hero-btn">
      <a href="#">START NOW</a>
    </div>
  </div>
</section>

<!-- KIDS CARE -->
<section class="kids-care">
  <div class="container-fluid"> 
    <div class="row g-0">       

      <div class="col-lg-6">
        <div class="care-tag">SMART LEARNING</div>
        <h2 class="care-title">Embrace Gentle Care and Comfort</h2>

        <p class="care-desc">
          Do you prefer the comfort of home for studying? Can't travel to our location?<br><br>
          <strong>We have the solution for you!</strong><br><br>
          At <strong>Achiever's Castle</strong>, we believe every student deserves opportunities
          for growth and success. Travel, health, or personal challenges should never stop
          them from experiencing the best learning programs.
        </p>
        
      </div>

      <div class="col-lg-6 care-image">
        <img src="images/kids-care.jpg">
      </div>

    </div>
  </div>

  <img src="images/giraffe.png" class="giraffe">
</section>

<!-- VALUES -->
<section class="values-strip">
  <div class="container">
    <div class="values-inner">
      <span>Imagination</span>
      <span>Exploration</span>
      <span>Kindness</span>
    </div>
  </div>
  <div class="bottom-bar"></div>
</section>

<section class="creative-section">
  <div class="creative-wrap">

    <!-- LEFT -->
    <div class="creative-left">
      <div class="creative-tag">SMART AND SIMPLE</div>

      <h2 class="creative-title">
        Creative ideas for
        Smart people
      </h2>

      <a href="#" class="creative-btn">JOIN NOW</a>
    </div>

    <!-- CENTER LINE -->
    <div class="creative-divider"></div>

    <!-- RIGHT -->
    <div class="creative-right">
      <div class="creative-number" data-target="180">+100</div>
      <div class="vertical-text">The Power of Consistency</div>
    </div>

  </div>
</section>
<section class="quality-section">

  <div class="quality-header">
    <span class="quality-tag">SMART AND SIMPLE</span>
    <h2 class="quality-title">
      Learning Without Limits
    </h2>
    <p class="quality-desc">
      Here’s why Achiever’s Castle offers online classes — so your learning never stops.
    </p>
    <a href="#" class="quality-btn">EXPLORE ONLINE CLASSES</a>
  </div>

  <!-- GRID -->
  <div class="kids-grid-section">
    <div class="kids-grid">

      <!-- ITEM 1 -->
      <div class="grid-item">
        <img src="images/why-img.jpg" alt="">
        <div class="grid-overlay">
          <h3>Learn From Home</h3>
          <p>
            Study comfortably from your own home, at your own pace, without the stress of travel.
          </p>
        </div>
      </div>

      <!-- ITEM 2 -->
      <div class="grid-item">
        <img src="images/why-img.jpg" alt="">
        <div class="grid-overlay">
          <h3>Expert Educators</h3>
          <p>
            Access top-tier educators and quality learning resources no matter where you are.
          </p>
        </div>
      </div>

      <!-- ITEM 3 -->
      <div class="grid-item">
        <img src="images/why-img.jpg" alt="">
        <div class="grid-overlay">
          <h3>Personalized Learning</h3>
          <p>
            Master concepts at your own speed with flexible, personalized learning paths.
          </p>
        </div>
      </div>

      <!-- ITEM 4 -->
      <div class="grid-item">
        <img src="images/why-img.jpg" alt="">
        <div class="grid-overlay">
          <h3>Continuous Support</h3>
          <p>
            Real-time help through chats, emails, recorded sessions, quizzes, and one-on-one mentoring.
          </p>
        </div>
      </div>

    </div>
</div>

  <p class="quality-footer-text">
    We’re here to support you every step of the way.  
    Let’s dive into an enriching educational experience — see you in class!
  </p>

</section>

<!-- -----why choose us------->
<section class="curriculum-section">
  <div class="curriculum-wrap">

    <!-- LEFT -->
    <div class="curriculum-left">

      <!-- spiral + sketch -->
      <div class="spiral-wrap">
        <img src="images/spin-rot-01.webp" alt="Spiral">
        <img src="images/spin-rot-02.webp" class="spiral-lines" alt="Lines">
      </div>

      <!-- blob bg -->
      <div class="blob-bg"></div>

      <!-- main image -->
      <div class="curriculum-image">
        <img src="images/blob-img.webp" alt="Kids">
      </div>

    </div>

    <!-- RIGHT -->
<div class="curriculum-right">

  <span class="small-tag">WHY CHOOSE OUR CLASSES</span>

  <h2 class="curriculum-title">
    Learning That Inspires<br>
    Real Growth
  </h2>

  <p class="curriculum-desc">
    At <strong>Achiever’s Castle</strong>, we believe education is the most powerful tool
    for personal transformation. Since our founding, our mission has been to make
    high-quality, personalized learning accessible to students everywhere — without
    limits or barriers.
  </p>

  <div class="feature">
    <div class="feature-box purple">01</div>
    <div class="feature-content">
      <h4>Personalized Learning Journey</h4>
      <p>
        Every child learns differently. Our approach adapts to individual strengths,
        pace, and learning styles to build confidence and mastery.
      </p>
    </div>
  </div>

  <div class="feature">
    <div class="feature-box pink">02</div>
    <div class="feature-content">
      <h4>Expert-Led Interactive Classes</h4>
      <p>
        Learn from experienced educators who engage, motivate, and support students
        through interactive and meaningful sessions.
      </p>
    </div>
  </div>
</div>
</section>



<!-- ================= COUNTER JS ================= -->
<script>
  const counter = document.querySelector(".creative-number");

  function runCounter(){
    const target = +counter.getAttribute("data-target");
    let current = 0;
    const speed = 200; // slow / fast control

    const update = () => {
      const increment = Math.ceil(target / speed);

      if(current < target){
        current += increment;
        counter.textContent = "+" + current;
        setTimeout(update, 20);
      } else {
        counter.textContent = "+" + target;
      }
    };

    update();
  }

  window.addEventListener("load", runCounter);
</script>
<?php include('footer.php'); ?>
</body>
</html>
