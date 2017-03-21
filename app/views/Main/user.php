<div class="container">



    <div class="row">
        <div class="col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-0">
            <img src="<?=$user->avatar_url ?>" alt="<?= $user->name ?>" height="255" class="rounded-circle">
            <p class="text-center"><button>Like</button></p>
        </div>

        <div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1">
            <h2><?= $user->name ?></h2>
            <ul>
                <li><?= $user->login ?></li>
                <li>company: <?= $user->company ?></li>
                <li>blog: <?= $user->blog ?></li>
                <li>followers: <?= $user->followers ?></li>
            </ul>
        </div>
    </div>
    
</div>
    
    