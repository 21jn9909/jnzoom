<!DOCTYPE html>
<html lang="ja">

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>情報処理科 Zoom出席確認フォーム</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="container py-4">
  <h1 class="mb-4">Zoom出席確認フォーム</h1>

  <form action="zoom-attendance.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label>ファイル選択：</label>
      <input type="file" name="csv_file" class="form-control-file">
    </div>
    <div class="form-group">
      <label>授業形態：</label>
      <div class="form-check">
        <input type="radio" name="class_time" value="12" class="form-check-input" checked>
        <label class="form-check-label">2コマ連続授業（例：1,2限授業）</label>
      </div>
      <div class="form-check">
        <input type="radio" name="class_time" value="1" class="form-check-input">
        <label class="form-check-label">1コマ授業（例：1限のみの授業）</label>
      </div>
    </div>
      <div class="mb-3">
        <label for="start_time" class="form-label d-inline-block">授業時間：</label>
        <div class="d-flex align-items-center">
          <select class="form-control" id="start_time_hour" name="start_time_hour" style="width: 80px;">
            <?php
            for ($hour = 9; $hour <= 20; $hour++) {
              $hour_value = sprintf('%02d', $hour);
              echo "<option value=\"$hour_value\">$hour_value</option>";
            }
            ?>
          </select>
          <span class="ml-2">時</span>
          <select class="form-control ml-2" id="start_time_minute" name="start_time_minute" style="width: 80px;">
            <?php
            for ($minute = 0; $minute <= 55; $minute += 5) {
              $minute_value = sprintf('%02d', $minute);
              echo "<option value=\"$minute_value\">$minute_value</option>";
            }
            ?>
          </select>
          <span class="ml-2">分〜</span>
          <select class="form-control ml-2" id="end_time_hour" name="end_time_hour" style="width: 80px;">
            <?php
            for ($hour = 9; $hour <= 21; $hour++) {
              $hour_value = sprintf('%02d', $hour);
              echo "<option value=\"$hour_value\">$hour_value</option>";
            }
            ?>
          </select>
          <span class="ml-2">時</span>
          <select class="form-control ml-2" id="end_time_minute" name="end_time_minute" style="width: 80px;">
            <?php
            for ($minute = 0; $minute <= 55; $minute += 5) {
              $minute_value = sprintf('%02d', $minute);
              echo "<option value=\"$minute_value\">$minute_value</option>";
            }
            ?>
          </select>
          <span class="ml-2">分</span>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary">送信</button>
    </form>
  </div>
  <div class="container mt-4">
  <div class="card border-primary">
    <div class="card-header">使い方</div>
    <div class="card-body">
      <p>Zoom（Webサイトからのサインイン）後の左メニューからレポートを選択し、<br>
        使用状況レポートの「用途」から、Zoomのログcsvファイルを予めダウンロードし<br>
        このフォームからアップロードしてください。判定後、出欠席が入った状態のcsvファイルがダウンロードできます。</p>
      <p>例1：1,2限連続授業であれば、9:18入室、12:35分退出ならば、「1限 〇、2限 〇」<br>
        例2：1,2限連続授業であれば、9:25入室、11:50分退出ならば、「1限 〇、2限 ×」</p>
      <p>Zoomからcsvデータをダウンロードする際、何もチェックをつけずにそのままエクスポートボタンを押してcsvファイルを生成してください</p>
      <p>※複数回ログイン、ログアウトを繰り返した学生については対応していません。また、早退についても対応していません。</p>
      <p>※授業開始時間前、または開始後10分以内に参加の学生を出席、それ以降を欠席として取り扱います。<br>
        また、授業終了時間10分前から後に退出した学生を出席、それ以前に退出した学生は欠席として取り扱います。</p>
    </div>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
