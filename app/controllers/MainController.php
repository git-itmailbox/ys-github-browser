<?php
namespace app\controllers;
use \app\models\Main;

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

        $owner = (isset($this->route['owner']))? $this->route['owner']:'yiisoft';
        $repo = (isset($this->route['repo']))? $this->route['repo']:'yii';

        $ch = curl_init("https://api.github.com/repos/$owner/$repo");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,[GITHUB_TOKEN]);

        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER[ 'HTTP_USER_AGENT']);
        $resultRepo = curl_exec($ch);
        curl_close($ch);
        $resultRepo = json_decode($resultRepo);

        $contributorsUrl = $resultRepo->contributors_url;
        $ch = curl_init($contributorsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER[ 'HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HTTPHEADER,[GITHUB_TOKEN]);

        $resultContributors = curl_exec($ch);
        curl_close($ch);
        $resultContributors = json_decode($resultContributors);


        $this->set(['repo'=>$resultRepo, 'contributors'=>$resultContributors]);

    }

    public function userAction()
    {
        $user = (isset($this->route['user']))? $this->route['user']:'yiisoft';

        $ch = curl_init("https://api.github.com/users/$user");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,[GITHUB_TOKEN]);

        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER[ 'HTTP_USER_AGENT']);
        $result = curl_exec($ch);
        curl_close($ch);
        $userData = json_decode($result);

        if(!isset($userData->login)){
            $this->view = "error";
        }

        $this->set(['user'=>$userData, 'query'=>$user]);


//        var_dump($user); exit;

    }

    public function searchAction()
    {

        if($_SERVER['REQUEST_METHOD']=='POST')
        {
//            echo "test";
            $query = $_POST['query'];
            $ch = curl_init("https://api.github.com/search/repositories?q=$query&sort=stars&order=desc");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,[GITHUB_TOKEN]);

            curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER[ 'HTTP_USER_AGENT']);
            $result = curl_exec($ch);
            curl_close($ch);
            $results = json_decode($result);

            $this->set(['items'=>$results->items, ]);
        }
    }

}