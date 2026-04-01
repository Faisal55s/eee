<?php
/**
 * ARMAX - Statistics API
 * Get platform statistics
 */

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn = getDBConnection();

if ($method !== 'GET') {
    sendError('Method not allowed', 405);
}

// Get general statistics
$stats = [];

// Server stats
$serverStats = $conn->query("SELECT 
    COUNT(*) as total_servers,
    SUM(CASE WHEN status = 'online' THEN 1 ELSE 0 END) as online_servers,
    SUM(current_players) as total_players,
    SUM(max_players) as max_capacity,
    AVG(rating) as average_rating
FROM servers");
$stats['servers'] = $serverStats->fetch_assoc();

// Server types distribution
$typeStats = $conn->query("SELECT 
    server_type,
    COUNT(*) as count
FROM servers
GROUP BY server_type");
$stats['server_types'] = $typeStats->fetch_all(MYSQLI_ASSOC);

// Mod stats
$modStats = $conn->query("SELECT 
    COUNT(*) as total_mods,
    SUM(CASE WHEN type = 'free' THEN 1 ELSE 0 END) as free_mods,
    SUM(CASE WHEN type = 'paid' THEN 1 ELSE 0 END) as paid_mods,
    SUM(downloads) as total_downloads
FROM mods");
$stats['mods'] = $modStats->fetch_assoc();

// Mod categories distribution
$modCategories = $conn->query("SELECT 
    category,
    COUNT(*) as count
FROM mods
GROUP BY category");
$stats['mod_categories'] = $modCategories->fetch_all(MYSQLI_ASSOC);

// Top rated servers
$topServers = $conn->query("SELECT id, name, rating, votes, current_players, server_type FROM servers WHERE status = 'online' ORDER BY rating DESC, votes DESC LIMIT 5");
$stats['top_servers'] = $topServers->fetch_all(MYSQLI_ASSOC);

// Most downloaded mods
$topMods = $conn->query("SELECT id, name, downloads, rating, category, type FROM mods ORDER BY downloads DESC LIMIT 5");
$stats['top_mods'] = $topMods->fetch_all(MYSQLI_ASSOC);

// Recent activity (last 7 days)
$recentServers = $conn->query("SELECT COUNT(*) as count FROM servers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
$stats['recent']['servers'] = $recentServers->fetch_assoc()['count'];

$recentMods = $conn->query("SELECT COUNT(*) as count FROM mods WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
$stats['recent']['mods'] = $recentMods->fetch_assoc()['count'];

sendResponse(['success' => true, 'data' => $stats]);

$conn->close();
?>
