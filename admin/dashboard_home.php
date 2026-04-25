<!-- dashboard_home.php -->

<style>
  body {
    background: #f4f7fb;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
  }

  /* Header */

  .dashboard-header {
    background: white;
    padding: 18px 22px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
    flex-wrap: wrap;
    gap: 10px;
  }

  .dashboard-header h2 {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    font-size: 22px;
  }

  /* Cards */

  .card {
    border: none;
    border-radius: 18px;
    background: white;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .05);
    transition: .3s;
    position: relative;
    padding: 20px;
    overflow: hidden;
  }

  .card:hover {
    transform: translateY(-5px);
  }

  /* Gradient border */

  .card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 5px;
    border-radius: 18px 0 0 18px;
  }

  /* Colors */

  .card-blue::before {
    background: linear-gradient(180deg, #36d1dc, #5b86e5);
  }

  .card-green::before {
    background: linear-gradient(180deg, #11998e, #38ef7d);
  }

  .card-orange::before {
    background: linear-gradient(180deg, #f7971e, #ffd200);
  }

  .card-purple::before {
    background: linear-gradient(180deg, #834d9b, #d04ed6);
  }

  /* Card text */

  .card-title {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 8px;
  }

  .card-value {
    font-size: 26px;
    font-weight: 700;
    color: #111827;
  }

  /* Section */

  .section-card {
    border-radius: 18px;
    background: white;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
    padding: 20px;
    height: 100%;
  }

  .section-card h5 {
    font-weight: 600;
    margin-bottom: 15px;
  }

  /* Activity */

  .list-group-item {
    border: none;
    border-bottom: 1px solid #f1f1f1;
    font-size: 14px;
    padding: 12px 0;
  }

  /* Button */

  #refresh-btn {
    border-radius: 8px;
    padding: 6px 14px;
  }

  /* Spinner */

  .loading-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid #ddd;
    border-top: 2px solid #0d6efd;
    border-radius: 50%;
    animation: spin .6s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  /* Responsive */

  @media(max-width:992px) {

    .card-value {
      font-size: 22px;
    }

  }

  @media(max-width:768px) {

    .dashboard-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .dashboard-header h2 {
      font-size: 20px;
    }

    .card {
      padding: 16px;
    }

    .card-value {
      font-size: 20px;
    }

  }

  @media(max-width:480px) {

    .card-title {
      font-size: 13px;
    }

    .card-value {
      font-size: 18px;
    }

    .section-card {
      padding: 15px;
    }

  }

  @media(max-width:300px) {

    .card {
      padding: 12px;
    }

    .card-value {
      font-size: 16px;
    }

    .dashboard-header h2 {
      font-size: 18px;
    }

  }
</style>


<div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
  <h2>Dashboard Overview</h2>

  <button id="refresh-btn" class="btn btn-outline-secondary btn-sm">
    <span id="refresh-text">Refresh</span>
    <span id="refresh-spinner" class="loading-spinner d-none"></span>
  </button>
</div>


<!-- Top Cards -->
<div class="row g-4 mb-4">

  <div class="col-md-3">
    <div class="card card-blue">
      <div class="card-title">Total Teachers</div>
      <div class="card-value" id="total-teachers"><span class="loading-spinner"></span></div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card card-green">
      <div class="card-title">Total Students</div>
      <div class="card-value" id="total-students"><span class="loading-spinner"></span></div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card card-orange">
      <div class="card-title">Course Sales</div>
      <div class="card-value" id="course-sales"><span class="loading-spinner"></span></div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card card-purple">
      <div class="card-title">Online Teachers</div>
      <div class="card-value" id="online-teachers"><span class="loading-spinner"></span></div>
    </div>
  </div>

</div>


<!-- Bottom Section -->
<div class="row g-4">

  <div class="col-md-6">
    <div class="section-card">
      <h5 class="mb-3">Teacher Login Status</h5>
      <div id="login-status"><span class="loading-spinner"></span></div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="section-card">
      <h5 class="mb-3">Recent Activity</h5>
      <div id="recent-activity">
        <div class="text-center py-3"><span class="loading-spinner"></span></div>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function() {
    const API_ENDPOINTS = {
      teachers: '../api/Get_teacher_count.php',
      students: '../api/Get_student_count.php',
      sales: '../api/Get_cource_sell.php',
      online: '../api/online_teachers.php',
      logins: '../api/teacher_logins.php',
      activity: '../api/recent_activity.php'
    };

    const elements = {
      teachers: $('#total-teachers'),
      students: $('#total-students'),
      sales: $('#course-sales'),
      online: $('#online-teachers'),
      logins: $('#login-status'),
      activity: $('#recent-activity'),
      refreshBtn: $('#refresh-btn'),
      refreshText: $('#refresh-text'),
      refreshSpinner: $('#refresh-spinner')
    };

    function formatNumber(num) {
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatCurrency(amount) {
      return '₹' + formatNumber(amount);
    }

    function showLoading(element) {
      element.html('<span class="loading-spinner"></span>');
    }

    function handleError(element, error) {
      console.error('API Error:', error);
      element.html('<span class="text-danger">Failed to load</span>');
    }

    async function fetchData(endpoint, element, formatter = null) {
      showLoading(element);
      try {
        const response = await $.ajax({
          url: endpoint,
          dataType: 'json',
          timeout: 5000
        });

        if (response && response.success) {
          element.html(formatter ? formatter(response.data) : response.data);
        } else {
          handleError(element, response?.message || 'Invalid response');
        }
      } catch (error) {
        handleError(element, error);
      }
    }

    async function fetchRecentActivity() {
      showLoading(elements.activity);
      try {
        const response = await $.ajax({
          url: API_ENDPOINTS.activity,
          dataType: 'json',
          timeout: 5000
        });

        if (response && response.success) {
          let html = '';
          if (response.data.length > 0) {
            html = '<div class="list-group">';
            response.data.forEach(item => {
              html += `
              <div class="list-group-item">
                <div class="d-flex justify-content-between">
                  <span>${item.description}</span>
                  <small class="text-muted">${new Date(item.timestamp).toLocaleString()}</small>
                </div>
              </div>
            `;
            });
            html += '</div>';
          } else {
            html = '<p class="text-muted">No recent activity</p>';
          }
          elements.activity.html(html);
        } else {
          handleError(elements.activity, response?.message || 'Invalid response');
        }
      } catch (error) {
        handleError(elements.activity, error);
      }
    }

    async function loadDashboard() {
      elements.refreshText.text('Refreshing...');
      elements.refreshSpinner.removeClass('d-none');

      try {
        await Promise.all([
          fetchData(API_ENDPOINTS.teachers, elements.teachers, formatNumber),
          fetchData(API_ENDPOINTS.students, elements.students, formatNumber),
          fetchData(API_ENDPOINTS.sales, elements.sales, data => {
            return `${formatNumber(data.count)} (${formatCurrency(data.revenue)})`;
          }),
          fetchData(API_ENDPOINTS.online, elements.online, formatNumber),
          fetchData(API_ENDPOINTS.logins, elements.logins, data => {
            return `On Time: <strong>${formatNumber(data.on_time)}</strong> | 
                  Late: <strong>${formatNumber(data.late)}</strong>`;
          }),
          fetchRecentActivity()
        ]);
      } finally {
        elements.refreshText.text('Refresh');
        elements.refreshSpinner.addClass('d-none');
      }
    }

    // Initial load
    loadDashboard();

    // Refresh on click
    elements.refreshBtn.on('click', loadDashboard);
  });
</script>