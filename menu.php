<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navigator">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
        <img src="img/icon.png" style="height: 48px; width: 48px; float: left; vertical-align: middle">
        <a href="#" class="navbar-brand">Park Smart</a>
    </div>
    <div class="collapse navbar-collapse" id="navigator">
        <ul class="nav navbar-nav navbar-right">
            <li id="accountLink"><a href="account.php">Account</a></li>
            <li id="reserveLink"><a href="reserve.php">Reserve</a></li>
            <li id="ticketLink"><a href="ticket.php">Ticket</a></li>
            <?php if(!isset($_COOKIE["userId"])) { ?>
                <li id="loginLink"><a href="login.php">Login</a></li>
            <?php } else { ?>
                <li id="loginLink"><a href="logout.php">Logout</a></li>
            <?php } ?>
            <li><a href="#"> </a></li>
            <li><a href="#"> </a></li> 
        </ul>
    </div>
</nav>