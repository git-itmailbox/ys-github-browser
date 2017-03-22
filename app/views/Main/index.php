<div class="container">
    <div class="row">
        <div class="col-md-6 bg-success side">
            <h2><?= $repo->full_name ?></h2>
            <ul class="list-group">
                <li class="list-group-item">Description: <?= $repo->description ?></li>
                <li class="list-group-item">watchers: <?= $repo->watchers ?></li>
                <li class="list-group-item">forks: <?= $repo->forks ?></li>
                <li class="list-group-item">open issues: <?= $repo->open_issues ?></li>
                <li class="list-group-item">GitHub repo: <a href="<?= $repo->homepage ?>"><?= $repo->homepage ?></a>
                </li>
                <li class="list-group-item">GitHub repo: <a href="<?= $repo->html_url ?>"><?= $repo->html_url ?></a>
                </li>
                <li class="list-group-item">created at: <?= $repo->created_at ?></li>
            </ul>
        </div>
        <div class="col-md-4 bg-success  side contributors">
        <h2>Contributors</h2>


            <?php if (!empty($contributors)): ?>
                <?php foreach ($contributors as $contributor): ?>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <p>
                                <a class="" href="/user/<?= $contributor->login ?>"><?= $contributor->login ?></a>
                            </p>
                        </div>
                        <div class="col-md-1">
                            <?php if (isset($likedUsers[$contributor->id])): ?>
                                <button class="btn-primary unlike" data-loginid="<?= $contributor->id ?>">
                                    UnLike
                                </button>
                                <button class="btn-primary like hidden" data-loginid="<?= $contributor->id ?>">
                                    Like
                                </button>
                            <?php else: ?>
                                <button class="btn-primary like" data-loginid="<?= $contributor->id ?>">
                                    Like</button>
                                <button class="btn-primary unlike hidden" data-loginid="<?= $contributor->id ?>">
                                    UnLike
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>
