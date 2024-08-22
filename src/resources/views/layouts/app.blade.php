<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'My App') }} - @yield('title', 'Dashboard')</title>
    <link rel="icon" href="{{ asset('images/favicon2.png') }}" type="image/png">

    <!-- Main Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Leckerli+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Leckerli+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&family=Teko:wght@300..700&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSRF Token for secure requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    <!-- Sidebar Section -->
    <div class="sidebar">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><img class="logo-img"
                src="{{ asset('images/Smart_Cl.png') }}" alt=""></a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">Home</a>
            </li>

            <li class="nav-item">
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link d-flex align-items-center">
                    Masters
                    <i class="fa-solid fa-caret-down" style="margin-left: 0.5rem;"></i> <!-- Bootstrap icon for a down arrow -->
                </a>
                <ul class="collapse nav flex-column ms-5" id="submenu1" style="margin-left: 0.5rem">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('maintenances*') ? 'active' : '' }}"
                            href="{{ route('maintenances.index') }}">Maintenance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}"
                            href="{{ route('projects.index') }}">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}"
                            href="{{ route('customers.index') }}">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('sensors*') ? 'active' : '' }}"
                            href="{{ route('sensors.index') }}">Device</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('serviceteams*') ? 'active' : '' }}"
                            href="{{ route('serviceteams.index') }}">Teams</a>
                    </li>
                </ul>
            </li>


            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->is('maintenances*') ? 'active' : '' }}"
                    href="{{ route('maintenances.index') }}">Maintenance</a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}"
                    href="{{ route('projects.index') }}">Projects</a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}"
                    href="{{ route('customers.index') }}">Customers</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('alerts*') ? 'active' : '' }}"
                    href="{{ route('alerts.index') }}">Alerts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('sensor-data*') ? 'active' : '' }}"
                    href="{{ route('sensor-data.index') }}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}"
                    href="#">Settings</a>
            </li>


        </ul>
    </div>

    <!-- Header Section for Statistics -->
    <div class="header">
        <div class="stats">
            <div class="stat" id="kt_countup_projects">
                <span>{{ $projectCount }}</span> Projects
            </div>
            <div class="stat" id="kt_countup_devices">
                <span>{{ $sensorCount }}</span> Device
            </div>
            <div class="stat" id="kt_countup_reports">
                <span>{{ $reportCount }}</span> Reports
            </div>
            <div class="stat" id="kt_countup_alerts">
                <span>{{ $totalAlertsCount }}</span> Alerts
            </div>
            <div class="stat" id="kt_countup_active_alerts">
                <span>{{ $activeAlertsCount }}</span> Active
            </div>
            <div class="stat" id="kt_countup_inactive_alerts">
                <span>{{ $inactiveAlertsCount }}</span> Inactive
            </div>
            <div class="stat" id="kt_countup_device_api">
                <span id="device-api-count">{{ $deviceapicount }}</span> API Activity
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Logout Form -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-logout">Logout</button>
    </form>

    <!-- Alert Icon and Alerts Container -->
    <a href="#" id="alert-icon" class="alert-icon mx-5">
        <span id="alert-count" class="badge badge-pill badge-danger">0</span>
        <i class="fas fa-bell icon"></i>
    </a>
    <div id="alerts-container" style="display: none;">
        <div id="alerts-list" class="list-group"></div>
        <button id="show-more-alerts" class="btn btn-primary" style="display:none;">More</button>
    </div>

    <footer class="footer bg-light text-center text-lg-start mt-auto py-1">
        <div class="container">
            <span class="text-muted">© 2024 Orisys</span>
        </div>
    </footer>

    <!-- JavaScript for CountUp Animation and Alerts -->
    <script>
        $(document).ready(function() {
            let totalAlerts = 0;
            const latestMessageCount = 3; // Set dynamically as needed
            function initializeCountUp() {
                $('.stat span').each(function() {
                    $(this).prop('Counter', 0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 1000,
                        easing: 'swing',
                        step: function(now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
            }




            const channel = Echo.private(`user.1`);

            channel
                .subscribed(() => {
                    console.log('Subscribed to websocket channel');
                })
                .listen("AlertBroadcaster", (event) => {

                    let currentCount = parseInt($('#device-api-count').text());
                    currentCount += 1;
                    $('#device-api-count').text(currentCount);
                });;

            initializeCountUp();

            $('#alert-icon').click(function(e) {
                e.preventDefault();
                $('#alerts-container').toggle();
                if ($('#alerts-container').is(':visible')) {
                    fetchAlerts();
                }
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#alert-icon, #alerts-container').length) {
                    $('#alerts-container').hide();
                }
            });

            function checkMoreButtonVisibility() {
                const totalAlertsCount = $('#alerts-list .alert').length;
                const visibleAlertsCount = $('#alerts-list .alert.d-block').length;
                const hiddenAlertsCount = $('#alerts-list .alert.d-none').length;

                // Check if we are showing exactly the latest messages
                const showingLatestMessages = visibleAlertsCount === latestMessageCount && hiddenAlertsCount > 0;

                if (showingLatestMessages) {
                    // Show "More" button if there are hidden alerts or if we are showing the latest messages
                    $('#show-more-alerts').show();
                } else if (visibleAlertsCount < latestMessageCount) {
                    // Hide "More" button if all latest messages are closed
                    $('#show-more-alerts').hide();
                } else {
                    $('#show-more-alerts').hide();
                }
            }

            // Initialize
            checkMoreButtonVisibility();
            // Close individual alerts
            $(document).on('click', '.alert .close', function() {
                $(this).closest('.alert').fadeOut(function() {
                    $(this).remove();
                    checkMoreButtonVisibility(); // Check button visibility after an alert is closed
                });
            });

            function updateAlertCount() {
                totalAlerts = $('#alerts-list .alert').length;
                $('#alert-count').text(totalAlerts);
                checkMoreButtonVisibility();
            }


            function fetchAlerts() {
                $.ajax({
                    url: '{{ route('getAlerts') }}',
                    type: 'GET',
                    success: function(alerts) {
                        totalAlerts = alerts.length;
                        let alertsHtml = '';

                        alerts.forEach(function(alert, index) {
                            let alertClass = index < 3 ? 'd-block' : 'd-none';
                            alertsHtml += `<div class="alert alert-info alert-dismissible fade show ${alertClass}" role="alert">
                                <span class="alert-text">${alert}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
                        });

                        $('#alerts-list').html(alertsHtml);
                        updateAlertCount();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching alerts:', error);
                    }
                });
            }

            fetchAlerts();
            setInterval(fetchAlerts, 60000);

            $('#show-more-alerts').click(function() {
                $('#alerts-list .alert.d-none').removeClass('d-none').addClass('d-block');
                checkMoreButtonVisibility(); // Check button visibility after showing all alerts
            });



        });
    </script>

    @yield('scripts')

    <!-- External JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
