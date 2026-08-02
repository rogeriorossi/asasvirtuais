<?php
header('Content-Type: application/json; charset=utf-8');

// Configurações
$channelId = 'UCgjDOmLABCxefdqCWZtRY0A';
$cacheDir = __DIR__ . '/../cache';
$cacheFile = $cacheDir . '/videos.json';
$cacheTime = 3600; // 1 hora em segundos

// Garantir que a pasta de cache exista
if (!file_exists($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

// Verificar se existe um cache válido
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
    $cachedData = file_get_contents($cacheFile);
    if (!empty($cachedData)) {
        echo $cachedData;
        exit;
    }
}

// Função para buscar e processar o Feed RSS
function fetchYouTubeRSS($channelId) {
    $rssUrl = "https://www.youtube.com/feeds/videos.xml?channel_id=" . $channelId;
    
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AsasVirtuaisBot/1.0\r\n",
            "timeout" => 10
        ]
    ];
    $context = stream_context_create($opts);
    $xmlString = @file_get_contents($rssUrl, false, $context);
    
    if ($xmlString === false) {
        return false;
    }
    
    $xml = @simplexml_load_string($xmlString);
    if ($xml === false) {
        return false;
    }
    
    $videos = [];
    $namespaces = $xml->getNamespaces(true);
    
    foreach ($xml->entry as $entry) {
        $ytNs = $entry->children($namespaces['yt'] ?? 'http://www.youtube.com/xml/schemas/2015');
        $mediaNs = $entry->children($namespaces['media'] ?? 'http://search.yahoo.com/mrss/');
        
        $videoId = isset($ytNs->videoId) ? (string)$ytNs->videoId : '';
        if (empty($videoId)) {
            $idStr = (string)$entry->id;
            $videoId = str_replace('yt:video:', '', $idStr);
        }
        
        $title = (string)$entry->title;
        $publishedAt = (string)$entry->published;
        
        $thumbnail = '';
        $description = '';
        
        if (isset($mediaNs->group)) {
            $mediaGroup = $mediaNs->group;
            if (isset($mediaGroup->thumbnail)) {
                $attrs = $mediaGroup->thumbnail->attributes();
                $thumbnail = (string)$attrs['url'];
            }
            if (isset($mediaGroup->description)) {
                $description = (string)$mediaGroup->description;
            }
        }
        
        // Thumbnail fallback
        if (empty($thumbnail) && !empty($videoId)) {
            $thumbnail = "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
        }
        
        $videos[] = [
            'id' => $videoId,
            'title' => $title,
            'publishedAt' => $publishedAt,
            'thumbnail' => $thumbnail,
            'embedUrl' => "https://www.youtube.com/embed/{$videoId}",
            'youtubeUrl' => "https://www.youtube.com/watch?v={$videoId}",
            'description' => $description
        ];
    }
    
    return [
        'success' => true,
        'updatedAt' => date('Y-m-d H:i:s'),
        'total' => count($videos),
        'videos' => $videos
    ];
}

$response = fetchYouTubeRSS($channelId);

if ($response !== false && !empty($response['videos'])) {
    $jsonContent = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($cacheFile, $jsonContent);
    echo $jsonContent;
} else {
    // Se a busca falhou, tenta servir o cache antigo se existir
    if (file_exists($cacheFile)) {
        echo file_get_contents($cacheFile);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Não foi possível carregar os vídeos do canal no momento.'
        ]);
    }
}
