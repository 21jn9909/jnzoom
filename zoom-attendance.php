    <?php
    mb_internal_encoding("UTF-8");
    function analyze_csv($csv_data, $class_time, $class_start_time, $class_end_time)
    {
        $rows = explode("\n", $csv_data);
        $header = str_getcsv($rows[0]);
        $data = array_map('str_getcsv', array_slice($rows, 1, -1));
        $new_header = array_merge($header, ['出席状況']);
        $new_data = [];
        foreach ($data as $row) {
            $start_time = DateTime::createFromFormat('Y/m/d H:i:s A', $row[2]);
            $end_time = DateTime::createFromFormat('Y/m/d H:i:s A', $row[3]);
            if (!$start_time || !$end_time) {
                continue;
            }
            $start_time = $start_time->format('H:i:s');
            $end_time = $end_time->format('H:i:s');

            $class_start_plus_10min = date('H:i:s', strtotime($class_start_time . ' +10 minutes'));
            $class_end_minus_10min = date('H:i:s', strtotime($class_end_time . ' -10 minutes'));
            $class_start_plus_100min = date('H:i:s', strtotime($class_start_time . ' +100 minutes'));
            $class_start_plus_90min = date('H:i:s', strtotime($class_start_time . ' +90 minutes'));

            if ($class_time = 12) {
                if ($start_time <= $class_start_plus_10min && $end_time >= $class_end_minus_10min) {
                    $row[] = '1コマ目 〇';
                    $row[] = '2コマ目 〇';
                } elseif ($start_time > $class_start_plus_10min && $start_time <= $class_start_plus_100min && $end_time >= $class_end_minus_10min) {
                    $row[] = '1コマ目 ×';
                    $row[] = '2コマ目 〇';
                } elseif ($start_time <= $class_start_plus_10min && $end_time >= $class_start_plus_90min && $end_time < $class_end_minus_10min) {
                    $row[] = '1コマ目 〇';
                    $row[] = '2コマ目 ×';
                } else {
                    $row[] = '1コマ目 ×';
                    $row[] = '2コマ目 ×';
                }
            }
            else {
                if ($start_time <= $class_start_plus_10min && $end_time >= $class_end_minus_10min) {
                    $row[] = '〇';
                } else {
                    $row[] = '×';
                }
            }

            $new_data[] = $row;
        }
        return [$new_header, $new_data];
    }

    // 以下の部分は変更せず、そのまま使用します。

    function generate_csv($header, $data)
    {
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $header);
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv_buffer = stream_get_contents($handle);
        fclose($handle);
        return $csv_buffer;
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csv_data = file_get_contents($_FILES['csv_file']['tmp_name']);
    $class_time = $_POST['class_time'];
    $class_start_time = $_POST['start_time_hour'] . ':' . $_POST['start_time_minute'] . ':00';
    $class_end_time = $_POST['end_time_hour'] . ':' . $_POST['end_time_minute'] . ':00';
    [$new_header, $new_data] = analyze_csv($csv_data, $class_time, $class_start_time, $class_end_time);
    $new_csv_data = generate_csv($new_header, $new_data);
    $filename = 'new_csv_file.csv';

    // 出力バッファリングをクリアする
    ob_clean();
    flush();

    // ダウンロードするファイル名を指定する
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // ファイルのMIMEタイプを指定する
    header('Content-Type: text/csv');

    // ファイルの内容を出力する
    echo mb_convert_encoding($new_csv_data, "SJIS", "UTF-8");

    // スクリプトの終了
    exit;
}

