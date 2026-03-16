  <!-- FONT AWESOME (FOR ICONS) -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


  <!-- ================= FOOTER CSS ================= -->
  <style>


  .footer-main *, .insta-strip *{
    box-sizing:border-box;

  }
  html, body{
    width:100%;
    overflow-x:hidden;
  }
  /* ================= INSTAGRAM STRIP ================= */
  .insta-strip{
    background:#fff;
    padding:80px 20px 210px;
    text-align:center;
    position:relative;
    z-index:3;
  }

  .insta-link{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:56px;
    line-height:1.1;
    color:#111;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:12px;
    margin-bottom:60px;
  }

  .insta-icon{
    width:34px;
    opacity:0;
    transform:scale(.6);
    transition:.3s ease;
  }

  .insta-link:hover .insta-icon{
    opacity:1;
    transform:scale(1);
  }

  /* ================= INSTAGRAM CARDS ================= */
.insta-images{
  position:absolute;
  left:50%;
  bottom:-90px;
  transform:translateX(-50%);
  display:flex;
  justify-content:center;
  align-items:center;
  gap:16px;
  max-width:1050px;
  width:100%;
  padding:0 10px;
  z-index:5;
}

  .insta-images img{
    width:210px;
    height:260px;
    object-fit:cover;
    background:#fff;
    border:3px solid #fff;
    box-shadow:0 25px 40px rgba(0,0,0,.25);
  }

  /* ZIG ZAG ROTATION */
  .insta-images img:nth-child(1){transform:rotate(-10deg) translateY(35px);}
  .insta-images img:nth-child(2){transform:rotate(7deg) translateY(-20px);}
  .insta-images img:nth-child(3){transform:rotate(-6deg) translateY(45px);}
  .insta-images img:nth-child(4){transform:rotate(9deg) translateY(-30px);}
  .insta-images img:nth-child(5){transform:rotate(-8deg) translateY(30px);}
  .insta-images img:nth-child(6){transform:rotate(6deg) translateY(-25px);}

  /* ================= FOOTER ================= */
  .footer-main{
    background:#0b3c74;
    margin-top:-60px;
    padding:220px 40px 70px;
    position:relative;
    overflow:hidden;
  }

  /* ZIG ZAG TOP */
  .footer-main::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:120px;
    background:#0b3c74;
    clip-path:polygon(
      0 45%,10% 65%,20% 45%,30% 65%,40% 45%,
      50% 65%,60% 45%,70% 65%,80% 45%,90% 65%,100% 45%,
      100% 100%,0 100%
    );
    transform:translateY(-100%);
  }

  /* FOOTER CONTENT */
  .footer-logo{
    max-width:200px;
    margin-bottom:18px;
  }

  .footer-box h4{
    font-weight:700;
    margin-bottom:15px;
    color:#fff;
  }

  .footer-box p{
    font-size:15px;
    line-height:1.7;
    color:#fff;
  }

  .footer-box ul{
    list-style:none;
    padding:0;
  }

  .footer-box ul li{margin-bottom:10px;}

  .footer-box ul a{
    color:#fff;
    text-decoration:none;
  }

  .footer-box ul a:hover{
    color:#d62828;
    text-decoration:none;
  }

  .footer-social{
    display:flex;
    gap:14px;
    margin-top:14px;
  }

  .footer-social a{
    width:40px;
    height:40px;
    border-radius:50%;
    background:rgba(255,255,255,0.15);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:18px;
    transition:0.3s ease;
    text-decoration:none;
  }

  .footer-social a:hover{
    background:#d62828;
    transform:translateY(-3px);
  }


  /* ================= BOTTOM BAR ================= */
  .footer-bottom{
    background:#d62828;
    color:#fff;
    padding:18px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    font-size:14px;
  }

  .payment-icons img{
    height:26px;
    margin-left:10px;
  }

  /* ================= MOBILE ================= */
  @media(max-width:768px){

    /* hide insta on mobile */
    .insta-strip{display:none;}

    .footer-main{
      margin-top:0;
      padding:30px 20px 60px;
    }
  /* ZIG ZAG TOP */
  .footer-main::before{
    display: none;
  }
    .footer-box{
      text-align:center;
      margin-bottom:35px;
    }

    .footer-social{
      justify-content:center;
    }

    .footer-bottom{
      flex-direction:column;
      gap:10px;
      text-align:center;
    }
  }

  </style>



  <!-- ================= FOOTER HTML ================= -->

  <footer>


  <!-- INSTAGRAM STRIP -->
  <div class="insta-strip">

    <a href="https://www.instagram.com/achievers.castle/"
      target="_blank"
      class="insta-link">

      Follow Instagram @achievers.castle
<!-- 
      <span class="insta-icon">
        <img src="images/instagram.svg" alt="">
      </span> -->

    </a>


    <div class="insta-images">

      <img src="./assets/img/class/footer1.png" alt="">
      <img src="./assets/img/class/footer2.png" alt="">
      <img src="./assets/img/class/footer3.png" alt="">
      <img src="./assets/img/class/footer4.png" alt="">
      <img src="./assets/img/class/footer5.png" alt="">
      <img src="./assets/img/class/footer6.png" alt="">

    </div>

  </div>



  <!-- FOOTER MAIN -->
  <div class="footer-main">

    <div class="container">
      <div class="row">


        <!-- ABOUT -->
        <div class="col-lg-3 col-md-6 footer-box">

          <img src="images/logo-footer.png"
              class="footer-logo"
              alt="Achiever's Castle">

          <p>Giving your child the best start in life</p>


          <h4>Social Media</h4>

          <div class="footer-social">

            <a href="https://www.facebook.com/people/Achievers-Castle/61558107806939/"
              aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>

            <a href="https://www.instagram.com/achievers.castle/"
              aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>

            <a href="https://www.linkedin.com/company/achiever-s-castle/posts/?feedView=all"
              aria-label="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>

          </div>

        </div>



        <!-- CONTACT -->
        <div class="col-lg-3 col-md-6 footer-box">

          <h4>Get In Touch</h4>

          <p>
            <b>Address:</b><br>
            11-102 Cope Crescent<br>
            Saskatoon, SK
          </p>

          <p><b>Call:</b> (639) 384-2844</p>

          <p><b>Email:</b> info@achieverscastle.com</p>

        </div>



        <!-- LINKS -->
        <div class="col-lg-3 col-md-6 footer-box">

          <h4>Useful Links</h4>

          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="blog.php">Blogs</a></li>
            <li><a href="class.php">Programs</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>

        </div>



        <!-- OTHER -->
        <div class="col-lg-3 col-md-6 footer-box">

          <h4>Other Links</h4>

          <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Use</a></li>
            <li><a href="#">Refund Policy</a></li>
          </ul>

        </div>


      </div>
    </div>

  </div>



  <!-- BOTTOM BAR -->
  <div class="footer-bottom">

    <div>
      © <?php echo date('Y'); ?> Achiever's Castle. All Rights Reserved.
    </div>

    <!-- <div class="payment-icons">

      <img src="images/visa.png" alt="">
      <img src="images/master.png" alt="">
      <img src="images/paypal.png" alt="">
      <img src="images/skrill.png" alt="">

    </div> -->

  </div>


  </footer>
