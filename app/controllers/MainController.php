<?php
namespace app\controllers;

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

//    public $layout = false;


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

        $resultRepo = self::sendCurlRequest(['url'=>"https://api.github.com/repos/$owner/$repo"]);
        $contributors = self::sendCurlRequest(['url'=>$resultRepo->contributors_url]);

        $contributors_ids=[];
        if(isset($contributors)){
            foreach ($contributors as $contributor) {
                   $contributors_ids[]=$contributor->id;
            }
        }
        $found = $users->findAllLikedByIds($contributors_ids);

        foreach ($found as $user) {
            $likedUsers[$user->login_github_id]=$user;
        }
//        var_dump($likedUsers[0]);
//        var_dump($contributors_ids);
        $this->set(['repo' => $resultRepo, 'contributors' => $contributors, 'likedUsers' => $likedUsers]);

    }

    public function userAction()
    {
        $user = (isset($this->route['user'])) ? $this->route['user'] : 'yiisoft';
        $userData = self::sendCurlRequest(['url'=>"https://api.github.com/users/$user"]);
        if (!isset($userData->login)) {
            $this->view = "error";
        }

        $this->set(['user' => $userData, 'query' => $user]);
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
        $page =1;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $query = $_POST['query'];
        } else {
            if (isset($this->route['query'])) {
                $query = $this->route['query'];
            } else {
                header("location: /");
                exit;
            }
            $page = (!isset($this->route['page']))?: $this->route['page'];
        }


        //Сколько найдено ? нужно для пагинации
        $url = "https://api.github.com/search/repositories?q=$query&per_page=1";
        $results = self::sendCurlRequest(['url'=>$url]);

        $pagination = new Pagination($results->total_count, $page, 10 /* itemsperpage */, 3 /* $neighbours*/);
        $limit = $pagination->limit();

        $url = "https://api.github.com/search/repositories?q=$query&per_page=$limit&page=$page";
        $results = self::sendCurlRequest(['url'=>$url]);

        $pages = $pagination->build();
        $this->set([
            'results' => $results,
            'pages'=> $pages,
            'query'=>$query,
            'q_page'=>$page,
        ]);
    }

}