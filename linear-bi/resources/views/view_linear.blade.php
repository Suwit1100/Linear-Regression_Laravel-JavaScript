<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Linear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container text-center m-3">
            <div class="row">
                <form class="col-12" action="{{ route('view_linear_post') }}" method="get">
                    <input type="number" class="form-control my-1" placeholder="ความชื้น" name="x"
                        id="humidityInput">
                    <input type="number" class="form-control my-1" placeholder="อุณหถูมิ" name="y"
                        id="temperatureInput">
                    <button type="submit" class="btn btn-success form-control" id="addDataBtn">บันทึก </button>
                    <a href="{{ route('reset_data') }}" class="btn btn-danger mt-2 form-control">รีเซ็ทดาต้า</a>
                </form>
                <div class="col-12">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">รายการ</th>
                                <th scope="col">ความชื้น</th>
                                <th scope="col">อุณหถูมิ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataset as $key => $idataset)
                                <tr>
                                    <td scope="col">{{ $key + 1 }}</td>
                                    <td scope="col">{{ $idataset->x }}</td>
                                    <td scope="col">{{ $idataset->y }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div style="width: 700px; height: 700px;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            var dataset = @json($dataset);
            console.log(dataset);
            // const dataset = [{
            //         x: 85,
            //         y: 85
            //     },
            //     {
            //         x: 80,
            //         y: 90
            //     },
            //     {
            //         x: 83,
            //         y: 86
            //     },
            //     {
            //         x: 70,
            //         y: 96
            //     },
            //     {
            //         x: 68,
            //         y: 80
            //     },
            //     {
            //         x: 65,
            //         y: 70
            //     },
            //     {
            //         x: 64,
            //         y: 65
            //     },
            //     {
            //         x: 72,
            //         y: 95
            //     },
            //     {
            //         x: 69,
            //         y: 70
            //     },
            //     {
            //         x: 75,
            //         y: 80
            //     },
            //     {
            //         x: 75,
            //         y: 70
            //     },
            //     {
            //         x: 72,
            //         y: 90
            //     },
            //     {
            //         x: 81,
            //         y: 75
            //     },
            //     {
            //         x: 71,
            //         y: 91
            //     }
            // ];
            let sumx = 0;
            let sumy = 0;
            dataset.forEach((data) => {
                sumx += data.x;
            });

            dataset.forEach((data) => {
                sumy += data.y;
            });

            let meanx = 0;
            let meany = 0;

            meanx = sumx / dataset.length;
            meany = sumy / dataset.length;


            let num = 0;
            let denom = 0;

            for (let i = 0; i < dataset.length; i++) {
                obj = dataset[i];
                x = obj.x;
                y = obj.y;
                console.log(x, y);
                num += (x - meanx) * (y - meany);
                denom += (x - meanx) * (x - meanx);
            }

            let m = num / denom;
            let b = meany - m * meanx;

            let xmax = Math.max(...dataset.map((obj) => obj.x));

            let regression = [];
            for (let i = 0; i <= xmax; i++) {
                let yval = (i * m) + b;
                regression.push({
                    x: i,
                    y: yval
                });
            }

            console.log(sumx, sumy, meany, meanx, num, denom, m, b, xmax, regression);






            const ctx = document.getElementById('myChart').getContext('2d');

            const scatterChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'อุณหภูมิ',
                        data: dataset,
                        borderColor: 'green',
                        backgroundColor: 'green'
                    }, {
                        label: 'ความชื้น',
                        data: regression,
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                        type: 'line'
                    }]
                },
                options: {}
            });
        });
    </script>
</body>



</html>
