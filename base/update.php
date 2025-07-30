<?php
// 本地版本号
$local_version = 'Brave-Lv1.5.5';

// 获取 GitHub 上最新版本信息
function fetch_latest_version_info($api_url)
{
    $options = [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'PHP'
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    // 检查请求是否成功
    if (!$response) {
        return ['error' => '无法获取最新版本信息'];
    }

    $data = json_decode($response, true);
    if (isset($data['error'])) {
        return ['error' => '解析 GitHub 数据失败'];
    }

    return [
        'latest_version' => isset($data['name']) ? $data['name'] : '',
        'body' => isset($data['body']) ? $data['body'] : '',
    ];
}

// 比较版本号
function compare_versions($version1, $version2)
{
    preg_match('/Lv(\d+\.\d+\.\d+)/', $version1, $matches1);
    preg_match('/Lv(\d+\.\d+\.\d+)/', $version2, $matches2);

    if (!$matches1 || !$matches2) {
        return -1;
    }

    $v1_parts = explode('.', $matches1[1]);
    $v2_parts = explode('.', $matches2[1]);

    for ($i = 0; $i < 3; $i++) {
        if ($v1_parts[$i] > $v2_parts[$i]) {
            return 1;
        } elseif ($v1_parts[$i] < $v2_parts[$i]) {
            return -1;
        }
    }

    return 0;
}

// 渲染更新信息
function render_update_info($latest_version, $local_version, $body)
{
    // 比较版本
    if (compare_versions($latest_version, $local_version) > 0) {
        echo "<p style='color: #00a0ff;'>发现新版本：<strong>{$latest_version}</strong></p>";
        echo "<p>{$body}</p>";
        echo '<a href="https://github.com/LMB520/Typecho-Brave/releases" target="_blank">
                <button><strong>立即更新</strong></button>
              </a>';
    } else {
        echo "<p>当前已是最新版本：<strong>{$local_version}</strong></p>";
        echo "<p>{$body}</p>";
        echo '<a href="https://blog.lmb.blue/archives/1196/" target="_blank">
                <button><strong>答疑解惑</strong></button>
              </a>';
    }

}

// API 请求地址
$api_url = 'https://api.github.com/repos/LMB520/Typecho-Brave/releases/latest';

// 获取最新版本信息
$version_info = fetch_latest_version_info($api_url);

// 错误处理
if (isset($version_info['error'])) {
    echo "<p style='color: red;'>错误：{$version_info['error']}</p>";
    exit;
}

// 渲染更新信息
render_update_info($version_info['latest_version'], $local_version, $version_info['body']);
?>
