<?php
/**
 * Created by PhpStorm.
 * User: jince
 * Date: 2018/9/10
 * Time: 14:18
 */

namespace App\Utils\Github\Api;


class Tree extends Api
{

    protected $owner;
    protected $repos;
    protected $treeSha;

    protected $url;
    protected $tree;

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     * @return Tree
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRepos()
    {
        return $this->repos;
    }

    /**
     * @param mixed $repos
     * @return Tree
     */
    public function setRepos($repos)
    {
        $this->repos = $repos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTreeSha()
    {
        return $this->treeSha;
    }

    /**
     * @param mixed $treeSha
     * @return Tree
     */
    public function setTreeSha($treeSha)
    {
        $this->treeSha = $treeSha;
        return $this;
    }

    /**
     * 获取一个 tree
     */
    public function getTree()
    {
        $this->url = sprintf("/repos/%s/%s/git/trees/%s", $this->getOwner(), $this->getRepos(), $this->getTreeSha());
        $data = json_decode($this->httpGet($this->url));
        return $data->tree;
    }
}