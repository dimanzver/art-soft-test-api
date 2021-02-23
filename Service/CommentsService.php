<?php


namespace App\Service;


use DB;
use PDO;

class CommentsService
{

    /**
     * @param int $topicId
     * @return \stdClass[]
     */
    public static function getForTopic(int $topicId) {
        $sql = "SELECT * FROM comments WHERE topic_id=$topicId";
        $commentsQuery = DB::getConnection()
            ->query($sql);
        return $commentsQuery->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param int $id
     * @return \stdClass|null
     */
    public static function findOne(int $id) {
        $sql = "SELECT * FROM comments WHERE id=$id"; // Не боимся SQL Injection (int)
        return DB::getConnection()->query($sql)->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Составляем дерево комментариев
     *
     * @param array $comments
     * @return \stdClass[]
     */
    public static function getTree(array $comments) {
        // Используем соответствие id => comment, чтобы составить дерево за один цикл
        // Пользуемся тем, что объекты передаются по ссылке
        $commentsMap = [];
        foreach ($comments as $comment) {
            $comment->children = [];
            $commentsMap[$comment->id] = $comment;
        }

        $tree = [];
        foreach ($comments as $comment) {
            if(empty($comment->parent_id)) {
                $tree[] = $comment;
            }else{
                $commentsMap[$comment->parent_id]->children[] = $comment;
            }
        }

        return $tree;
    }

    /**
     * Сохраняем коммент и отдаём его
     *
     * @param array $comment
     * @return \stdClass|null
     */
    public static function add(array $comment) {
        DB::getConnection()->prepare('
                INSERT INTO comments (parent_id, topic_id, body, author_name)
                VALUES (:parent_id, :topic_id, :body, :author_name)
            ')->execute($comment);
        $id = DB::getConnection()->lastInsertId();
        return self::findOne($id);
    }

}