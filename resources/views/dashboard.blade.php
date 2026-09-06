@include('components.user.header')

<main class="content">

    <!-- WELCOME -->
    <section class="welcome">
        <div class="row align-items-end g-3">
            <div class="col-md-8">
                <span class="welcome-kicker">
                    <i class="fa-solid fa-sparkles"></i>
                    Library Overview
                    <span class="ms-1 d-inline-flex align-items-center gap-1 text-success" style="font-size:8px;">
                        <span class="rounded-circle bg-success d-inline-block" style="width:5px;height:5px;"></span>
                        LIVE
                    </span>
                </span>
                <h1>Good morning, Ranjeet 👋</h1>
                <p>Here’s what’s happening in your study library today.</p>
            </div>

            <div class="col-md-4 text-md-end">
                <span class="date-pill">
                    <i class="fa-regular fa-calendar"></i>
                    Sunday, 06 September 2026
                </span>
            </div>
        </div>
    </section>

    <!-- KPIs -->
    <section class="mb-4">
        <div class="row g-3">

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
                        <span class="trend up">+8.4%</span>
                    </div>
                    <div class="kpi-label">Total Students</div>
                    <div class="kpi-value">250</div>
                    <div class="kpi-meta">18 new this month</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon green"><i class="fa-solid fa-user-check"></i></div>
                        <span class="trend up">+5.2%</span>
                    </div>
                    <div class="kpi-label">Present Today</div>
                    <div class="kpi-value">180</div>
                    <div class="kpi-meta">72% attendance rate</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon purple"><i class="fa-solid fa-chair"></i></div>
                        <span class="trend up">82%</span>
                    </div>
                    <div class="kpi-label">Seats Occupied</div>
                    <div class="kpi-value">210/250</div>
                    <div class="kpi-meta">40 seats available</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon orange"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                        <span class="trend up">+12.6%</span>
                    </div>
                    <div class="kpi-label">This Month Revenue</div>
                    <div class="kpi-value">₹42.5K</div>
                    <div class="kpi-meta">₹6.8K pending</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon pink"><i class="fa-solid fa-clock"></i></div>
                        <span class="trend down">12</span>
                    </div>
                    <div class="kpi-label">Expiring Soon</div>
                    <div class="kpi-value">12</div>
                    <div class="kpi-meta">Next 7 days</div>
                </div>
            </div>

        </div>
    </section>

    <!-- CHART + SEAT -->
    <section class="mb-4">
        <div class="row g-3">

            <div class="col-xl-8 visual-chart">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Attendance Overview</div>
                            <div class="panel-sub">Daily attendance for the current week</div>
                        </div>
                        <a href="#" class="panel-action">View Report <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>

                    <div class="chart-wrap">
                        <div class="chart-summary">
                            <div>
                                <div class="chart-value">1,146</div>
                                <div class="chart-note">Total check-ins this week</div>
                            </div>
                            <span class="badge rounded-pill text-bg-light">Last 7 Days</span>
                        </div>

                        <div class="bar-chart">
                            <div class="bar-col">
                                <div class="bar" style="height:52%;animation-delay:.03s"></div>
                                <div class="bar secondary" style="height:39%;animation-delay:.06s"></div>
                                <span class="bar-label">Mon</span>
                            </div>
                            <div class="bar-col">
                                <div class="bar" style="height:66%;animation-delay:.10s"></div>
                                <div class="bar secondary" style="height:45%;animation-delay:.13s"></div>
                                <span class="bar-label">Tue</span>
                            </div>
                            <div class="bar-col">
                                <div class="bar" style="height:74%;animation-delay:.16s"></div>
                                <div class="bar secondary" style="height:57%;animation-delay:.19s"></div>
                                <span class="bar-label">Wed</span>
                            </div>
                            <div class="bar-col">
                                <div class="bar" style="height:69%;animation-delay:.22s"></div>
                                <div class="bar secondary" style="height:49%;animation-delay:.25s"></div>
                                <span class="bar-label">Thu</span>
                            </div>
                            <div class="bar-col">
                                <div class="bar" style="height:86%;animation-delay:.28s"></div>
                                <div class="bar secondary" style="height:63%;animation-delay:.31s"></div>
                                <span class="bar-label">Fri</span>
                            </div>
                            <div class="bar-col">
                                <div class="bar" style="height:80%;animation-delay:.34s"></div>
                                <div class="bar secondary" style="height:58%;animation-delay:.37s"></div>
                                <span class="bar-label">Sat</span>
                            </div>
                            <div class="bar-col">
                                <div class="bar" style="height:92%;animation-delay:.40s"></div>
                                <div class="bar secondary" style="height:68%;animation-delay:.43s"></div>
                                <span class="bar-label">Sun</span>
                            </div>
                        </div>

                        <div class="chart-legend">
                            <span><span class="legend-dot legend-blue"></span>Check-in</span>
                            <span><span class="legend-dot legend-purple"></span>Check-out</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 visual-seat">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Live Seat Occupancy</div>
                            <div class="panel-sub">Current seating status</div>
                        </div>
                        <a href="#" class="panel-action">Manage</a>
                    </div>

                    <div class="seat-map">
                        <div class="seat-summary">
                            <div class="seat-stat">
                                <small>Occupied</small>
                                <strong>210</strong>
                            </div>
                            <div class="seat-stat">
                                <small>Available</small>
                                <strong>40</strong>
                            </div>
                            <div class="seat-stat">
                                <small>Reserved</small>
                                <strong>8</strong>
                            </div>
                        </div>

                        <div class="seat-grid">
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>01</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>02</div>
                            <div class="seat available"><i class="fa-solid fa-check"></i>03</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>04</div>
                            <div class="seat reserved"><i class="fa-solid fa-lock"></i>05</div>

                            <div class="seat occupied"><i class="fa-solid fa-user"></i>06</div>
                            <div class="seat available"><i class="fa-solid fa-check"></i>07</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>08</div>
                            <div class="seat available"><i class="fa-solid fa-check"></i>09</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>10</div>

                            <div class="seat occupied"><i class="fa-solid fa-user"></i>11</div>
                            <div class="seat reserved"><i class="fa-solid fa-lock"></i>12</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>13</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>14</div>
                            <div class="seat available"><i class="fa-solid fa-check"></i>15</div>

                            <div class="seat available"><i class="fa-solid fa-check"></i>16</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>17</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>18</div>
                            <div class="seat available"><i class="fa-solid fa-check"></i>19</div>
                            <div class="seat occupied"><i class="fa-solid fa-user"></i>20</div>
                        </div>

                        <div class="seat-legend">
                            <span><span class="legend-dot" style="background:#2fcf96"></span>Available</span>
                            <span><span class="legend-dot" style="background:#27abff"></span>Occupied</span>
                            <span><span class="legend-dot" style="background:#967aff"></span>Reserved</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- STUDENTS + ACTIVITY + PERFORMANCE -->
    <section class="mb-4">
        <div class="row g-3">

            <div class="col-xl-8">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Recent Students</div>
                            <div class="panel-sub">Latest admissions and membership activity</div>
                        </div>
                        <a href="#" class="panel-action">View All</a>
                    </div>

                    <div class="table-wrap">
                        <table class="table student-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Plan</th>
                                    <th>Seat</th>
                                    <th>Attendance</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="student">
                                            <div class="student-avatar">AS</div>
                                            <div>
                                                <div class="student-name">Aarav Sharma</div>
                                                <div class="student-id">STU-1024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Monthly</td>
                                    <td>A-12</td>
                                    <td>96%</td>
                                    <td><span class="status present"><i class="fa-solid fa-circle"></i>Active</span>
                                    </td>
                                    <td>05 Sep</td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="student">
                                            <div class="student-avatar">PN</div>
                                            <div>
                                                <div class="student-name">Priya Nair</div>
                                                <div class="student-id">STU-1023</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>3 Months</td>
                                    <td>B-08</td>
                                    <td>91%</td>
                                    <td><span class="status present"><i class="fa-solid fa-circle"></i>Active</span>
                                    </td>
                                    <td>04 Sep</td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="student">
                                            <div class="student-avatar">RK</div>
                                            <div>
                                                <div class="student-name">Rahul Kumar</div>
                                                <div class="student-id">STU-1022</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Monthly</td>
                                    <td>C-15</td>
                                    <td>84%</td>
                                    <td><span class="status pending"><i class="fa-solid fa-circle"></i>Fee
                                            Due</span></td>
                                    <td>03 Sep</td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="student">
                                            <div class="student-avatar">SM</div>
                                            <div>
                                                <div class="student-name">Sneha Mishra</div>
                                                <div class="student-id">STU-1021</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>6 Months</td>
                                    <td>A-04</td>
                                    <td>97%</td>
                                    <td><span class="status present"><i class="fa-solid fa-circle"></i>Active</span>
                                    </td>
                                    <td>02 Sep</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Recent Activity</div>
                            <div class="panel-sub">Latest updates from your library</div>
                        </div>
                        <a href="#" class="panel-action">All</a>
                    </div>

                    <div class="activity-list">
                        <div class="activity">
                            <div class="activity-icon green"><i class="fa-solid fa-user-plus"></i></div>
                            <div class="activity-text">
                                <strong>Aarav Sharma</strong> was added as a new student.
                                <span class="activity-time">12 minutes ago</span>
                            </div>
                        </div>

                        <div class="activity">
                            <div class="activity-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                            <div class="activity-text">
                                Payment of <strong>₹999</strong> received from Priya Nair.
                                <span class="activity-time">34 minutes ago</span>
                            </div>
                        </div>

                        <div class="activity">
                            <div class="activity-icon purple"><i class="fa-solid fa-chair"></i></div>
                            <div class="activity-text">
                                Seat <strong>B-14</strong> was marked available.
                                <span class="activity-time">1 hour ago</span>
                            </div>
                        </div>

                        <div class="activity">
                            <div class="activity-icon orange"><i class="fa-solid fa-bell"></i></div>
                            <div class="activity-text">
                                <strong>12 memberships</strong> are expiring this week.
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- PERFORMANCE + QUICK ACTION -->
    <section class="mb-4">
        <div class="row g-3">

            <div class="col-lg-4">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Library Performance</div>
                            <div class="panel-sub">Current plan utilization</div>
                        </div>
                    </div>

                    <div class="mini-progress">
                        <div class="progress-row">
                            <div class="progress-head">
                                <span>Student Capacity</span>
                                <span>83%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width:83%"></div>
                            </div>
                        </div>

                        <div class="progress-row">
                            <div class="progress-head">
                                <span>Seat Utilization</span>
                                <span>82%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar purple" style="width:82%"></div>
                            </div>
                        </div>

                        <div class="progress-row">
                            <div class="progress-head">
                                <span>Monthly Collection</span>
                                <span>91%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar green" style="width:91%"></div>
                            </div>
                        </div>

                        <div class="progress-row mb-0">
                            <div class="progress-head">
                                <span>Attendance Goal</span>
                                <span>88%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width:88%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Quick Actions</div>
                            <div class="panel-sub">Common library operations</div>
                        </div>
                    </div>

                    <div class="quick-grid">
                        <a href="#" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-user-plus"></i></div>
                            <div class="quick-title">Add Student</div>
                            <div class="quick-sub">Create new student profile</div>
                        </a>

                        <a href="#" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-user-check"></i></div>
                            <div class="quick-title">Mark Attendance</div>
                            <div class="quick-sub">Check-in students quickly</div>
                        </a>

                        <a href="#" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-chair"></i></div>
                            <div class="quick-title">Assign Seat</div>
                            <div class="quick-sub">Manage seat allocation</div>
                        </a>

                        <a href="#" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                            <div class="quick-title">Collect Fee</div>
                            <div class="quick-sub">Record a payment</div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="upgrade">
                    <span class="upgrade-badge"><i class="fa-solid fa-crown me-1"></i> GROW WITH LMSP</span>
                    <h3>Run your study library like a modern business.</h3>
                    <p>
                        Unlock advanced analytics, automated reminders, additional staff accounts
                        and higher student capacity with your next LMSP plan.
                    </p>
                    <a href="#" class="btn btn-light mt-2">
                        View Plans <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>
    @include('components.user.footer')