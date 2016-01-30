<!doctype html>
<html>
    <head>
        <title>Smart Park | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php include 'menu.php' ?>
        
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center>
                        <h1>Login</h1>
                    </center>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal" action="#">  
                        <div class="form-group">
                            <label for="userId" class="col-sm-2 control-label">UserId</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="userId" id="userId" placeholder="Enter UserId">    
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="passWd" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" name="passWd" id="passWd" placeholder="Enter Password">    
                            </div>
                        </div>
                        
                        <center>
                            <button id="login" class="btn btn-default">Login</button>
                            <button id="new" class="btn btn-default">New</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
        
        <?php include 'links.php' ?>
        <script type="text/javascript">
            $('#login').click(function(e) {
                e.preventDefault();
                
                var url = "signin.php" + "?"
                                + "userId=" + $("#userId").val()
                                + "&passWd=" + $("#passWd").val();
                function success() { 
                    window.location = "account.php"; 
                }
                function fail() {
                    $("#login").attr("class", "btn btn-default");
                    $("#login").attr("html", "Login!");
                }
                toggleButton($(this), url, success, fail);
            });

            $('#new').click(function(e) {
                e.preventDefault();
                window.location = "new.php";
            });
            
            $("#loginLink").attr("class", "active");
        </script>
    </body>
</html>