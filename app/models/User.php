<?php

namespace app\models;


use vendor\core\base\Model;

class User extends Model
{

    public $id,
        $login_github_id,
        $isLike;

    function __construct($attributes = [])
    {
        parent::__construct();
        $this->table = 'user';
//        $this->id = (isset($attributes->id)) ? $attributes->id : "";
//        $this->userName = (isset($attributes->userName)) ? $attributes->userName : "";
//        $this->email = (isset($attributes->email)) ? $attributes->email : "";
//        $this->description = (isset($attributes->description)) ? $attributes->description : "";
//        $this->is_done = (isset($attributes->is_done)) ? $attributes->is_done : "";
//        $this->image = (isset($attributes->image)) ? $attributes->image : "";
    }

    function findAllLikedByIds(array $ids)
    {
        if(empty($ids)) return [];
        $ids_str = implode(",", $ids);
            $sql = "SELECT * from {$this->table} WHERE `login_github_id` in ($ids_str) AND `is_like`=1";
        return $this->pdo->query($sql);
    }

    function setLike($githubUserId, $isLike){

        $sql = "INSERT INTO {$this->table} (login_github_id, is_like) VALUES (:githubUserId, :isLike)
                ON DUPLICATE KEY UPDATE is_like = :isLike;";

        $bindParams = [
            ':githubUserId' => $githubUserId,
            ':isLike' => $isLike,
        ];
        $stmt = $this->pdo->queryBindParams($sql, $bindParams);
        return $stmt;

    }
}