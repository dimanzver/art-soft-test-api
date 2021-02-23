<?php


namespace App\Controllers;


use App\Service\CommentsService;

class CommentsController
{

    public function getForTopic() {
        $topicId = intval($_GET['topicId']);
        $comments = CommentsService::getForTopic($topicId);
        $commentsTree = CommentsService::getTree($comments);
        header('Content-Type: application/json');
        return json_encode($commentsTree);
    }

    public function add() {
        $data = getBodyParams();
        $comment = CommentsService::add($data);
        return json_encode($comment);
    }

}