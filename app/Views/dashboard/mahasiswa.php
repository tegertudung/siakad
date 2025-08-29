<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Mahasiswa</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- Pesan Selamat Datang -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Selamat Datang, <?= esc(session()->get('ses_nama')); ?>!</h4>
                        <p>Selamat datang di situs SIAKAD (Sistem Informasi Akademik). Sistem ini berisi informasi yang perlu diketahui terkait proses akademik Anda.</p>
                    </div>
                </div>
            </div>

            <!-- GRAFIK NILAI -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Indeks Prestasi Semester</h3>
                        <div class="card-tools">
                            <a href="<?= base_url('khs'); ?>" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="ipsChart" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
</div>
<?= $this->endSection(); ?>

<?= $this->section('pageScripts'); ?>
<!-- Tambahkan ChartJS -->
<script src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/chart.js/Chart.min.js"></script>
<script>
$(function () {
    var ipsChartCanvas = $('#ipsChart').get(0).getContext('2d')

    var ipsChartData = {
      labels  : <?= $chart_labels; ?>,
      datasets: [
        {
          label               : 'IPS',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : <?= $chart_data; ?>,
          fill: true,
          backgroundColor: 'rgba(0, 123, 255, 0.2)'
        }
      ]
    }

    var ipsChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          },
          ticks: {
            beginAtZero: true,
            max: 4.0
          }
        }]
      }
    }

    // This will get the first dataset
    var ipsChartData = ipsChartData.datasets[0]

    var ipsChart = new Chart(ipsChartCanvas, {
      type: 'line',
      data: {
          labels: <?= $chart_labels; ?>,
          datasets: [ipsChartData]
      },
      options: ipsChartOptions
    })
})
</script>
<?= $this->endSection(); ?>