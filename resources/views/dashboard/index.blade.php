<x-admin-layout>
    @section('content')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <div class="row">
        @if(isset($data))
        <div class="col-lg-12">
            <div class="card card-danger">
                <div class="card-header">
                    Chart
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div class="pie-chart-container">
                            <canvas id="pie-chart"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        @else
        <div class="col-lg-12">
            <div class="card card-danger">
                <div class="card-header">
                    Chart
                </div>
                <div class="card-body">
                    Belum ada data (Data tersedia jika status Candidate inactive)
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-12">
            <!-- /.card -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Candidates List</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Total Votes</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidates as $candidate)
                            <tr>
                                <td>
                                    {{ $candidate->name }}
                                </td>
                                <td>
                                    {{ $candidate->total_votes }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($candidate->start)->translatedFormat('l, j F Y, g:i A ') }}

                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($candidate->end)->translatedFormat('l, j F Y, g:i A  ') }}
                                </td>
                                <td>
                                    @if($candidate->active_id == '1')
                                    <span class="bg-success">Active</span>
                                    @else
                                    <span class="bg-danger">Inactive</span>
                                    @endif
                                <td>
                                    <form action="/dashboard/edit/{{ $candidate->id }}" class="d-inline">
                                        <button class="badge bg-info border-0">EDIT</button>
                                    </form>
                                    <form action="/dashboard/delete/{{ $candidate->id }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="badge bg-danger border-0" onclick="return confirm('Delete candidate?')">DELETE</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <script>
        $(function() {
            //get the pie chart canvas
            var cData = JSON.parse(`<?php echo $chart_data; ?>`);
            var ctx = $("#pie-chart");

            //pie chart data
            var data = {
                labels: cData.label,
                datasets: [{
                    label: "Total Votes",
                    data: cData.data,
                    backgroundColor: [
                        "#DEB887",
                        "#A9A9A9",
                        "#DC143C",
                        "#F4A460",
                        "#2E8B57",
                        "#1D7A46",
                        "#CDA776",
                    ],
                    borderColor: [
                        "#CDA776",
                        "#989898",
                        "#CB252B",
                        "#E39371",
                        "#1D7A46",
                        "#F4A460",
                        "#CDA776",
                    ],
                    borderWidth: [1, 1, 1, 1, 1, 1, 1],

                }]
            };

            //options
            var options = {
                responsive: true,
                title: {
                    display: true,
                    position: "top",
                    text: "Total Votes",
                    fontSize: 18,
                    fontColor: "#111"
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        fontColor: "#333",
                        fontSize: 16
                    }
                }
            };

            //create Pie Chart class object
            var chart1 = new Chart(ctx, {
                type: "doughnut",
                data: data,
                options: options
            });

        });
    </script>
    @endsection
</x-admin-layout>