<div class="container">
    <div class="row">
        <div class="col-md-6 bg-info left-side">
            <h2><?= $repo->full_name ?></h2>
            <ul>
                <li>Description: <?= $repo->description ?></li>
                <li>watchers: <?= $repo->watchers ?></li>
                <li>forks: <?= $repo->forks ?></li>
                <li>open issues: <?= $repo->open_issues ?></li>
                <li>homepage: <?= $repo->homepage ?></li>
                <li>GitHub repo: <?= $repo->html_url ?></li>
                <li>created at: <?= $repo->created_at ?></li>
            </ul>
        </div>
        <div class="col-md-6 bg-success pre-scrollable right-side">
            <h2>Contributors</h2>

            <?php if (!empty($contributors)): ?>
                <?php foreach ($contributors as $contributor): ?>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <p>
                                <a href="/user/<?= $contributor->login ?>"><?= $contributor->login ?></a>
                            </p>
                        </div>
                        <div class="col-md-4"><button class="btn-primary">Like</button></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>