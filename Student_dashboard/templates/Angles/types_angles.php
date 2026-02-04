<?php /* static page – angle types (clean, print-friendly) */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Angle Classification</title>
  <style>
    :root{
      --blue:#1e56a0;
      --blue-600:#18488a;
      --ink:#222;
      --muted:#666;
      --line:#e6e8ef;
      --bg:#f6f8fc;
      --card:#fff;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    html,body{background:var(--bg);color:var(--ink);font:15px/1.55 system-ui,-apple-system,Segoe UI,Roboto,Arial,"Noto Sans",sans-serif}
    .page{max-width:980px;margin:24px auto 40px;padding:0 16px}
    header{text-align:center;margin-bottom:10px}
    h1{font-weight:800;color:var(--blue-600);font-size:26px;margin:6px 0 4px}
    .intro{margin:8px auto 18px;color:var(--muted);font-size:14px;text-align:center}
    .intro p{margin:2px 0}

    /* card */
    .card{
      position:relative;background:var(--card);border-radius:16px;overflow:hidden;
      border:1px solid var(--line);box-shadow:0 6px 18px rgba(0,0,0,.06);
      margin:18px 0;
    }
    .card::before{content:"";position:absolute;inset:0 0 auto 0;height:14px;background:var(--blue)}
    .card-body{padding:22px}
    .title{font-weight:700;font-size:18px;margin:4px 0 10px;text-align:center}
    .diagram{
      width:100%;max-width:360px;height:220px; /* FIXED & STATIC */
      margin:8px auto 4px;border:1px solid var(--line);border-radius:12px;background:#fff;
      display:flex;align-items:center;justify-content:center;overflow:hidden;
    }
    .diagram img{max-width:100%;max-height:100%;object-fit:contain}

    /* grid for all cards */
    .grid{display:grid;grid-template-columns:1fr;gap:14px}
    .section-head{font-weight:800;text-align:center;margin:10px 0 4px;color:#333}

    @media (min-width:760px){
      .grid{grid-template-columns:1fr 1fr}
    }
    @media (min-width:1020px){
      .grid{grid-template-columns:1fr 1fr}
    }

    /* print */
    @media print{
      body{background:#fff}
      .page{max-width:none;margin:0;padding:0}
      .card{box-shadow:none;break-inside:avoid-page}
      .card::before{height:10px}
    }
  </style>
</head>
<body>
  <div class="page">
    <header>
      <h1>6.1 Classification of Angles</h1>
    </header>

    <div class="intro">
      <p>Angles are classified according to their sizes.</p>
      <p>A protractor is used to measure an angle.</p>
      <p>The angle is measured in degrees.</p>
    </div>

    <h2 class="section-head">Here are the types of Angles</h2>

    <section class="grid">
      <!-- Type 1 -->
      <article class="card">
        <div class="card-body">
          <div class="title">Type 1: Acute Angle (less than 90°)</div>
          <div class="diagram">
            <img src="https://creativetheka.in/Student_dashboard/templates/images/type1.png" alt="Acute Angle">
          </div>
        </div>
      </article>

      <!-- Type 2 -->
      <article class="card">
        <div class="card-body">
          <div class="title">Type 2: Right Angle (equal to 90°)</div>
          <div class="diagram">
            <img src="https://creativetheka.in/Student_dashboard/templates/images/type2.png" alt="Right Angle">
          </div>
        </div>
      </article>

      <!-- Type 3 -->
      <article class="card">
        <div class="card-body">
          <div class="title">Type 3: Obtuse Angle (between 90° and 180°)</div>
          <div class="diagram">
            <img src="https://creativetheka.in/Student_dashboard/templates/images/type3.png" alt="Obtuse Angle">
          </div>
        </div>
      </article>

      <!-- Type 4 -->
      <article class="card">
        <div class="card-body">
          <div class="title">Type 4: Straight Angle (equals 180°)</div>
          <div class="diagram">
            <img src="https://creativetheka.in/Student_dashboard/templates/images/type4.png" alt="Straight Angle">
          </div>
        </div>
      </article>

      <!-- Type 5 -->
      <article class="card" style="grid-column:1/-1">
        <div class="card-body">
          <div class="title">Type 5: Reflex Angle (remaining angle)</div>
          <div class="diagram" style="max-width:520px;height:260px">
            <img src="https://creativetheka.in/Student_dashboard/templates/images/type5.png" alt="Reflex Angle">
          </div>
        </div>
      </article>
    </section>
  </div>
</body>
</html>
