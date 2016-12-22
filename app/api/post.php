<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get posts

$app->get('/api/posts', function (Request $request, Response $respone) {
    $sql = "SELECT * FROM posts";
    try {
        $db = new db();
        $db = $db->connect();
        $stem = $db->query($sql);
        $posts = $stem->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($posts);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

//Get single post

$app->get('/api/post/{id}', function (Request $request, Response $respone) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM posts WHERE id=$id";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->query($sql);
        $posts = $stem->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($posts);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});


// add post

$app->post('/api/post/add', function (Request $request, Response $response) {

    $title = $request->getParam('title');
    $category_id = $request->getParam('category_id');
    $body = $request->getParam('body');
    $sql = "INSERT INTO posts (title,category_id,body) VALUES (:title,:category_id,:body)";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->prepare($sql);
        $stem->bindParam(':title', $title);
        $stem->bindParam(':category_id', $category_id);
        $stem->bindParam(':body', $body);

        $stem->execute();
        $db = null;
        echo '{"notice":{"text": "POST ADDED"}}';;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

});


// Update post

$app->put('/api/post/update/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $title = $request->getParam('title');
    $category_id = $request->getParam('category_id');
    $body = $request->getParam('body');
    $sql = "UPDATE posts SET
        title       = :title,
        category_id = :category_id,
        body        = :body
        WHERE id=$id";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->prepare($sql);
        $stem->bindParam(':title', $title);
        $stem->bindParam(':category_id', $category_id);
        $stem->bindParam(':body', $body);

        $stem->execute();
        $db = null;
        echo '{"notice":{"text": "POST' . $id . ' Updated"}}';;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

});



// Delete post

$app->delete('/api/post/delete/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "DELETE FROM posts WHERE id=$id";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->prepare($sql);

        $stem->execute();
        $db = null;
        echo '{"notice":{"text": "POST ' . $id . ' Deleted"}}';;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

});
