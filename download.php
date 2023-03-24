<?php
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $file_path = sys_get_temp_dir() . '/' . $filename;

    if (file_exists($file_path)) {
        // ダウンロードするファイル名を指定する
        header('Content-Disposition: attachment; filename="new_csv_file.csv"');

        // ファイルのMIMEタイプを指定する
        header('Content-Type: text/csv');

        // ファイルの内容を出力する
        readfile($file_path);

        // 一時ファイルを削除
        unlink($file_path);
    } else {
        echo 'ファイルが見つかりませんでした。';
    }
} else {
    echo '無効なリクエストです。';
}
