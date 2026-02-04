<!-- dashboard_home.php -->
<style>
  .dashboard-header h2 {
    font-weight: 600;
    color: #333;
  }

  .btn-outline-primary {
    border-color: #333;
    color: #333;
  }

  .btn-outline-primary:hover {
    background-color: #333;
    color: #fff;
  }

  .card {
    border: 1px solid #dee2e6;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    background-color: #f8f9fa !important;
    color: #212529;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .card:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }

  .card-title {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
  }

  .card-text {
    font-weight: bold;
  }

  .loading-spinner {
    display: inline-block;
    width: 1.2rem;
    height: 1.2rem;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-top: 2px solid #333;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
  }

  .d-none {
    display: none;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>

<div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Dashboard Overview</h2>
  <button id="refresh-btn" class="btn btn-sm btn-outline-primary">
    <span id="refresh-text">Refresh</span>
    <span id="refresh-spinner" class="loading-spinner d-none"></span>
  </button>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Total Teachers</h5>
        <p class="card-text fs-4" id="total-teachers"><span class="loading-spinner"></span></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Total Students</h5>
        <p class="card-text fs-4" id="total-students"><span class="loading-spinner"></span></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Course Sales</h5>
        <p class="card-text fs-4" id="course-sales"><span class="loading-spinner"></span></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Online Teachers</h5>
        <p class="card-text fs-4" id="online-teachers"><span class="loading-spinner"></span></p>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Teacher Login Status</h5>
        <p class="card-text fs-6" id="login-status"><span class="loading-spinner"></span></p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Recent Activity</h5>
        <div id="recent-activity" class="pt-2">
          <div class="text-center py-3"><span class="loading-spinner"></span></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  const API_ENDPOINTS = {
    teachers: '/api/Get_teacher_count.php',
    students: '/api/Get_student_count.php',
    sales: '/api/Get_cource_sell.php',
    online: '/api/online_teachers.php',
    logins: '/api/teacher_logins.php',
    activity: '/api/recent_activity.php'
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
