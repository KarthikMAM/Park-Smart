<!doctype html>
<html>
    <head>
        <title>Smart Park | New User</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php include 'menu.php' ?>
        
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><h3>Create New User</h3></center>
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
                        <div class="form-group">
                                <label for="balance" class="col-sm-2 control-label">Balance</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="balance" id="balance" placeholder="Enter Balance">    
                            </div>
                        </div>
                        
                        <center><button id="new" class="btn btn-default">Create Now!</button></center>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
        
        <?php include 'links.php'?>
        <script type="text/javascript">
            $('#new').click(function(e) {
                e.preventDefault();
                
                var userId = document.getElementById("userId").value;
                var passWd = document.getElementById("passWd").value;
                var balance = document.getElementById("balance").value;
                var url = "create.php" + "?"
                            + "userId=" + userId
                            + "&passWd=" + passWd
                            + "&balance=" + balance;
                function success() { window.location = "login.php"; }
                function fail() {
                    $("#new").attr("class", "btn btn-default");
                    $("#new").attr("html", "Create Now!");
                }
                toggleButton($(this), url, success, fail);
            });
            
            $("#loginLink").attr("class", "active");
        </script>
    </body>
</html>