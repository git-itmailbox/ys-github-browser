<div class="container">


    <div class="row">
        <div class="col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-0">
            <img src="<?= $user->avatar_url ?>" alt="<?= $user->name ?>" height="255" class="rounded-circle">

                <p class="text-center">
                    <button class="btn-primary btn-lg like  <?=($isLikedUser)?'hidden':''; ?>" data-loginid="<?= $user->id ?>">Like</button>
                </p>
                <p class="text-center">
                    <button class="btn-primary btn-lg unlike <?=(!$isLikedUser)?'hidden':''; ?> " data-loginid="<?= $user->id ?>">UnLike
                    </button>
                </p>
        </div>

        <div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1">
            <h2><?= $user->name ?></h2>
            <ul>
                <li><h3><?= $user->login ?></h3></li>
                <li>company: <?= $user->company ?></li>
                <li>blog: <a href="<?= $user->blog ?>"><?= $user->blog ?></a>

                </li>
                <li>followers: <?= $user->followers ?></li>
            </ul>
        </div>
    </div>

</div>
    
    