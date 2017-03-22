<?php

namespace app\models;


use vendor\core\base\Model;

class Repo extends Model
{

    public $id,
        $login_github_id,
        $isLike;

    function __construct($attributes = [])
    {
        parent::__construct();
        $this->table = 'repo';
    }

    function findAllLikedByIds(array $ids)
    {
        if(empty($ids)) return [];
        $ids_str = implode(",", $ids);
            $sql = "SELECT * from {$this->table} WHERE `repo_github_id` in ($ids_str) AND `is_like`=1";
        return $this->pdo->query($sql);
    }

    function setLike($githubRepoId, $isLike){

        $sql = "INSERT INTO {$this->table} (repo_github_id, is_like) VALUES (:githubRepoId, :isLike)
                ON DUPLICATE KEY UPDATE is_like = :isLike;";

        $bindParams = [
            ':githubRepoId' => $githubRepoId,
            ':isLike' => $isLike,
        ];
        $stmt = $this->pdo->queryBindParams($sql, $bindParams);
        return $stmt;

    }
}