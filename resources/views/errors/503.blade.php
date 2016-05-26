<!DOCTYPE html>
<html>
    <head>
        <title>Maintenance Mode.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            p {
                display: block;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Maintenance Mode.</div>
                <p class="text-center" style="color: #207AA7; font-weight: 300;">We are sorry, please come back at unknown WIB. We're currently doing automatic data synchronization</p>
                <p class="text-center" style="color: #207AA7; font-weight: 300;">Progress 93%</p>

                <?php Log::info(Request::getClientIp()); ?>
            </div>
        </div>
    </body>
</html>
