<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YS-Github-Browser</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav role="navigation" class="navbar navbar-default">

    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">

        <a href="/" class="navbar-brand">YS-Github-Browser</a>

    </div>

    <!-- Collection of nav links and other content for toggling -->

    <div id="navbarCollapse" class="collapse navbar-collapse">

        <ul class="nav navbar-nav">

            <li class=""><a href="/">Home</a></li>

            <li><a href="/user/git-itmailbox">My Page</a></li>


        </ul>
        <form action="/search" method="post" class="form-inline col-md-4 pull-right">
            <div class="input-group pull-right">
                <span class="glyphicon glyphicon-search input-group-addon" id="btnGroupSearch"></span>
                <input class="form-control" type="text" name="query" placeholder="Search" aria-describedby="btnGroupSearch">
            </div>
        </form>
    </div>

</nav>
<?=$content?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
</body>
</html>