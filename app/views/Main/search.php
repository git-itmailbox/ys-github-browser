<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-10 col-md-offset-1"><h4>For search term "<?= $query ?>" found</h4></div>
            </div>
            <?php if (!empty($results->items)): ?>
                <?php foreach ($results->items as $item): ?>

                    <div class="rounded-container">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/repo/<?= $item->owner->login ?>/<?= $item->name ?>"><?= $item->name ?></a>
                                <p><?= $item->id ?></p>
                            </div>
                            <div class="col-md-7">
                                <a href="<?= $item->homepage ?>"><?= $item->homepage ?></a>

                            </div>
                            <div class="col-md-2">
                                <a href="/user/<?= $item->owner->login ?>"><?= $item->owner->login ?></a>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <?= $item->description ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                watchers: <?= $item->watchers ?>
                            </div>
                            <div class="col-md-4">
                                forks: <?= $item->forks ?>
                            </div>

                            <div class="col-md-4">
                                <button class="btn-primary likerepo  <?=(isset($likedRepos[$item->id]))? 'hidden' : '' ?>" data-repoid="<?= $item->id ?>">Like</button>
                                <button class="btn-primary unlikerepo  <?=(!isset($likedRepos[$item->id]))? 'hidden' : '' ?>" data-repoid="<?= $item->id ?>">unLike</button>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                <ul class="pagination pagination-sm">
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $page => $value): ?>
                            <li class=" <?= ($page == $q_page) ? "active" : ""; ?> "><a
                                        href="/search/<?= $query ?>/page=<?= $page ?>"><?= $page ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

        </div>

    </div>

    <?php if (!empty($results->message)): ?>

        <div class="row">


            <div class="col-md-6">
                <h3><?= $results->message ?> </h3>
                <p>Tried to get page: <?= $q_page ?> </p>
            </div>
        </div>
    <?php endif; ?>
