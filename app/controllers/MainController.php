<?php
namespace app\controllers;

use app\models\Repo;
use \app\models\User;
use Kilte\Pagination\Pagination;

/**
 * Created by PhpStorm.
 * User: yura
 * Date: 02.03.17
 * Time: 1:22
 */
class MainController extends AppController
{
    public $layout = 'default';

    public function indexAction()
    {
//        $this->layout = 'main';
//        $this->view = 'test';
//        echo "Main Controller index action";
//        echo json_encode(['1'=>'index without layout']);
//        $model = new Main();
//        $posts = $model->findAll();
        $users = new User();
        $owner = (isset($this->route['owner'])) ? $this->route['owner'] : 'yiisoft';
        $repo = (isset($this->route['repo'])) ? $this->route['repo'] : 'yii';

        $resultRepo = self::sendCurlRequest(['url' => "https://api.github.com/repos/$owner/$repo"]);
        $contributors = self::sendCurlRequest(['url' => $resultRepo->contributors_url]);

        $contributors_ids = [];
        if (isset($contributors)) {
            foreach ($contributors as $contributor) {
                $contributors_ids[] = $contributor->id;
            }
        }
        $found = $users->findAllLikedByIds($contributors_ids);
        $likedUsers = [];
        foreach ($found as $user) {
            $likedUsers[$user->login_github_id] = $user;
        }
        $this->set(['repo' => $resultRepo, 'contributors' => $contributors, 'likedUsers' => $likedUsers]);
    }

    public function userAction()
    {
        $user = (isset($this->route['user'])) ? $this->route['user'] : 'yiisoft';
        $userData = self::sendCurlRequest(['url' => "https://api.github.com/users/$user"]);
        if (!isset($userData->login)) {
            $this->view = "error";
        }
        $model = new User();
        $isLikeddUser = $model->findOne($userData->id, 'login_github_id');
        $liked = (!empty($isLikeddUser) && $isLikeddUser->is_like == 1) ? true : false;
        $this->set(['user' => $userData, 'query' => $user, 'isLikedUser' => $liked]);
    }

    private function sendCurlRequest(array $opt)
    {
        $url = $opt['url'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [GITHUB_TOKEN]);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function searchAction()
    {
        $page = 1;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $query = $_POST['query'];
        } else {
            if (isset($this->route['query'])) {
                $query = $this->route['query'];
            } else {
                header("location: /");
                exit;
            }
            $page = (!isset($this->route['page'])) ?: $this->route['page'];
        }
        //Сколько найдено ? нужно для пагинации
        $url = "https://api.github.com/search/repositories?q=$query&per_page=1";
        $results = self::sendCurlRequest(['url' => $url]);
        //api of github get only first 1k items
        $total_count = ($results->total_count<1000)? $results->total_count :1000;
        $pagination = new Pagination($total_count, $page, 10 /* itemsperpage */, 3 /* $neighbours*/);
        $limit = $pagination->limit();

        $url = "https://api.github.com/search/repositories?q=$query&per_page=$limit&page=$page";
        $results = self::sendCurlRequest(['url' => $url]);
        $repoIds = [];

        if(isset($results->items)){
            foreach ($results->items as $item) {
                $repoIds[] = $item->id;
            }
        }
        $repos = new Repo();
        $found = $repos->findAllLikedByIds($repoIds);
        $likedRepos=[];

        foreach ($found as $repo) {
            $likedRepos[$repo->repo_github_id] = $repo;
        }

        $pages = $pagination->build();
        $this->set([
            'results' => $results,
            'pages' => $pages,
            'query' => $query,
            'q_page' => $page,
            'likedRepos' => $likedRepos,
        ]);
    }

    /**
     * ajax update user when clicking like/unlike
     */
    public function setulikeAction()
    {
        $this->layout = false;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User();
            $id = (int)$_POST['id'];
            $isLike = (int)$_POST['like'];
            if (is_int($id)) {
                $updated = $user->setLike($id, $isLike);
                echo json_encode([
                    'state' => $updated,
                ]);
            }
        }
    }

    /**
     * ajax update repo when clicking like/unlike
     */
    public function setrlikeAction()
    {
        $this->layout = false;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $repo = new Repo();
            $id = (int)$_POST['id'];
            $isLike = (int)$_POST['like'];
            if (is_int($id)) {
                $updated = $repo->setLike($id, $isLike);
                echo json_encode([
                    'state' => $updated,
                ]);
            }
        }
    }
}