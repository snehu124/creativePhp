   <!DOCTYPE html>
  <html lang="en">
  <head>
  <meta charset="UTF-8">
  <title>Home | Achiever's Castle</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">



  <style>
  *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: "Poppins", sans-serif;
  }



  /* ================= SECTION ================= */
      .kidba-section {
        padding-top: 100px;
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
        padding:40px 10px 0;
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
    padding: 100px 0px;
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
  .testimonial-heading{
  font-family: "Love Ya Like A Sister", cursive;
  font-size: 48px;
  text-align: center;
  margin-bottom: 50px;
  color: #fff;
}

.ac-testimonial-item{
  text-align: center;
  padding: 20px;
}

.ac-testimonial-item p{
  font-size: 20px;
  line-height: 1.7;
  max-width: 700px;
  margin: 0 auto 20px;
}

.review-name{
  letter-spacing: 3px;
  font-weight: 700;
  color: #f2ff00;
}
  /* ================= RESPONSIVE HERO ================= */

  /* LAPTOP / SMALL DESKTOP */
  @media (max-width:1200px){
    .hero-title{
      font-size:56px;
    }

    .hero-title img{
      width:60px;
    }
  }

  /* TABLET */
  @media (max-width:992px){
    .kids-hero{
      padding:80px 20px;
      min-height:auto;
    }

    .kids-content{
      max-width:760px;
    }

    .hero-title{
      font-size:48px;
      line-height:1.25;
    }

    .hero-title img{
      width:55px;
    }

    .hero-top-text{
      margin-bottom:20px;
    }
  }

  /* MOBILE */
  @media (max-width:768px){
    .kids-hero{
      padding:70px 15px;
      text-align:center;
    }

    .hero-top-text{
      font-size:12px;
      letter-spacing:1.5px;
      margin-bottom:18px;
    }

    .hero-title{
      font-size:34px;
      line-height:1.3;
    }

    .hero-title img{
      width:38px;
      margin:0 4px;
    }

    .hero-btn a{
      padding:14px 34px;
      font-size:14px;
    }
  }

  /* SMALL MOBILE */
  @media (max-width:480px){
    .hero-title{
      font-size:30px;
    }

    .hero-title img{
      width:32px;
    }
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
    content:"# "
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
    background:url("images/bg-04.jpg") center top / cover no-repeat;
    position:relative;
  }

  .quality-section::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(255,255,255,0.45);
  }

  .quality-section > *{
    position:relative;
    z-index:1;
  }

  /* HEADER */
  .quality-tag{
    font-size:12px;
    letter-spacing:2px;
    color:#ff7a3d;
    margin-bottom:10px;
    display:block;
  }

  .quality-title{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:48px;
    margin-bottom:15px;
  }

  .quality-desc{
    max-width:650px;
    margin:0 auto 30px;
    color:#666;
  }

  .quality-btn{
    background:#6bcf9a;
    color:#fff;
    padding:14px 36px;
    border-radius:30px;
    text-decoration:none;
    display:inline-block;
    margin-bottom:70px;
  }

  /* GRID */
  .kids-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
  }

  /* CARD */
  .grid-item{
    border-radius:18px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 12px 25px rgba(0,0,0,0.1);
    transition:.3s;
  }

  .grid-item:hover{
    transform:translateY(-6px);
  }

  /* IMAGE */
  .grid-item img{
    width:100%;
    height:220px;
    object-fit:cover;
  }

  /* CONTENT BOX */
  .content-box{
    padding:22px;
    text-align:left;
  }

  .content-box h3{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:22px;
    margin-bottom:8px;
  }

  .content-box p{
    font-size:14px;
    color:#333;
    margin:0;
    line-height:1.5;
  }

  /* DIFFERENT COLORS */
  .color-1{ background:#e8f7f1; }
  .color-2{ background:#fff1e6; }
  .color-3{ background:#eef3ff; }
  .color-4{ background:#fff0f6; }

  /* RESPONSIVE */
  @media(max-width:992px){
    .kids-grid{ grid-template-columns:repeat(2,1fr); }
  }

  @media(max-width:576px){
    .kids-grid{ grid-template-columns:1fr; }
    .quality-title{ font-size:36px; }
  }


  /* ================= SECTION ================= */
  .curriculum-section{
    background:#f4f4f4;
    padding:50px 40px;
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
    width:115%;
    height:auto;
    animation:spin 10s linear infinite;
  }

  /* side sketch lines */
  .spiral-lines {
      position: absolute;
      top: 63%;
      left: -22px;
      width: 70px;
      transform: translateY(-100%);
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
  .counter-strip{
    background:#1f669c;
    padding:40px 40px;
    border-radius:0 0 60px 60px;
  }

  .counter-wrap{
    max-width:1300px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:40px;
  }

  .counter-item{
    position:relative;
    text-align:center;
    color:#fff;
  }

  /* BIG background number */
  .counter-bg {
      font-family: "Love Ya Like A Sister", cursive;
      font-size: 100px;
      color: rgb(255 255 255 / 25%);
      display: block;
      line-height: 1;
  }
  /* text ABOVE number */
  .counter-item p{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:500;
    z-index:2;
  }

  /* responsive */
  @media(max-width:992px){
    .counter-wrap{
      grid-template-columns:repeat(2,1fr);
    }
  }

  @media(max-width:576px){
    .counter-wrap{
      grid-template-columns:1fr;
    }
    .counter-bg{
      font-size:90px;
    }
  }
  /* center container */
  .focus-wrapper{
    width:100%;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:60px 20px;
  }

  /* main text */
  .headline{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:80px;
    text-align:center;
    white-space:nowrap;
  font-weight:400;
  }

  /* animated word area */
  .word-mask{
    display:inline-block;
    position:relative;
    min-width:300px;        
    height:1.3em;
    overflow:visible;      
    vertical-align:middle;
  }

  /* words */
  .word{
    position:absolute;
    left:50%;
    top:0;
    transform:translateX(-50%) scale(0.96);
    opacity:0;
    white-space:nowrap;
  }

  /* active animation */
  .word.active{
    animation: fadeZoom 2s ease-in-out forwards;
  }

  @keyframes fadeZoom{
    0%{
      opacity:0;
      transform:translateX(-50%) scale(0.96);
    }
    25%{
      opacity:1;
      transform:translateX(-50%) scale(1);
    }
    75%{
      opacity:1;
      transform:translateX(-50%) scale(1);
    }
    100%{
      opacity:0;
      transform:translateX(-50%) scale(1.04);
    }
  }

  /* responsive */
  @media(max-width:768px){
    .headline{font-size:38px}
    .word-mask{min-width:200px}
    .number-img{
        width:180px;
        margin-left:0;
    }
  }

  /* ================= SECTION ================= */
  .pricing-section{
    padding:50px 20px 80px;
    background:#1f669c;
    max-width:100%;
  }

  /* ================= HEADING ================= */
  .pricing-heading{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:56px;
    margin-bottom:60px;
    color:#fff;
  }

  /* ================= TABS ================= */
  .pricing-tabs{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-bottom:70px;
  }

  .pricing-tab{
    padding:14px 36px;
    border-radius:40px;
    border:2px solid #e8063c;
    background:transparent;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s ease;
    color:#fff;
    white-space:nowrap;
  }

  .pricing-tab.active,
  .pricing-tab:hover{
    background:#e8063c;
    color:#fff;
  }

  /* ================= CONTENT ================= */
  .pricing-content{
    max-width:1030px;
    margin:auto;
    display:none;
    animation:fadeUp .4s ease;
  }

  .pricing-content.active{
    display:block;
  }

  /* ================= PRICE CARD ================= */
  .price-row{
    display:grid;
    grid-template-columns:1.2fr 1fr 1fr auto;
    align-items:center;
    gap:30px;
    background:#fff;
    padding:40px 50px;
    margin-bottom:30px;
    border-radius:30px;
    box-shadow:0 20px 50px rgba(0,0,0,0.08);
  }

  /* ================= PRICE ================= */
  .price{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:54px;
    color:#000;
  }

  .price span{
    font-size:24px;
    vertical-align:top;
  }

  .plan-name{
    font-size:18px;
    margin-top:6px;
    color:#444;
  }

  /* ================= FEATURES ================= */
  .features{
    list-style:none;
    padding:0;
    margin:0;
  }

  .features li{
    margin-bottom:12px;
    font-size:15px;
    color:#444;
  }

  .features li::before{
    content:"✔";
    margin-right:10px;
    color:#7a3df0;
  }

  /* ================= BUTTON ================= */
  .price-btn{
    padding:12px 30px;
    border-radius:30px;
    border:none;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:.3s ease;
    white-space:nowrap;
  }

  .red{
    background:#e8063c;
    color:#fff;
  }

  .yellow{
    background:#f2c24d;
    color:#fff;
  }

  .price-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
  }

  /* ================= NOTE ================= */
  .pricing-note{
    max-width:1200px;
    margin:20px auto 0;
    font-size:17px;
    color:#dddddd;
  }

  /* ================= ANIMATION ================= */
  @keyframes fadeUp{
    from{
      opacity:0;
      transform:translateY(20px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  /* ================= RESPONSIVE ================= */

  /* TABLET */
  @media(max-width:992px){
    .price-row{
      grid-template-columns:1fr;
      gap:22px;
      padding:35px;
    }
  }

  /* MOBILE */
  @media(max-width:768px){

    .cloud-mask-section{
      height:110px;
      -webkit-mask-position:center top;
      mask-position:center top;
    }

    .pricing-heading{
      font-size:28px;
      text-align:center;
      line-height:1.2;
      margin-bottom:40px;
    }

    .pricing-tabs{
      justify-content:flex-start;
      overflow-x:auto;
      white-space:nowrap;
      gap:12px;
      padding-bottom:10px;
    }

    .pricing-tab{
      flex:0 0 auto;
      padding:12px 26px;
      font-size:15px;
    }

    .price{
      font-size:42px;
    }

    .plan-name{
      font-size:16px;
    }

    .features li{
      font-size:14px;
    }

    .price-btn{
      width:100%;
      padding:14px;
      text-align:center;
    }

    .pricing-note{
      font-size:15px;
      text-align:center;
      padding:0 10px;
    }
  }

  /* ===== BANNER ===== */
  .animated-banner{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:40px 20px;

    /* IMAGE BACKGROUND */
    background:url("images/Group 1.png") center center / cover no-repeat;
    position:relative;
    overflow:hidden;
  }

  .banner-content{
    max-width:900px;
  }

  /* small tag */
  .banner-tag{
    font-size:13px;
    letter-spacing:3px;
    color:#ff7a3d;
    display:block;
    margin-bottom:20px;
  }

  /* title */
  .banner-title{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:64px;
    line-height:1.25;
    color:#fff;
    white-space:normal;  
    overflow:visible;    
  }

  .word-wrapper{
    display:inline-block;
    position:relative;
    min-width:278px;
    height:1.3em;      
    vertical-align:middle;
  }

  .word{
    position:absolute;
    left:50%;
    top:0;
    transform:translateX(-40%) scale(0.95);
    font-family:"Love Ya Like A Sister", cursive;
    opacity:0;
    pointer-events:none;
  }

  .word.active{
    animation: wordFade 1.8s ease forwards;
  }
  @keyframes wordFade{
    0%{
      opacity:0;
      transform:translateX(-50%) scale(0.95);
    }
    25%{
      opacity:1;
      transform:translateX(-50%) scale(1);
    }
    75%{
      opacity:1;
      transform:translateX(-50%) scale(1);
    }
    100%{
      opacity:0;
      transform:translateX(-50%) scale(1.05);
    }
  }

  /* description */
  .banner-desc{
    font-size:16px;
    color:#fff;
    max-width:600px;
    margin:0 auto 35px;
  }

  /* button */
  .banner-btn{
    display:inline-block;
    padding:14px 40px;
    background:#d6b125;
    color:#fff;
    border-radius:30px;
    text-decoration:none;
    font-weight:600;
    transition:transform 0.3s ease;
  }

  .banner-btn:hover{
    transform:translateY(-3px);
  }

  /* responsive */
  @media(max-width:768px){
    .banner-title{
      font-size:42px;
    }

    .word-wrapper{
      min-width:240px;
    }
  }

  .magic-section{
    padding:80px 80px;
    text-align:center;
    background:#fff;
    
  }

  /* TAG */
  .magic-tag{
    font-size:12px;
    letter-spacing:2px;
    color:#7bbf3b;
    font-weight:600;
  }

  /* HEADING – EXACT FONT */
  .magic-heading{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:48px;
    margin:20px 0 90px;
    color:#111;
  }

  /* CARDS GRID */
  .magic-cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:30px;
    align-items:stretch;
  }

  /* CARD BASE */
  .magic-card{
    padding:90px 28px 45px;
    border-radius:140px 140px 30px 30px;
    color:#fff;
    position:relative;
    border:2px dashed rgba(0,0,0,0.35);
    display: flex;
    flex-direction: column;
  }

  /* IMAGE CIRCLE */
  .card-img{
     width: 139px;
    height: 139px;
    border-radius:50%;
    overflow:hidden;
    background:#fff;
    margin:-140px auto 20px;
  }

  .card-img img{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position: bottom center;
  }

  /* TITLE */
  .magic-card h4{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:22px;
    margin-bottom:12px;
  }

  /* TEXT */
  .magic-card p{
    font-size:14px;
    line-height:1.6;
    margin-bottom:26px;
  }

  /* BUTTON */
  .magic-card a{
    display:inline-block;
    padding:12px 30px;
    background:#8a4af3;
    color:#fff;
    border-radius:30px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    margin-top: auto;
  }

  /* COLORS */
  .purple{ background:#cfa4f4; }
  .orange{ background:#f07c4a; }
  .pink{ background:#ff7aa8; }
  .blue{ background:#7fc1ff; }

  /* ================= MAGIC SECTION RESPONSIVE ================= */

  /* LARGE LAPTOP */
  @media (max-width:1200px){
    .magic-section{
      padding:80px 40px;
    }

    .magic-heading{
      font-size:42px;
      margin-bottom:70px;
    }

    .magic-card{
      padding:80px 24px 40px;
    }

    .card-img{
      width:140px;
      height:140px;
      margin:-120px auto 18px;
    }
  }

  /* TABLET */
  @media (max-width:992px){
    .magic-section{
      padding:70px 30px;
    }

    .magic-cards{
      grid-template-columns:repeat(2,1fr);
      gap:35px;
    }

    .magic-heading{
      font-size:38px;
      margin-bottom:60px;
    }

    .magic-card{
      padding:85px 26px 42px;
    }

    .card-img{
      width:150px;
      height:150px;
      margin:-130px auto 20px;
    }
  }

  /* MOBILE */
  @media (max-width:768px){
    .magic-section{
      padding:60px 18px;
    }

    .magic-tag{
      font-size:11px;
    }

    .magic-heading{
      font-size:32px;
      margin-bottom:50px;
    }

    .magic-cards{
      grid-template-columns:1fr;
      gap:45px;
    }

    .magic-card{
      padding:90px 26px 45px;
      max-width:360px;
      margin:auto;
    }

    .card-img{
      width:140px;
      height:140px;
      margin:-130px auto 18px;
    }

    .magic-card h4{
      font-size:20px;
    }

    .magic-card p{
      font-size:14px;
    }
  }

  /* SMALL MOBILE */
  @media (max-width:480px){
    .magic-heading{
      font-size:28px;
    }

    .magic-card{
      padding:85px 22px 42px;
    }

    .card-img{
      width:130px;
      height:130px;
      margin:-120px auto 16px;
    }

    .magic-card a{
      padding:11px 26px;
      font-size:12px;
    }
  }

  /* ================= CLOUD MASK SECTION ================= */
  .cloud-mask-section{
    width:100%;
    height: 151px;                 
    background:#1f669c;            

    /* MASK IMAGE */
    -webkit-mask-image: url("images/cloud-mask.png");
    -webkit-mask-repeat: no-repeat;
    -webkit-mask-size: cover;
    -webkit-mask-position: center bottom;

    mask-image: url("images/cloud-mask.png");
    mask-repeat: no-repeat;
    mask-size: cover;
    mask-position: center bottom;
  }
  @media (max-width:768px){
    .cloud-mask-section{
      height:110px;
      -webkit-mask-position:center top;
      mask-position:center top;
    }
  }

  /* ===== FAQ SECTION ===== */
  .ac-faq-section{
    padding:100px 0;
    background:#fff;
  }

  /* prevent weird center issue */
  .ac-faq-row{
    align-items:center;
  }

  /* IMAGE */
  .ac-faq-image{
    position:relative;
    max-width:520px;
    margin:0 auto;   
    border-radius:60% 40% 60% 40%;
    overflow:hidden;
  }

  /* yellow bg */
  .ac-faq-bg-circle{
    position:absolute;
    top:-70px;
    left:-70px;
    width:220px;
    height:220px;
    background:#ffd400;
    border-radius:50%;
    z-index:1;
  }

  .ac-faq-image img{
    width:100%;
    display:block;
    position:relative;
    z-index:2;
  }

  /* play button */
  .ac-faq-play{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:90px;
    height:90px;
    background:#e60023;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    z-index:3;
  }
  .ac-faq-left{
    padding-right:20px;
  }

  .ac-faq-right{
    padding-left:20px;  
  }

  /* title */
  .ac-faq-title span{
    font-size:13px;
    letter-spacing:3px;
    color:#e60023;
    font-weight:600;
  
  }

  .ac-faq-title h2{
    font-size:46px;
    margin:10px 0 30px;
    font-family:"Love Ya Like A Sister", cursive;
    margin-bottom:12px;
  }

  /* FAQ ITEMS */
  .ac-faq-item{
    background:#faf6f0;
    border-radius:30px;
    margin-bottom:18px;
    transition:.3s ease;
  }

  .ac-faq-item:hover,
  .ac-faq-item.active{
    background:#1f669c;
    color:#fff;
  }

  .ac-faq-question{
    width:100%;
    padding:20px 70px 20px 28px;
    background:none;
    border:none;
    text-align:left;
    font-size:17px;
    font-weight:600;
    cursor:pointer;
    color:inherit;
    position:relative;
  }

  /* icon */
  .ac-faq-question::after{
    content:"+";
    position:absolute;
    right:18px;
    top:50%;
    transform:translateY(-50%);
    width:38px;
    height:38px;
    background:#fff;
    color:#222;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.3s;
  }

  .ac-faq-item.active .ac-faq-question::after{
    background:#e60023;
    color:#fff;
    content:"−";
  }

  /* answer */
  .ac-faq-answer{
    display:none;
    padding:0 28px 25px;
    font-size:15px;
    line-height:1.6;
  }

  .ac-faq-item.active .ac-faq-answer{
    display:block;
  }

  /* ================= TABLET (<= 991px) ================= */
  @media (max-width: 991px){

    .ac-faq-section{
      padding:80px 0;
    }

    .ac-faq-left{
      padding-right:0;
      margin-bottom:40px;
    }

    .ac-faq-image{
      max-width:420px;
      border-radius:50%;
    }

    .ac-faq-bg-circle{
      width:180px;
      height:180px;
      top:-50px;
      left:-50px;
    }

    .ac-faq-right{
      padding-left:0;
    }

    .ac-faq-title{
      text-align:center;
    }

    .ac-faq-title h2{
      font-size:34px;
    }

    .ac-faq-question{
      font-size:16px;
      padding:18px 60px 18px 24px;
    }
  }

  /* ================= MOBILE (<= 768px) ================= */
  @media (max-width: 768px){

    .ac-faq-section{
      padding:70px 15px;
    }

    .ac-faq-image{
      max-width:320px;
    }

    .ac-faq-bg-circle{
      width:150px;
      height:150px;
      top:-40px;
      left:-40px;
    }

    .ac-faq-title span{
      font-size:12px;
      letter-spacing:2px;
    }

    .ac-faq-title h2{
      font-size:28px;
      line-height:1.2;
    }

    .ac-faq-item{
      border-radius:22px;
    }

    .ac-faq-question{
      font-size:15px;
      padding:16px 55px 16px 22px;
    }

    .ac-faq-question::after{
      width:34px;
      height:34px;
      font-size:18px;
    }

    .ac-faq-answer{
      font-size:14px;
      padding:0 22px 22px;
    }
  }

  /* ================= SMALL MOBILE (<= 480px) ================= */
  @media (max-width: 480px){

    .ac-faq-image{
      max-width:260px;
    }

    .ac-faq-bg-circle{
      width:120px;
      height:120px;
      top:-30px;
      left:-30px;
    }

    .ac-faq-title h2{
      font-size:24px;
    }

    .ac-faq-question{
      font-size:14px;
      padding:15px 50px 15px 20px;
    }

    .ac-faq-question::after{
      width:30px;
      height:30px;
      font-size:16px;
    }

    .ac-faq-answer{
      font-size:13.5px;
    }
  }

  /* ===== TESTIMONIAL SECTION ===== */
    .ac-testimonial{
      background: linear-gradient(270deg, #1f669c, #e8063c, #6bcf9a, #f2c24d);
      background-size: 600% 600%;
      animation: testimonialBG 12s ease infinite;

      padding: 100px 0;
      color: #fff;
      position: relative;
      overflow: hidden;
      text-align: center;
    }

    /* Gradient Animation */
    @keyframes testimonialBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }


  /* FIX BOOTSTRAP ROW OVERFLOW */
  .ac-testimonial .row{
    margin-left:0;
    margin-right:0;
  }

  /* LEFT IMAGE */
  .ac-testimonial-image img{
    max-width:320px;
    width:100%;
  }

  /* SLIDER */
  .ac-testimonial-slider{
    max-width:600px;
    position:relative;
    overflow:hidden;   /* 🔥 IMPORTANT */
  }

  /* SLICK INTERNAL FIX */
  .ac-testimonial-slider .slick-track{
    display:flex;
  }

  .ac-testimonial-slider .slick-slide{
    height:auto !important;
  }

  /* CONTENT */
  .ac-testimonial-item{
    min-height:260px;   /* 🔥 Prevent layout jump */
  }

  .quote-icon{
    width:70px;
    margin-bottom:25px;
    filter: drop-shadow(0 0 8px rgba(255,255,255,0.6));
  }

  .review-name{
    font-size: 16px;
    letter-spacing: 3px;
    margin-top: 20px;
    font-weight: 700;
    color: #f2ff00;
  }

  /* HEADINGS */
  .ac-testimonial-item h3{
    font-size: 44px;
    font-weight: 700;
    margin-bottom: 18px;
    font-family:"Love Ya Like A Sister", cursive;
    letter-spacing: 1px;
  }

    .ac-testimonial-item p{
    font-size: 20px;
    line-height: 1.8;
    max-width: 600px;
    margin: auto;
    font-weight: 500;
  }

  /* DOTS – PERFECT CENTER */
  .slick-dots{
    position:absolute;
    bottom:-40px;
    left:0;
    right:0;
    display:flex !important;
    justify-content:center;
    gap:10px;
    padding:0;
  }

  .slick-dots li{
    margin:0;
  }

  .slick-dots li button{
    width:10px;
    height:10px;
    border-radius:50%;
    background:#ffffff80;
    border:none;
    font-size:0;
  }

  .slick-dots li.slick-active button{
    background:#00ff6a;
  }

  .ac-testimonial-item h3,
  .ac-testimonial-item p{
    text-shadow: 0 0 10px rgba(255,255,255,0.3);
  }

  /* ================= TABLET (<= 991px) ================= */
  @media (max-width: 991px){

    .ac-testimonial{
      padding:70px 20px;
      text-align:center;
    }

    .ac-testimonial-image{
      margin-bottom:35px;
    }

    .ac-testimonial-image img{
      max-width:260px;
      margin:auto;
    }

    .ac-testimonial-slider{
      max-width:100%;
      margin:auto;
    }

    .ac-testimonial-item{
      min-height:auto;
    }

    .ac-testimonial-item p{
      margin-left:auto;
      margin-right:auto;
    }

    .slick-dots{
      bottom:-28px;
    }
  }

  /* ================= MOBILE (<= 768px) ================= */
  @media (max-width: 768px){

    .ac-testimonial{
      padding:60px 15px;
    }

    .ac-testimonial-image img{
      max-width:220px;
    }

    .quote-icon{
      width:55px;
      margin:0 auto 15px;
      display:block;
    }

    .ac-testimonial-item h3{
      font-size:28px;
    }

    .ac-testimonial-item p{
      font-size:15px;
      line-height:1.6;
      max-width:100%;
    }

    .review-name{
      font-size:13px;
    }

    .slick-dots li button{
      width:9px;
      height:9px;
    }
  }

  /* ================= SMALL MOBILE (<= 480px) ================= */
  @media (max-width: 480px){

    .ac-testimonial{
      padding:50px 12px;
    }

    .ac-testimonial-image img{
      max-width:180px;
    }

    .ac-testimonial-item h3{
      font-size:24px;
    }

    .ac-testimonial-item p{
      font-size:14px;
    }

    .slick-dots{
      bottom:-22px;
      gap:8px;
    }
  }

  /* =====================================================
    CONTACT CLOUD SECTION – FINAL FIXED
  ===================================================== */

  .contact-cloud-section{
    position: relative;
    background: #f4f9fc;
    padding: 100px 0;
    overflow: hidden;
  }

  /* ================= BIG CLOUD BACKGROUND ================= */
  .contact-cloud-section::before{
    content: "";
    position: absolute;
    top: 50%;
    right: -140px;
    transform: translateY(-50%);
    width: 900px;
    height: 900px;
    background: url("images/cloud-bg.png") no-repeat;
    background-size: contain;
    background-position: right center;
    z-index: 1;
    pointer-events: none;
  }

  /* ================= LEFT CONTENT ================= */
  .contact-text{
    max-width: 520px;
    position: relative;
    z-index: 3;
  }

  .contact-subtitle{
    display: inline-block;
    font-size: 12px;
    letter-spacing: 3px;
    font-weight: 600;
    color: #e8063c;
    margin-bottom: 10px;
    text-transform: uppercase;
  }

  .contact-title{
    font-family: "Love Ya Like A Sister", cursive;
    font-size: 56px;
    line-height: 1.1;
    color: #111;
    margin: 15px 0 25px;
  }

  .contact-text p{
    font-size: 16px;
    line-height: 1.7;
    color: #555;
    margin-bottom: 14px;
  }

  /* ================= RIGHT FORM WRAPPER ================= */
  .cloud-form-wrapper{
    position: relative;
    z-index: 4;
    padding: 40px;
  }

  /* ================= WHITE FORM CARD ================= */
  .contact-form{
    background: #fff;
    border-radius: 30px;
    padding: 45px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
  }

  /* ================= FORM FIELDS ================= */
  .contact-form input,
  .contact-form textarea{
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 18px;
    font-size: 15px;
    color: #333;
    outline: none;
  }

  .contact-form input::placeholder,
  .contact-form textarea::placeholder{
    color: #999;
  }

  .contact-form textarea{
    height: 120px;
    resize: none;
  }

  /* ================= SUBMIT BUTTON ================= */
  .contact-btn{
    background: #e8063c;
    color: #fff;
    border: none;
    padding: 14px 52px;
    border-radius: 30px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
  }

  .contact-btn:hover{
    background: #111;
    transform: translateY(-2px);
  }

  .number-img{
      width: 500px;       
      max-width: 100%;
      height: auto;
      margin-left: -40px;
  }

  /* ================= LAPTOP / TABLET ================= */
  @media(max-width: 991px){

    .contact-cloud-section{
      padding: 80px 20px;
      text-align: center;
    }

    .contact-cloud-section::before{
      width: 650px;
      height: 650px;
      right: -260px;
      top: 60%;
    }

    .contact-text{
      margin: auto;
    }

    .contact-title{
      font-size: 42px;
    }

    .cloud-form-wrapper{
      margin-top: 40px;
      padding: 30px;
    }
  }

  /* ================= MOBILE ================= */
  @media(max-width: 768px){

    .contact-cloud-section{
      padding: 70px 15px;
    }

    .contact-cloud-section .container{
      padding-left: 12px;
      padding-right: 12px;
    }

    .cloud-form-wrapper{
      padding: 0;             
      margin-top: 35px;
    }

    .contact-cloud-section::before{
      width: 520px;
      height: 520px;
      right: -320px;
      top: 65%;
    }

    .contact-title{
      font-size: 36px;
    }

    .contact-form{
      padding: 22px;           
      width: 100%;
      border-radius: 22px;
    }
  }

  /* ================= SMALL MOBILE ================= */
  @media(max-width: 480px){

    .contact-cloud-section{
      padding: 60px 12px;
    }

    .contact-cloud-section::before{
      width: 420px;
      height: 420px;
      right: -360px;
      top: 70%;
    }

    .contact-title{
      font-size: 30px;
    }

    .contact-form{
      padding: 18px;
    }

    .contact-form input,
    .contact-form textarea{
      font-size: 14px;
    }

    .contact-btn{
      width: 100%;
      padding: 14px;
      font-size: 16px;
    }
  }



  </style>
  </head>

  <body>

 <?php include 'header.php'; ?>

  <!-- home section start here -->
  <section class="animated-banner">
    <div class="banner-content">

      <span class="banner-tag">DISCOVER LEARNING & WONDER</span>

      <h1 class="banner-title">
    We Focus on
    <span class="word-wrapper">
      <span class="word active">Learning</span>
      <span class="word">Creativity</span>
      <span class="word">Knowledge</span>
      <span class="word">Confidence</span>
    </span>
  </h1>

      <p class="banner-desc">
        Helping young minds grow with confidence, curiosity, and care.
      </p>

      <a href="class.php" class="banner-btn">START NOW</a>

    </div>
  </section>

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
                <img src="images/icon44.png" alt="Creative Growth">
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
            <img src="./assets/img/class/confident-castel-2.jpg" alt="Kid Image">
          </div>
        </div>

      </div>
    </div>
  </section>

  <div class="cloud-mask-section"></div>
  <section class="pricing-section">
    <!-- TABS -->
    <div class="pricing-tabs">
      <button class="pricing-tab active" data-tab="early">Early Starter</button>
      <button class="pricing-tab" data-tab="elementary">Elementary</button>
      <button class="pricing-tab" data-tab="advanced">Advance Learner</button>
    </div>

    <!-- EARLY STARTER -->
    <div class="pricing-content active" id="early">
      <h2 class="pricing-heading">Pre-School to Grade 2</h2>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>150</div>
          <div class="plan-name">Monthly Tuition</div>
        </div>

        <ul class="features">
          <li>Foundational Learning</li>
          <li>Reading & Writing Basics</li>
        </ul>

        <ul class="features">
          <li>Early Math Skills</li>
          <li>Concept Building</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <p class="pricing-note">
        <strong>Note:</strong> Sibling Discount of $10 will be applied when 1st child is also studying at the centre.
      </p>
    </div>

    <!-- ELEMENTARY -->
    <div class="pricing-content" id="elementary">
      <h2 class="pricing-heading">Grade 3 to Grade 8</h2>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>140</div>
          <div class="plan-name">One Program</div>
        </div>

        <ul class="features">
          <li>Math / Science</li>
          <li>Reading & Writing</li>
        </ul>

        <ul class="features">
          <li>Concept Clarity</li>
          <li>Regular Practice</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>270</div>
          <div class="plan-name">Two Programs</div>
        </div>

        <ul class="features">
          <li>Multiple Subjects</li>
          <li>Skill Enhancement</li>
        </ul>

        <ul class="features">
          <li>Guided Learning</li>
          <li>Weekly Assessments</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>400</div>
          <div class="plan-name">Three Programs</div>
        </div>

        <ul class="features">
          <li>All Core Subjects</li>
          <li>Personal Attention</li>
        </ul>

        <ul class="features">
          <li>Strong Foundations</li>
          <li>Academic Confidence</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <p class="pricing-note">
        <strong>Note:</strong> Sibling Discount of $10 will be applied when 1st child is also studying at the centre.
      </p>
    </div>

    <!-- ADVANCE -->
    <div class="pricing-content" id="advanced">
      <h2 class="pricing-heading">Grade 9 to Grade 12</h2>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>160</div>
          <div class="plan-name">One Program</div>
        </div>

        <ul class="features">
          <li>Subject Mastery</li>
          <li>Exam Preparation</li>
        </ul>

        <ul class="features">
          <li>Advanced Concepts</li>
          <li>Regular Testing</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>310</div>
          <div class="plan-name">Two Programs</div>
        </div>

        <ul class="features">
          <li>Multiple Subjects</li>
          <li>Focused Guidance</li>
        </ul>

        <ul class="features">
          <li>Exam Strategy</li>
          <li>Doubt Clearing</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <div class="price-row">
        <div>
          <div class="price"><span>$</span>460</div>
          <div class="plan-name">Three Programs</div>
        </div>

        <ul class="features">
          <li>All Major Subjects</li>
          <li>Personalized Support</li>
        </ul>

        <ul class="features">
          <li>Performance Tracking</li>
          <li>Goal-Oriented Learning</li>
        </ul>

        <button class="price-btn red">View Details</button>
      </div>

      <p class="pricing-note">
        <strong>Note:</strong> Sibling Discount of $10 will be applied when 1st child is also studying at the centre.
      </p>
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
        <a href="class.php">START NOW</a>
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
          Building Bright Student Futures
        </h2>

        <a href="class.php" class="creative-btn">ENROLL NOW</a>
      </div>

      <!-- CENTER LINE -->
      <div class="creative-divider"></div>

      <!-- RIGHT -->
      <div class="creative-right">
        <img src="./assets/img/class/brightness.png" alt="180 Plus Students" class="number-img">
        </div>
        <div class="vertical-text">Students Successfully Enrolled</div>
      </div>

  </section>

  <section class="magic-section">

    <span class="magic-tag">  WHY PARENTS TRUST US?</span>

    <h2 class="magic-heading">
  A Learning Space Parents Believe In
    </h2>

    <div class="magic-cards">

      <!-- CARD 1 -->
      <div class="magic-card purple">
        <div class="card-img">
          <img src="images/achievement-award_18447958.png" alt="">
        </div>
        <h4>Qualified Educators</h4>
        <p>
        Certified and trained educators focused on child growth.
        </p>
        <a href="#">GET STARTED →</a>
      </div>

      <!-- CARD 2 -->
      <div class="magic-card orange">
        <div class="card-img">
          <img src="images/Child Freindly learning (2).png" alt="">
        </div>
        <h4>Child-Friendly Learning</h4>
        <p>
          Fun, engaging and pressure-free teaching methods.
        </p>
        <a href="#">GET STARTED →</a>
      </div>

      <!-- CARD 3 -->
      <div class="magic-card pink">
        <div class="card-img">
          <img src="images/Confidnece & Imporvement .png" alt="">
        </div>
        <h4>Confidence & Improvement</h4>
        <p>
          Consistent improvement in confidence and performance.
        </p>
        <a href="#">GET STARTED →</a>
      </div>

      <!-- CARD 4 -->
      <div class="magic-card blue">
        <div class="card-img">
          <img src="images/Parents Satisfaction (2).png" alt="">
        </div>
        <h4>Parents Satisfaction</h4>
        <p>
    Trusted by hundreds of happy parents and growing families.
        </p>
        <a href="#">GET STARTED →</a>
      </div>

    </div>
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
  <section class="counter-strip" id="statsCounter">
    <div class="counter-wrap">

      <div class="counter-item">
        <span class="counter-bg" data-target="100" data-suffix="+">0</span>
        <p>Happy Parents</p>
      </div>

      <div class="counter-item">
        <span class="counter-bg" data-target="50" data-suffix="+">0</span>
        <p>Expert Tutors</p>
      </div>

      <div class="counter-item">
        <span class="counter-bg" data-target="10" data-suffix="+">0</span>
        <p>Years Experience</p>
      </div>

      <div class="counter-item">
        <span class="counter-bg" data-target="95" data-suffix="%">0</span>
        <p>Satisfaction Rate</p>
      </div>

    </div>
  </section>

  <!-- ================= QUALITY SECTION ================= -->
  <section class="quality-section">

    <div class="quality-header">
      <span class="quality-tag">SMART AND SIMPLE</span>
      <h2 class="quality-title">Learning Without Limits</h2>
      <p class="quality-desc">
        Here’s why Achiever’s Castle offers online classes — so your learning never stops.
      </p>
      <a href="#" class="quality-btn">EXPLORE ONLINE CLASSES</a>
    </div>

    <div class="kids-grid">

      <!-- CARD 1 -->
      <div class="grid-item">
        <img src="images/learn-home.jpeg" alt="">
        <div class="content-box color-1">
          <h3>Learn From Home</h3>
          <p>
            Study comfortably from your own home, at your own pace, without the stress of travel.
          </p>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="grid-item">
        <img src="images/export-educt.webp" alt="">
        <div class="content-box color-2">
          <h3>Expert Educators</h3>
          <p>
            Access top-tier educators and quality learning resources no matter where you are.
          </p>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="grid-item">
        <img src="images/personalized-learn.avif" alt="">
        <div class="content-box color-3">
          <h3>Personalized Learning</h3>
          <p>
            Master concepts at your own speed with flexible, personalized learning paths.
          </p>
        </div>
      </div>

      <!-- CARD 4 -->
      <div class="grid-item">
        <img src="images/continue-supp.jpeg" alt="">
        <div class="content-box color-4">
          <h3>Continuous Support</h3>
          <p>
            Real-time help through chats, emails, recorded sessions, quizzes, and mentoring.
          </p>
        </div>
      </div>

    </div>
  </section>
  <!-- ================== FAQ SECTION (ISOLATED) ================== -->
  <section class="ac-faq-section">
    <div class="container">
      <div class="row align-items-center ac-faq-row">

        <!-- LEFT IMAGE -->
        <div class="col-lg-6 ac-faq-left">
          <div class="ac-faq-image">
            <span class="ac-faq-bg-circle"></span>

            <img src="assets/img/about/faq-1-1.jpg" alt="FAQ">
          </div>
        </div>

        <!-- RIGHT FAQ -->
        <div class="col-lg-6 ac-faq-right">
    <div class="ac-faq-title">
      <span>CHOOSE YOUR OWN GRADE LEVEL</span>
      <h2>Frequently asked questions</h2>
    </div>

    <div class="ac-faq-list">

      <!-- FAQ 1 -->
      <div class="ac-faq-item active">
        <button class="ac-faq-question">
          What subjects do you offer tutoring for?
        </button>
        <div class="ac-faq-answer">
          We offer tutoring in a wide range of subjects, including Mathematics,
          Science, Reading, Writing and test preparation (IELTS, CELPIP, etc.).
          If you have a specific subject in mind, please contact us to check availability.
        </div>
      </div>

      <!-- FAQ 2 -->
      <div class="ac-faq-item">
        <button class="ac-faq-question">
          What age groups do you cater to?
        </button>
        <div class="ac-faq-answer">
          We provide tutoring for students of all ages, from pre-school through
          elementary school and high school. Our tutors are experienced in adapting
          lessons to suit the developmental stage of each student.
        </div>
      </div>

      <!-- FAQ 3 -->
      <div class="ac-faq-item">
        <button class="ac-faq-question">
          How do you match students with tutors?
        </button>
        <div class="ac-faq-answer">
          We take the time to understand each student’s learning style, goals,
          and preferences to ensure we pair them with the best tutor. Whether you
          prefer a more structured approach or a more flexible, conversational style,
          we’ll match you with a tutor who meets your needs.
        </div>
      </div>

      <!-- FAQ 4 -->
      <div class="ac-faq-item">
        <button class="ac-faq-question">
          Can tutors help with test preparation?
        </button>
        <div class="ac-faq-answer">
          Yes, our tutors specialize in test preparation for various standardized
          exams such as the IELTS, CELPIP and more. They will help students improve
          test-taking strategies, review content, and build confidence.
        </div>
      </div>

    </div>
  </div>


      </div>
    </div>
  </section>

  <!-- ========= TESTIMONIAL SECTION ========= -->
 <section class="ac-testimonial">

    <div class="container">

      <div class="row align-items-center">

        <!-- LEFT IMAGE -->

        <div class="col-lg-5 text-center">

          <div class="ac-testimonial-image">

            <img src="images/student.jpg" alt="Student">

          </div>

        </div>

        <!-- RIGHT SLIDER -->

        <div class="col-lg-7">

          <div class="ac-testimonial-slider">

    <div class="ac-testimonial-item">

      <img src="images/quote.webp" class="quote-icon" alt="">

      <h3>Clients Says?</h3>

      <p>

        “We had an amazing experience. The tutors were professional,

        patient, and really helped improve confidence and results.”

      </p>

      <h6 class="review-name">BENJAMEE</h6>

    </div>

    <div class="ac-testimonial-item">

      <img src="images/quote.webp" class="quote-icon" alt="">

      <h3>Clients Says?</h3>

      <p>

        “Excellent tutoring support. Flexible scheduling and great

        teaching methods made learning stress-free.”

      </p>

      <h6 class="review-name">EMILY</h6>

    </div>

    <div class="ac-testimonial-item">

      <img src="images/quote.webp" class="quote-icon" alt="">

      <h3>Clients Says?</h3>

      <p>

        “Highly recommended! Tutors helped my child excel academically

        and gain confidence.”

      </p>

      <h6 class="review-name">JACOB</h6>

    </div>

  </div>

        </div>

      </div>

    </div>

  </section>

  <section class="contact-cloud-section">
    <div class="container">
      <div class="row align-items-center">

        <!-- LEFT CONTENT -->
        <div class="col-lg-6">
          <div class="contact-text">
            <span class="contact-subtitle">GET IN TOUCH</span>
            <h2 class="contact-title">
              Join Achiever’s Castle
              Today!
            </h2>

            <p>
              Give your child the opportunity to grow academically,
              socially, and emotionally with Canada’s most supportive
              tutoring programs.
            </p>

            <p>
              Contact us today to schedule a free assessment and explore
              our wide range of programs. Together, let’s build a brighter,
              empowered future for your child!
            </p>
          </div>
        </div>

        <!-- RIGHT FORM -->
        <div class="col-lg-6">
          <div class="cloud-form-wrapper">

            <form class="contact-form">
              <div class="row">

                <div class="col-md-6">
                  <input type="text" placeholder="Your Name">
                </div>

                <div class="col-md-6">
                  <input type="text" placeholder="Father Name">
                </div>

                <div class="col-md-12">
                  <input type="email" placeholder="Email Address">
                </div>

                <div class="col-md-6">
                  <input type="text" placeholder="Phone No">
                </div>

                <div class="col-md-6">
                  <input type="text" placeholder="Subject">
                </div>

                <div class="col-md-12">
                  <textarea placeholder="How can we help you?"></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <button type="submit" class="contact-btn">
                    Submit Now
                  </button>
                </div>

              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ===== MOBILE MENU SCRIPT ===== -->
  <script>
    const openMenu = document.getElementById("openMenu");
    const closeMenu = document.getElementById("closeMenu");
    const sidebar = document.getElementById("mobileSidebar");
    const overlay = document.getElementById("sidebarOverlay");

    openMenu.onclick = () => {
      sidebar.classList.add("active");
      overlay.classList.add("active");
    };

    closeMenu.onclick = overlay.onclick = () => {
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    };

    document.querySelectorAll(".mobile-dropdown > a").forEach(item => {
      item.onclick = e => {
        e.preventDefault();
        item.parentElement.classList.toggle("open");
      };
    });
  </script>

  <script>
  const counters = document.querySelectorAll('.counter-bg');
  let counterStarted = false;

  function startCounters(){
    counters.forEach(counter => {
      const target = +counter.getAttribute('data-target');
      const suffix = counter.getAttribute('data-suffix') || '';
      let count = 0;
      const speed = 120;

      const update = () => {
        const increment = Math.ceil(target / speed);
        if(count < target){
          count += increment;
          counter.innerText = count + suffix;
          setTimeout(update, 20);
        } else {
          counter.innerText = target + suffix;
        }
      };

      update();
    });
  }

  window.addEventListener('scroll', () => {
    const section = document.getElementById('statsCounter');
    const sectionTop = section.getBoundingClientRect().top;
    const screenHeight = window.innerHeight;

    if(sectionTop < screenHeight - 100 && !counterStarted){
      startCounters();
      counterStarted = true;
    }
  });
  </script>


  <!-- <script>
  const words = document.querySelectorAll(".word");
  let index = 0;

  setInterval(()=>{
    words.forEach(w => w.classList.remove("active"));
    words[index].classList.add("active");
    index = (index + 1) % words.length;
  }, 2000);
  </script> -->

  <script>
  const tabs = document.querySelectorAll(".pricing-tab");
  const contents = document.querySelectorAll(".pricing-content");

  tabs.forEach(tab=>{
    tab.addEventListener("click",()=>{
      tabs.forEach(t=>t.classList.remove("active"));
      contents.forEach(c=>c.classList.remove("active"));

      tab.classList.add("active");
      document.getElementById(tab.dataset.tab).classList.add("active");
    });
  });
  </script>

  <script>
  const words = document.querySelectorAll(".word");
  let index = 0;

  setInterval(() => {
    words.forEach(w => w.classList.remove("active"));
    words[index].classList.add("active");
    index = (index + 1) % words.length;
  }, 1800); 
  </script>

  <script>
  document.querySelectorAll('.ac-faq-question').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const item = btn.closest('.ac-faq-item');
      document.querySelectorAll('.ac-faq-item').forEach(i=>i.classList.remove('active'));
      item.classList.add('active');
    });
  });
  </script>
  <!-- jQuery (MUST BE FIRST) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Slick JS -->
  <script src="assets/js/slick.min.js"></script>

  <script>
  window.addEventListener("load", function () {

    // safety check
    if (typeof jQuery === "undefined") {
      console.error("jQuery not loaded");
      return;
    }

    var $slider = $('.ac-testimonial-slider');

    // prevent double init
    if ($slider.length && !$slider.hasClass('slick-initialized')) {

      $slider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,

        autoplay: true,
        autoplaySpeed: 3000,
        speed: 700,

        fade: true,
        cssEase: 'ease-in-out',

        pauseOnHover: true,
        pauseOnFocus: false,

        adaptiveHeight: false,   
        infinite: true
      });

    }

  });
  </script>

<?php include 'footer.php'; ?>

  </body>
  </html>
