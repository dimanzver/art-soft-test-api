<?php

/** @var PDO $db */
require __DIR__ . '/bootstrap/bootstrap.php';
echo "Downloading texts\n";
$texts = [];
for($i = 0; $i < 10; $i++) {
    $content = file_get_contents('http://loripsum.net/api');
    $texts[] = preg_replace('/<\/?p>/', '', $content);
}
$names = ['Дмитрий', 'Сергей', 'Виктория', 'Андрей', 'Александра'];

echo "Saving data\n";
$connection = DB::getConnection();
$connection->beginTransaction();
try{
    // Для 30 воображаемых постов генерируем комментарии
    for($topicId = 1; $topicId <= 30; $topicId++) {
        $commentIds = [];
        for($i = 0; $i < 30; $i++) {
            $parentId = null;
            // Пусть каждый второй комментарий будет с родителем
            if(!empty($commentIds) && rand(0, 1) === 1) {
                $parentId = $commentIds[rand(0, count($commentIds) - 1)];
            }

            $body = $texts[rand(0, count($texts) - 1)];
            $authorName = $names[rand(0, count($names) - 1)];
            $connection->prepare('
                INSERT INTO comments (parent_id, topic_id, body, author_name)
                VALUES (:parentId, :topicId, :body, :authorName)
            ')->execute(compact('parentId', 'topicId', 'body', 'authorName'));
            $commentIds[] = $connection->lastInsertId();
        }
    }

    $connection->commit();
}catch (Exception $e) {
    $connection->rollBack();
    throw $e;
}