<?php
include 'db_config.php';

// Get ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query
$sql = "SELECT * FROM early_learner_courses WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if ($row = mysqli_fetch_assoc($result)) {
    // Data fetched
} else {
    echo "Course not found.";
    exit;
}
?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Kiddino - Children School & Kindergarten HTML Template - Class Details</title>
    <meta name="author" content="Vecuro">
    <meta name="description" content="Kiddino - Children School & Kindergarten HTML Template">
    <meta name="keywords" content="Kiddino - Children School & Kindergarten HTML Template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Jost:wght@400;500&display=swap"
        rel="stylesheet">


    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/app.min.css"> -->
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Layerslider -->
    <link rel="stylesheet" href="assets/css/layerslider.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="assets/css/slick.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

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
<!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Class Details</h1>
                <p class="breadcumb-text">Montessori Is A Nurturing And Holistic Approach To Learning</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="index.html">Home</a></li>
                        <li>Class Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!--==============================
  Class Details  
    ==============================-->
    <section class="space py-5">
    <div class="container">

        <!-- TOP CARD -->
        <div class="row align-items-center bg-light rounded-4 p-4 shadow-sm">

            <!-- IMAGE -->
            <div class="col-lg-5 mb-4 mb-lg-0 text-center">
                <img 
                    src="<?php echo htmlspecialchars($row['course_image']); ?>" 
                    alt="class image" 
                    class="img-fluid rounded-4"
                    style="max-height:300px; object-fit:cover;"
                >
            </div>

            <!-- CONTENT -->
            <div class="col-lg-7">
               <div class="grade-pill mb-2">
                🎓 Grade <?php echo htmlspecialchars($row['grade']); ?>
            </div>

                <h2 class="fw-bold mt-1">
                    <?php echo htmlspecialchars($row['title']); ?>
                </h2>

                <h3 class="text-danger fw-bold my-3">
                    $<?php echo number_format($row['price'], 2); ?>
                    <small class="text-muted fs-6">/ month</small>
                </h3>

                <p class="text-muted">
                    <?php echo substr(strip_tags($row['description']), 0, 150); ?>...
                </p>

                <a 
                    href="enroll.php?id=<?php echo $row['id']; ?>" 
                    class="vs-btn mt-3"
                >
                    Start Registration
                </a>
            </div>
        </div>

        <!-- OVERVIEW -->
        <div class="mt-5">
            <h2>Course Overview</h2>
            <div class="title-divider1 mb-3"></div>
            <p>
                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
            </p>
        </div>

    </div>
    </section>

          
            <div class="row">
                <div class="col-md-6 mt-4">
                    <div class="img-box7 mb-0">
                        <div class="mega-hover"><img src="assets/img/class/cls-d-1-2.jpg" alt="class"></div>
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="img-box7">
                        <div class="mega-hover"><img src="assets/img/class/cls-d-1-3.jpg" alt="class"></div>
                    </div>
                </div>
            </div>
            
            <h2 class="pt-3">What We Provide</h2>
            <div class="title-divider1"></div>
            <svg class="svg-hidden">
                <clipPath id="service-clip1" clipPathUnits="objectBoundingBox">
                    <path
                        d="M0.379,0.037 C0.459,-0.006,0.558,-0.006,0.638,0.037 L0.879,0.167 C0.959,0.21,1,0.289,1,0.375 V0.635 C1,0.721,0.959,0.8,0.879,0.843 L0.638,0.973 C0.558,1,0.459,1,0.379,0.973 L0.138,0.843 C0.058,0.8,0.008,0.721,0.008,0.635 V0.375 C0.008,0.289,0.058,0.21,0.138,0.167 L0.379,0.037">
                    </path>
                </clipPath>
            </svg>
            <div class="row vs-carousel mb-3 pb-1" data-slide-show="3" data-md-slide-show="2">
                <div class="col-md-6 col-lg-4">
                    <div class="service-style2">
                        <div class="service-icon">
                            <div class="service-shape1"></div>
                            <div class="service-shape2"></div>
                            <div class="service-shape3"></div>
                            <img src="assets/img/icon/sr-2-1.svg" alt="icon">
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><a class="text-inherit" href="class-details.html">Learning &amp;
                                    Fun</a></h3>
                            <p class="service-text">Our goal is to carefully educate and develop children in a fun way.
                                We strive learning process into a bright.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style2">
                        <div class="service-icon">
                            <div class="service-shape1"></div>
                            <div class="service-shape2"></div>
                            <div class="service-shape3"></div>
                            <img src="assets/img/icon/sr-2-2.svg" alt="icon">
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><a class="text-inherit" href="class-details.html">Healthy
                                    Meals</a></h3>
                            <p class="service-text">Our goal is to carefully educate and develop children in a fun way.
                                We strive learning process into a bright.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style2">
                        <div class="service-icon">
                            <div class="service-shape1"></div>
                            <div class="service-shape2"></div>
                            <div class="service-shape3"></div>
                            <img src="assets/img/icon/sr-2-3.svg" alt="icon">
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><a class="text-inherit" href="class-details.html">Children
                                    Safety</a></h3>
                            <p class="service-text">Our goal is to carefully educate and develop children in a fun way.
                                We strive learning process into a bright.</p>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </section>
    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>
    
    <!--********************************
			Code End  Here 
	******************************** -->

    <!--==============================
        All Js File
    ============================== -->
    <!-- Jquery -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Slick Slider -->
    <script src="assets/js/slick.min.js"></script>
    <!-- <script src="assets/js/app.min.js"></script> -->

    <!-- jquery ui -->
    <script src="assets/js/jquery-ui.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Isotope Filter -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>


</body>

</html>