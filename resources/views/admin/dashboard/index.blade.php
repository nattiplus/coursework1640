<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accusoft admin</title>
    <link href="{{URL::asset('css/custom_style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>

    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <a href="{{URL::to('/admin')}}">
                <h2><span class="lab la-accusoft"></span>
                    <span> Accusoft</span>
                </h2>
            </a>
        </div>

        <div class="sidebar-menu">
            <ul>
                @if (Auth::user()->can('admin.dashboard'))
                <li>
                    <!-- <a href="" class="active"> -->
                    <a href="{{URL::to('/admin/dashboard')}}" class="active">
                        <span class="las la-igloo"></span>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('exception.report'))
                <li>
                    <a href="{{ route('ideas.without.comments') }}">
                        <span class="las la-flag"></span>
                        <span>Exception Report</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('view.category'))
                <li>
                    <a href="{{URL::to('/admin/view-category')}}">
                        <span class="las la-list"></span>
                        <span>Category</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('view.submission'))
                <li>
                    <a href="{{URL::to('/admin/view-submission')}}">
                        <span class="lab la-envira"></span>
                        <span>Submission</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('idea.cencor'))
                <li>
                    <a href="{{URL::to('/admin/censor-ideas')}}" class="sub-btn">
                        <span class="las la-lightbulb"></span>
                        <span>Idea</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('view.department'))
                <li>
                    <a href="{{URL::to('/admin/view-department')}}">
                        <span class="las la-users"></span>
                        <span>Department</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('view.user'))
                <li>
                    <a href="{{URL::to('/admin/view-user')}}" class="sub-btn">
                        <span class="las la-user-circle"></span>
                        <span>Accounts</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('view.role'))
                <li>
                    <a href="{{URL::to('/admin/role')}}" class="sub-btn">
                        <span class="las la-key"></span>
                        <span>Roles</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Dashboard
            </h2>

            {{-- <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Seach here">
            </div> --}}

            <div class="user-wrapper">               
                <div>
                    <nav>
                        <ul>
                            <li>
                                <a href="#"><span class="las la-user"></span> {{ Auth::user()->name }}</a>
                                <ul>
                                    <li><a href="{{ route('home') }}">User HomePage</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            <i class="las la-undo-alt"></i>
                                             {{ __('Logout') }}
                                         </a>

                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                             @csrf
                                         </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
<!--                     <small>Super admin</small> -->
                </div>

            </div>
        </header>

        <main>
        <div class="recent-grid">
            <div class="projects">
                <div class="card">
                    <div class="card-header">
                        <h3>Number of ideas per Department</h3>

    <!--                     <button>See all <span class="las la-arrow-right"></span></button> -->
                    </div>
                    <!-- Bar Chart "Number of ideas per Department" -->
                    <div class="card-body"> <!-- style="width: 400px; height: 400px;margin: auto;" -->
                        <canvas id="myBarChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Percentage of ideas per Department</h3>

<!--                     <button>See all <span class="las la-arrow-right"></span></button> -->
                </div>
                <!-- Pie Chart "Percentage of ideas per Department" -->
                <div class="card-body"> <!-- style="width: 400px; height: 400px;margin: auto;" -->
                    <canvas id="myPieChart" width="400" height="400"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Number of contributors within each Department</h3>

<!--                     <button>See all <span class="las la-arrow-right"></span></button> -->
                </div>
                <!-- Bar Chart "Number of contributors within each Department" -->
                <div class="card-body"> <!-- style="width: 400px; height: 400px;margin: auto;" -->
                    <canvas id="myBarChartContributors" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        {{-- <div class="recent-grid">
            <div class="projects">

            </div>
        </div>
        
        <div class="recent-grid">
            <div class="projects">

            </div>
        </div> --}}

        </main>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Page level plugins -->
    {{-- <script src="{{URL::asset('vendor/chart.js/Chart.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <!-- Loader Animation -->
    <script type="text/javascript">
        window.addEventListener("load", function(){
            const loader = document.querySelector(".loader");
            loader.className += " hidden"; // class "loader hidden"
        });
    </script>
    
    <!-- CRUD Message Time Out -->
    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(function() {
                $("div.alert").remove();
            },3000);
        });
    </script>

    <script type="text/javascript">
        <?php
            $ideas = array();
            $departments = array();
            foreach($datas as $key => $data)
            {
                array_push($ideas, $data);
                array_push($departments, $key);
            }
        ?>

        var ctxbarNoI = document.getElementById('myBarChart').getContext('2d');
        var myBarChartNoI = new Chart(ctxbarNoI, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($departments); ?>,
            datasets: [{
                label: '# of Ideas',
                categoryPercentage: 1.0,
                barPercentage: 0.5,
                data: <?php echo json_encode($ideas); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            plugins: {
                tooltip:{
                    enabled:false
                }
            }
        }
    });

        var ctxpie = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctxpie, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($departments); ?>,
            datasets: [{
                data: <?php echo json_encode($ideas); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            scales:{

            },
            plugins:{
                tooltip:{
                    enabled:false
                },
                datalabels:{
                    formatter: (value, context) => {
                        // console.log(context.chart.data.datasets[0].data);
                        const datapoints = context.chart.data.datasets[0].data;
                        function totalSum(total, datapoints){
                            return total + datapoints;
                        }
                        const totalvalue = datapoints.reduce(totalSum, 0);
                        const percentageValue = (value/totalvalue * 100).toFixed(0);
                        return `${percentageValue}%`;
                    }
                }
            }
        }
    });

    <?php
        $departments_contributor = array();
        $contributors = array();
        foreach($datas_contributors as $key => $contributor)
        {
            array_push($departments_contributor, $key);
            array_push($contributors, $contributor);
        }
    ?>
    var ctxbarNoC = document.getElementById('myBarChartContributors').getContext('2d');
        var myBarChartNoC = new Chart(ctxbarNoC, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($departments_contributor); ?>,
            datasets: [{
                label: '# of Contributors',
                categoryPercentage: 1.0,
                barPercentage: 0.5,
                data: <?php echo json_encode($contributors); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctxlinechartIWC = document.getElementById('myLineChartIWC').getContext('2d');
    var myLineChartIWC = new Chart(ctxlinechartIWC, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Ideas Without a Comment',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctxlinechartAIAC = document.getElementById('myLineChartAIAC').getContext('2d');
    var myLineChartAIAC = new Chart(ctxlinechartAIAC, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Ideas Without a Comment',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>
</body>
</html>