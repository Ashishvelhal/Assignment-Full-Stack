<?php
require_once __DIR__ . '/../lib/db.php';

$pdo = db_get_connection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $include_slides = isset($_GET['include_slides']) ? (bool)$_GET['include_slides'] : true;
        $stmt = $pdo->query('SELECT id, name, icon_path FROM categories ORDER BY id');
        $categories = $stmt->fetchAll();
        if ($include_slides) {
            $catIds = array_column($categories, 'id');
            if ($catIds) {
                $in = implode(',', array_fill(0, count($catIds), '?'));
                $s = $pdo->prepare("SELECT id, category_id, title, description, image_path, sort_order FROM slides WHERE category_id IN ($in) ORDER BY category_id, sort_order, id");
                $s->execute($catIds);
                $slides = $s->fetchAll();
                $byCat = [];
                foreach ($slides as $slide) {
                    $byCat[$slide['category_id']][] = $slide;
                }
                foreach ($categories as &$c) {
                    $c['slides'] = $byCat[$c['id']] ?? [];
                }
            }
        }
        json_response($categories);
        break;

    case 'POST':
        $data = parse_json_body();
        if (!isset($data['name']) || $data['name'] === '') {
            json_response(['error' => 'name is required'], 400);
        }
        $icon = $data['icon_path'] ?? null;
        $stmt = $pdo->prepare('INSERT INTO categories (name, icon_path) VALUES (?, ?)');
        $stmt->execute([$data['name'], $icon]);
        $id = (int)$pdo->lastInsertId();
        json_response(['id' => $id, 'name' => $data['name'], 'icon_path' => $icon], 201);
        break;

    case 'PUT':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) json_response(['error' => 'id required'], 400);
        $data = parse_json_body();
        $fields = [];
        $params = [];
        if (isset($data['name'])) { $fields[] = 'name = ?'; $params[] = $data['name']; }
        if (array_key_exists('icon_path', $data)) { $fields[] = 'icon_path = ?'; $params[] = $data['icon_path']; }
        if (!$fields) json_response(['error' => 'no fields to update'], 400);
        $params[] = $id;
        $stmt = $pdo->prepare('UPDATE categories SET ' . implode(', ', $fields) . ' WHERE id = ?');
        $stmt->execute($params);
        json_response(['updated' => true]);
        break;

    case 'DELETE':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) json_response(['error' => 'id required'], 400);
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        json_response(['deleted' => true]);
        break;

    default:
        json_response(['error' => 'Method not allowed'], 405);
}
