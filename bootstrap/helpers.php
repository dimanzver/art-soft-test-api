<?php

function getBodyParams(){
    return json_decode(file_get_contents('php://input'), true);
}
