<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= str_replace("index.php/", "../static/css/style.css", BASE_URL) ?>" />
        <title>Admin prijava</title>
    </head>
    <body>
        
        <div class="wrapper col-lg-12 col-md-12 col-sm-12">
            <div class="navbar-inner">
                 <div class="container">
                    <img src="<?= str_replace("index.php/", "../static/images/logo.png", BASE_URL) ?>" class="img-rounded" width="100%"/></center>
                 </div>
            </div>
            <br/><br/>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="glava">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                            <b><span class="pozdrav">Dobrodošel administrator</span></b>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <?php
                                            $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

                                            if ($client_cert == null) {
                                                die('err: Spremenljivka SSL_CLIENT_CERT ni nastavljena.');
                                            }
                                            
                                            $cert_data = openssl_x509_parse($client_cert);
                                            $commonname = (is_array($cert_data['subject']['CN']) ?
                                                            $cert_data['subject']['CN'][0] : $cert_data['subject']['CN']);
                                          
                                            if (isset($_SESSION["authorisation"]) || in_array($commonname, $authorized_users)) { 
                                                $_SESSION["authorisation"] = true;
                                                ?>
                                                <form role="form" action="<?= BASE_URL ?>" method="post">
                                                    <div class="form-group">
                                                        <label for="user">Uporabniško ime:</label>
                                                        <input type="text" class="form-control" id="username" name="uname" value="<?= $uname ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pwd">Geslo:</label>
                                                        <input type="password" class="form-control" id="pwd" name="password">
                                                    </div>
                                                    <button type="submit" class="btn btn-default">Potrdi</button>
                                                </form>
                                            <?php
                                            } else {
                                                echo "$commonname ni avtoriziran uporabnik in nima dostopa spletnega vmesnika za Administratorja.";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
