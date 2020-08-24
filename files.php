<?php

function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {

        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

        if (!is_dir($path)) {

            $results[] = $path;

        } else if (($value != "." && $value != "..")) {

            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

$files = getDirContents(__DIR__);

foreach($files as $key => $one) {
    if(strpos($one, '.git') !== false)
        unset($files[$key]);
}

header("Content-Type: text/html");
?>

<html>
<body>
    <pre><?php print_r($files); ?></pre>
</body>
</html>
