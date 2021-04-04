$.fn.dataTable.ext.errMode = 'none'

window.application = new Vue({
  el: '#app',
  data: {
    inputForm: {},
    transactionData: {
      totalVehichle: { in: 0, out: 0 }
    },
    userSession: ''
  },
  methods: {
    swalShowLoading: function() {
      Swal.fire({ allowEscapeKey: false, allowOutsideClick: false, showConfirmButton: false, onOpen: () => { Swal.showLoading() } })
    },
    getFormatNumber(num) {
      if (num >= 1000000000) return (num / 1000000000).toFixed(1).replace(/\.0$/, '') + 'M'
      if (num >= 1000000) return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'JT'
      if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K'
      return num
    },
    getSession() {
      this.userSession = JSON.parse(localStorage.getItem('users'))
    },
    saveSession(data) {
      localStorage.setItem('users', JSON.stringify(data))
    },
    deleteTransaction: function (id) {
      Swal.fire({ title: 'Apakah Anda yakin ingin melanjutkan ?', showCancelButton: true, confirmButtonText: 'Lanjutkan', cancelButtonText: 'Batalkan' }).then(async (result) => {
        if (result.isConfirmed) {
          await this.swalShowLoading()
          const makeRequest = await axios.get(`/api/transaction/delete/${id}`, { headers: { 'authorization': `Bearer ${this.userSession.access_token}` } })
          if (makeRequest.data.success) {
            Swal.fire({ title: 'Data berhasil dihapus', icon: 'success', timer: 1500 }).then(() => {
              window.location.reload()
            })
          } else {
            Swal.fire({ title: 'Data gagal dihapus', text: makeRequest.data.message, icon: 'error' })
          }
        }
      })
    },
    initDatatable() {
      $('#datatable').DataTable({
        processing: true,
        language: {
          'sEmptyTable': 'Tidak ada data yang tersedia pada tabel ini',
          'sProcessing': 'Sedang memproses...',
          'sLengthMenu': 'Tampilkan _MENU_ entri',
          'sZeroRecords': 'Tidak ditemukan data yang sesuai',
          'sInfo': 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
          'sInfoEmpty': 'Menampilkan 0 sampai 0 dari 0 entri',
          'sInfoFiltered': '(disaring dari _MAX_ entri keseluruhan)',
          'sInfoPostFix': '',
          'sSearch': 'Cari:',
          'sUrl': '',
          'oPaginate': {
            'sFirst': 'Pertama',
            'sPrevious': 'Sebelumnya',
            'sNext': 'Selanjutnya',
            'sLast': 'Terakhir'
          }
        },
        ajax: {
          url: '/api/transaction/today',
          headers: { 'authorization': `Bearer ${this.userSession.access_token}` },
          dataSrc: 'message',
        },
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Semua']],
        columns: [
          { data: 'id_transaction' },
          { data: 'plate_number' },
          { data: 'type_vehicle' },
          { data: 'time_in' },
          { data: 'time_out',
            render: function (data) {
              return data || '-'
            }
          },
          { data: 'date',
            render: function (data) {
              return `${moment(data).format(`YYYY-MM-DD`)}`
            }
          },
          { data: 'fullname' },
          { data: 'id_transaction', tableName: 'buttons',
            render: function (data) {
              return `
                <div class="pull-right">
                  <a href="/dashboard/cetak-data/${data}" class="btn btn-sm btn-primary btn-circle" title="Cetak Data" target="_BLANK"><i class="fas fa-print" aria-hidden="true"></i></a>
                  <button onclick="deleteTransaction('${data}')" type="button" class="btn btn-sm btn-danger btn-circle" title="Hapus Data"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
                </div>
              `
            }
          }
        ],
        order: [[ 3, 'desc' ]]
      })
    }
  },
  mounted: async function () {
    await this.getSession()
    const [transactionData] = await Promise.all([
      axios.get('/api/transaction/statistics', { headers: { 'authorization': `Bearer ${this.userSession.access_token}` } }),
      this.initDatatable()
    ])
    this.transactionData = {
      totalPendapatan: toRupiah(transactionData.data.message.totalPendapatan),
      totalTransaksi: this.getFormatNumber(transactionData.data.message.totalTransaksi),
      totalVehichle: {
        in: this.getFormatNumber(transactionData.data.message.totalVehichle.in),
        out: this.getFormatNumber(transactionData.data.message.totalVehichle.out),
      }
    }
  }
})

function deleteTransaction(id) {
  window.application.deleteTransaction(id)
}