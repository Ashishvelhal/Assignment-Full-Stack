<?php
require_once __DIR__ . '/../lib/db.php';

$pdo = db_get_connection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        if ($categoryId > 0) {
            $stmt = $pdo->prepare('SELECT id, category_id, title, description, image_path, sort_order FROM slides WHERE category_id = ? ORDER BY sort_order, id');
            $stmt->execute([$categoryId]);
        } else {
            $stmt = $pdo->query('SELECT id, category_id, title, description, image_path, sort_order FROM slides ORDER BY category_id, sort_order, id');
        }
        json_response($stmt->fetchAll());
        break;

    case 'POST':
        $data = parse_json_body();
        $required = ['category_id', 'title', 'image_path'];
        foreach ($required as $r) {
            if (!isset($data[$r]) || $data[$r] === '') {
                json_response(['error' => "$r is required"], 400);
            }
        }
        $stmt = $pdo->prepare('INSERT INTO slides (category_id, title, description, image_path, sort_order) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            (int)$data['category_id'],
            $data['title'],
            $data['description'] ?? null,
            $data['image_path'],
            isset($data['sort_order']) ? (int)$data['sort_order'] : 0,
        ]);
        $id = (int)$pdo->lastInsertId();
        json_response(['id' => $id] + $data, 201);
        break;

    case 'PUT':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) json_response(['error' => 'id required'], 400);
        $data = parse_json_body();
        $fields = [];
        $params = [];
        foreach (['category_id','title','description','image_path','sort_order'] as $f) {
            if (array_key_exists($f, $data)) { $fields[] = "$f = ?"; $params[] = $data[$f]; }
        }
        if (!$fields) json_response(['error' => 'no fields to update'], 400);
        $params[] = $id;
        $stmt = $pdo->prepare('UPDATE slides SET ' . implode(', ', $fields) . ' WHERE id = ?');
        $stmt->execute($params);
        json_response(['updated' => true]);
        break;

    case 'DELETE':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) json_response(['error' => 'id required'], 400);
        $stmt = $pdo->prepare('DELETE FROM slides WHERE id = ?');
        $stmt->execute([$id]);
        json_response(['deleted' => true]);
        break;

    default:
        json_response(['error' => 'Method not allowed'], 405);
}
