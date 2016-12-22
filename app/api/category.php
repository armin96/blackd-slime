<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get category

$app->get('/api/categories', function (Request $request, Response $respone) {
    $sql = "SELECT * FROM category";
    try {
        $db = new db();
        $db = $db->connect();
        $stem = $db->query($sql);
        $categories = $stem->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($categories);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

//Get single category

$app->get('/api/category/{id}', function (Request $request, Response $respone) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM category WHERE id=$id";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->query($sql);
        $category = $stem->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($category);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});


// add category

$app->post('/api/category/add', function (Request $request, Response $response) {

    $name = $request->getParam('name');

    $sql = "INSERT INTO category (name) VALUES (:name)";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->prepare($sql);
        $stem->bindParam(':name', $name);


        $stem->execute();
        $db = null;
        echo '{"notice":{"text": "category ADDED"}}';;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

});


// Update category

$app->put('/api/category/update/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $name = $request->getParam('name');

    $sql = "UPDATE category SET
        name       = :name
        WHERE id=$id";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->prepare($sql);
        $stem->bindParam(':name', $name);

        $stem->execute();
        $db = null;
        echo '{"notice":{"text": "category ' . $id . ' Updated"}}';;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

});



// Delete category

$app->delete('/api/category/delete/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "DELETE FROM category WHERE id=$id";
    try {
        //Get database object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stem = $db->prepare($sql);

        $stem->execute();
        $db = null;
        echo '{"notice":{"text": "category ' . $id . ' Deleted"}}';;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

