<?php session_start(); ?>

<script>
  const teacherName = "<?php echo $_SESSION['teacher_name'] ?? 'Teacher'; ?>";
</script>
  <style>
    :root {
      --primary: #1e3c72;
      --accent: #2a5298;
    }

    .dashboard-header {
      margin-bottom: 2rem;
    }
    .greeting {
      font-size: 1.8rem;
      font-weight: 700;
      color: #1e3c72;
      margin: 0;
    }

    .stat-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      height: 100%;
      padding: 1.5rem;
      border: none;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .stat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }
    .stat-icon {
      font-size: 2.2rem;
      margin-bottom: 1rem;
      opacity: 0.9;
    }
    .stat-number {
      font-size: 25px;
      font-weight: 700;
      margin: 0 0 0.3rem 0;
      line-height: 1;
    }
    .stat-label {
      font-size: 16px;
      color: #555;
      font-weight: 500;
    }
    .trend {
      font-size: 0.95rem;
      margin-top: 0.5rem;
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #1e3c72;
      margin-bottom: 1rem;
      padding-left: 0.5rem;
      border-left: 4px solid var(--accent);
    }

    .activity-list .list-group-item {
      border: none;
      padding: 1rem 1.25rem;
      margin-bottom: 8px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .loading-spinner {
      width: 1.4rem;
      height: 1.4rem;
      border: 3px solid rgba(30,60,114,0.15);
      border-top-color: #1e3c72;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
  </style>

  <div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="greeting" id="greeting">Dashboard Overview</h1>
    <button id="refresh-btn" class="btn btn-outline-primary btn-sm px-4">
      <span id="refresh-text">Refresh</span>
      <span id="refresh-spinner" class="loading-spinner d-none ms-2"></span>
    </button>
  </div>

  <div class="row g-4 mb-5">
    <!-- My Students -->
    <div class="col-md-3 col-6">
      <div class="stat-card text-center">
        <div>
        <div class="stat-icon text-primary"><i class="bi bi-people-fill"></i></div>
        <p class="stat-number text-primary" id="my-students">0</p>
        <p class="stat-label">My Students</p>
        </div>
        <small class="trend text-success" id="students-trend"></small>
      </div>
    </div>

    <!-- Pending Assignments -->
    <div class="col-md-3 col-6">
      <div class="stat-card text-center">
        <div>
        <div class="stat-icon text-warning"><i class="bi bi-clipboard-check-fill"></i></div>
        <p class="stat-number text-warning" id="pending-assignments">0</p>
        <p class="stat-label">Pending Assignments</p>
        </div>
        <small class="trend text-muted" id="pending-trend"></small>
      </div>
    </div>

    <!-- Today's Classes -->
    <div class="col-md-3 col-6">
      <div class="stat-card text-center">
        <div>
        <div class="stat-icon text-info"><i class="bi bi-calendar-event-fill"></i></div>
        <p class="stat-number text-info" id="today-classes">0</p>
        <p class="stat-label">Today's Classes</p>
        </div>
        <small class="trend text-info" id="classes-trend"></small>
      </div>
    </div>

    <!-- Avg Score -->
    <div class="col-md-3 col-6">
      <div class="stat-card text-center">
        <div>
        <div class="stat-icon text-success"><i class="bi bi-graph-up-arrow"></i></div>
        <p class="stat-number text-success" id="avg-score">—</p>
        <p class="stat-label">Active Students</p>
        </div>
        <small class="trend text-success" id="score-trend"></small>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- My Subjects -->
    <div class="col-lg-6">
      <h5 class="section-title">My Subjects</h5>
      <div class="card" style="border-radius:16px; box-shadow:0 6px 20px rgba(0,0,0,0.08);">
        <div class="card-body p-4" id="at-risk-students">
          <div class="text-center py-5"><span class="loading-spinner"></span></div>
        </div>
      </div>
    </div>

 
  <!-- My Recent Activity -->
  <div class="col-lg-6">
    <h5 class="section-title">My Recent Activity</h5>
    <div class="card" style="border-radius:16px; box-shadow:0 8px 25px rgba(0,0,0,0.08);">
      <div class="card-body p-4" id="recent-activity">
        <div class="text-center py-5"><span class="loading-spinner"></span></div>
      </div>
      <div class="card-footer bg-transparent border-0 text-center pb-3" id="activity-footer" style="display:none;">
        <button id="read-more-btn" class="btn btn-outline-primary btn-sm px-4 me-2">View All Activity</button>
        <button id="show-less-btn" class="btn btn-outline-secondary btn-sm px-4" style="display:none;">Show Less</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
function setGreeting() {
  const hour = new Date().getHours();
  let greetingText = "Hello 👋";

  if (hour >= 5 && hour < 12) {
    greetingText = "Good Morning ☀️";
  } else if (hour >= 12 && hour < 17) {
    greetingText = "Good Afternoon 🌤️";
  } else if (hour >= 17 && hour < 21) {
    greetingText = "Good Evening 🌇";
  } else {
    greetingText = "Good Night 🌙";
  }

  elements.greeting.text(`${greetingText}, ${teacherName} 👋`);
}
  const BASE_API = './api/';

  const API_ENDPOINTS = {
    greeting: BASE_API + 'teacher_greeting.php',
    myStudents: BASE_API + 'get_my_students_count.php',
    pendingAssignments: BASE_API + 'get_pending_assignments.php',
    todayClasses: BASE_API + 'get_today_classes.php',
    activeStudents: BASE_API + 'get_active_students.php',
    teacherSubjects: BASE_API + 'get_teacher_subjects.php',
    recentActivity: BASE_API + 'get_teacher_recent_activity.php'
  };

  const elements = {
    greeting: $('#greeting'),
    students: $('#my-students'), studentsTrend: $('#students-trend'),
    pending: $('#pending-assignments'), pendingTrend: $('#pending-trend'),
    classes: $('#today-classes'), classesTrend: $('#classes-trend'),
    score: $('#avg-score'), scoreTrend: $('#score-trend'),
    atRisk: $('#at-risk-students'),
    activity: $('#recent-activity'),
    footer: $('#activity-footer'),
    readMoreBtn: $('#read-more-btn'),
    showLessBtn: $('#show-less-btn'),
    refreshBtn: $('#refresh-btn'),
    refreshText: $('#refresh-text'),
    refreshSpinner: $('#refresh-spinner')
  };

  function showLoading(el) {
    el.html('<div class="text-center py-5"><span class="loading-spinner"></span></div>');
  }

  function handleError(el) {
    el.html('<div class="text-center py-5 text-danger small">Failed to load</div>');
  }

  async function fetchData(endpoint, element, successCallback) {
    showLoading(element);
    try {
      const res = await $.ajax({ url: endpoint, dataType: 'json', timeout: 10000 });
      if (res && res.success) {
        successCallback(res);
      } else {
        handleError(element);
      }
    } catch (e) {
      handleError(element);
    }
  }

  async function loadDashboard() {
    setGreeting();
    elements.refreshText.text('Refreshing...');
    elements.refreshSpinner.removeClass('d-none');

    try {
      await Promise.all([
        
        fetchData(API_ENDPOINTS.myStudents, elements.students, res => {
          elements.students.text(res.data.count || 0);
          elements.studentsTrend.html(res.data.trend || '');
        }),
        fetchData(API_ENDPOINTS.pendingAssignments, elements.pending, res => {
          elements.pending.text(res.data.count || 0);
          elements.pendingTrend.html(res.data.trend || 'No assignments');
        }),
        fetchData(API_ENDPOINTS.todayClasses, elements.classes, res => {
          elements.classes.text(res.data.count || 0);
          elements.classesTrend.html(res.data.next || 'No class today');
        }),
        fetchData(API_ENDPOINTS.activeStudents, elements.score, res => {
         elements.score.text(res.data.count || 0);
          elements.scoreTrend.html(res.data.trend || ' ');
        }),
      fetchData(API_ENDPOINTS.teacherSubjects, elements.atRisk, res => {
        let html = '';

        if (!res.data || res.data.length === 0) {
          html = `<div class="text-center py-5 text-muted">No subjects assigned</div>`;
        } else {
          html = '<div class="list-group activity-list">';
          res.data.forEach(s => {
           html += `<div class="list-group-item">
          ${s.subject_name}
        </div>`;
          });
          html += '</div>';
        }

        elements.atRisk.html(html);
        }),
        fetchData(API_ENDPOINTS.recentActivity, elements.activity, res => {
          let html = '<div class="list-group activity-list">';
          if (!res.data || res.data.length === 0) {
            html += '<div class="list-group-item text-muted text-center py-4">No recent activity</div>';
          } else {
            res.data.forEach(item => {
              html += `<div class="list-group-item">
                         <div class="d-flex justify-content-between">
                           <span>${item.description}</span>
                           <small class="text-muted">${item.time_ago}</small>
                         </div>
                       </div>`;
            });
          }
          html += '</div>';
          elements.activity.html(html);

          // Show footer only if there are activities
          if (res.data && res.data.length > 0) {
            elements.footer.show();
            elements.readMoreBtn.show();
            elements.showLessBtn.hide();
          }
        })
      ]);
    } finally {
      elements.refreshText.text('Refresh');
      elements.refreshSpinner.addClass('d-none');
    }
  }

  // View All Activity
  elements.readMoreBtn.on('click', function() {
    $(this).prop('disabled', true).html('Loading...');

    $.ajax({
      url: API_ENDPOINTS.recentActivity + '?limit=all',
      dataType: 'json',
      success: function(res) {
        if (res.success && res.data) {
          let html = '<div class="list-group activity-list">';
          res.data.forEach(item => {
            html += `<div class="list-group-item">
                       <div class="d-flex justify-content-between">
                         <span>${item.description}</span>
                         <small class="text-muted">${item.time_ago}</small>
                       </div>
                     </div>`;
          });
          html += '</div>';
          elements.activity.html(html);

          elements.readMoreBtn.hide();
          elements.showLessBtn.show();
        }
      },
      complete: function() {
        elements.readMoreBtn.prop('disabled', false).html('View All Activity');
      }
    });
  });

  // Show Less Button
  elements.showLessBtn.on('click', function() {
    loadDashboard();   // Reload default 3 activities
  });

  loadDashboard();
  elements.refreshBtn.on('click', loadDashboard);
});
</script>