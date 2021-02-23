<?php

use App\Controllers\CommentsController;

return [
    'GET /comments/topic' => CommentsController::class . '::getForTopic',
    'POST /comments' => CommentsController::class . '::add',
];