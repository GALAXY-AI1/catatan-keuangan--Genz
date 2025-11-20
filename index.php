<?php
// index.php (tampilan + include CSS/JS)
?><!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Catatan Keuangan — GenZ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <header class="top">
      <h1 class="pulse">
        🐾 Catatan Keuangan GenZ
        <span class="animals">🐶🐱🦊🐼</span>
      </h1>
      <p class="subtitle">Aplikasi Catatan Keuangan untuk Siswa SMKN 1 Kras</p>
      <a href="logout.php">Logout</a>
    </header>

    <section class="card add">
      <h2>Tambah / Edit Transaksi</h2>
      <form id="formTx">
        <input type="hidden" name="id" id="tx_id">
        <div class="row">
          <label>Tanggal
            <input type="date" name="t_date" id="t_date" required>
          </label>
          <label>Waktu
            <input type="time" name="t_time" id="t_time">
          </label>
        </div>
        <label>Judul
          <input type="text" name="title" id="title" placeholder="Contoh: Jualan pulsa / Makan siang" required>
        </label>
        <div class="row">
          <label>Tipe
            <select name="type" id="type">
              <option value="income">Pemasukan</option>
              <option value="expense">Pengeluaran</option>
            </select>
          </label>
          <label>Kategori
            <input type="text" name="category" id="category" placeholder="Contoh: Food, Salary">
          </label>
          <label>Jumlah (Rp)
            <input type="number" step="0.01" name="amount" id="amount" required>
          </label>
        </div>
        <label>Catatan
          <textarea name="note" id="note" rows="2" placeholder="opsional..."></textarea>
        </label>
        <div class="actions">
          <button type="submit" class="btn primary">Simpan</button>
          <button type="button" id="btnReset" class="btn">Reset</button>
          <button type="button" id="btnExport" class="btn ghost">Export CSV</button>
        </div>
      </form>
    </section>

    <section class="card summary">
      <div class="balance-box">
        <div>
          <strong id="totalIncome">Rp 0</strong>
          <div class="muted">Total Pemasukan</div>
        </div>
        <div>
          <strong id="totalExpense">Rp 0</strong>
          <div class="muted">Total Pengeluaran</div>
        </div>
        <div class="highlight">
          <strong id="balance">Rp 0</strong>
          <div class="muted">Saldo</div>
        </div>
      </div>
    </section>

    <section class="card list">
      <h2>Riwayat Transaksi</h2>
      <div class="table-wrap">
        <table id="txTable">
          <thead>
            <tr>
              <th>Tanggal</th><th>Waktu</th><th>Judul</th><th>Kategori</th><th>Tipe</th><th>Jumlah</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- diisi JS -->
          </tbody>
        </table>
      </div>
    </section>
    <footer class="footer">Dibuat oleh Adam dan Shintia support by ChatGPT </footer>
  </main>

  <script src="script.js"></script>
</body>
</html>
