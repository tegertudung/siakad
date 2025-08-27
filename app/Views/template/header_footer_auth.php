<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- csrf -->
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <!-- Font Awesome -->
    <script <?= csp_script_nonce() ?> src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3//plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->

    <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page register-page">


    <?= $this->renderSection('content-auth'); ?>
    <!--  -->


    <!-- jQuery -->

    <script <?= csp_script_nonce() ?> src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script <?= csp_script_nonce() ?> src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script <?= csp_script_nonce() ?> src="<?= base_url(); ?>/dokumen/AdminLTE3/dist/js/adminlte.min.js"></script>

</body>

</html>