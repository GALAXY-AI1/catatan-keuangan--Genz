// script.js
const api = (action, data = {}) => {
  const form = new FormData();
  form.append('action', action);
  for (const k in data) form.append(k, data[k]);
  return fetch('api.php', { method: 'POST', body: form })
    .then(async r => {
      const ctype = r.headers.get('content-type') || '';
      if (ctype.includes('application/json')) return r.json();
      // for CSV export will not reach here (handled by redirect)
      return r.text();
    });
};

const $ = sel => document.querySelector(sel);
const $$ = sel => document.querySelectorAll(sel);

function rupiah(x){
  if (x === null || x === undefined) return 'Rp 0';
  let n = Number(x);
  return 'Rp ' + n.toLocaleString('id-ID', {minimumFractionDigits:0, maximumFractionDigits:2});
}

async function loadList(){
  const res = await api('list');
  if (res.status !== 'ok') return alert('Gagal memuat data');
  const tbody = $('#txTable tbody');
  tbody.innerHTML = '';
  let income = 0, expense = 0;
  res.data.forEach(r => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${r.t_date}</td>
      <td>${r.t_time ?? ''}</td>
      <td>${escapeHtml(r.title)}</td>
      <td>${escapeHtml(r.category || '')}</td>
      <td><span class="tag ${r.type}">${r.type === 'income' ? 'Pemasukan' : 'Pengeluaran'}</span></td>
      <td>${rupiah(r.amount)}</td>
      <td>
        <button class="btn" data-edit="${r.id}">✏️</button>
        <button class="btn" data-del="${r.id}">🗑️</button>
      </td>
    `;
    tbody.appendChild(tr);
    if (r.type === 'income') income += parseFloat(r.amount);
    else expense += parseFloat(r.amount);
  });
  $('#totalIncome').innerText = rupiah(income);
  $('#totalExpense').innerText = rupiah(expense);
  $('#balance').innerText = rupiah(income - expense);

  // attach handlers
  $$('[data-edit]').forEach(b => b.onclick = e => editRow(e.target.dataset.edit, res.data));
  $$('[data-del]').forEach(b => b.onclick = e => delRow(e.target.dataset.del));
}

function escapeHtml(s){
  if (!s) return '';
  return s.replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
}

function editRow(id, data){
  const row = data.find(x => String(x.id) === String(id));
  if (!row) return;
  $('#tx_id').value = row.id;
  $('#t_date').value = row.t_date;
  $('#t_time').value = row.t_time || '';
  $('#title').value = row.title;
  $('#type').value = row.type;
  $('#category').value = row.category || '';
  $('#amount').value = row.amount;
  $('#note').value = row.note || '';
  window.scrollTo({top:0,behavior:'smooth'});
}

function delRow(id){
  if (!confirm('Hapus transaksi ini?')) return;
  api('delete', { id }).then(res => {
    if (res.status === 'ok') loadList();
    else alert('Gagal menghapus: ' + (res.msg || ''));
  });
}

document.getElementById('formTx').addEventListener('submit', async function(e){
  e.preventDefault();
  const id = $('#tx_id').value;
  const data = {
    t_date: $('#t_date').value,
    t_time: $('#t_time').value,
    title: $('#title').value,
    type: $('#type').value,
    category: $('#category').value,
    amount: $('#amount').value,
    note: $('#note').value
  };
  const action = id ? 'update' : 'add';
  if (id) data.id = id;
  const res = await api(action, data);
  if (res.status === 'ok') {
    $('#formTx').reset();
    $('#tx_id').value = '';
    loadList();
  } else {
    alert('Gagal menyimpan: ' + (res.msg || ''));
  }
});

$('#btnReset').addEventListener('click', ()=> {
  $('#formTx').reset(); $('#tx_id').value = '';
});

$('#btnExport').addEventListener('click', ()=> {
  // download CSV by navigating to api.php?action=export
  window.location = 'api.php?action=export';
});

// helper: set default date to today
document.addEventListener('DOMContentLoaded', ()=>{
  const d = new Date();
  const iso = d.toISOString().split('T')[0];
  $('#t_date').value = iso;
  loadList();
});
