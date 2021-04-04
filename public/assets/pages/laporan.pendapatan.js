window.application = new Vue({
  el: '#app',
  data: {
    inputForm: {},
    tableData: [],
    userSession: '',
  },
  methods: {
    swalShowLoading: function() {
      Swal.fire({ allowEscapeKey: false, allowOutsideClick: false, showConfirmButton: false, onOpen: () => { Swal.showLoading() } })
    },
    swalHideLoading: function() {
      Swal.close()
    },
    getSession() {
      this.userSession = JSON.parse(localStorage.getItem('users'))
    },
    setDefaultForm: function() {
      window.location.href = '/laporan/transaksi'
    },
    postCariData: async function () {
      try {
        this.swalShowLoading()
        const makeRequest = await axios.get(`/api/revenue/${this.inputForm.date}`, { headers: { 'authorization': `Bearer ${this.userSession.access_token}` } })
        if (makeRequest.data.success) {
          this.tableData = makeRequest.data.message
          this.swalHideLoading()
          this.initDatatable(this.tableData)
        } else {
          Swal.fire({ title: 'Data tidak ditemukan', text: makeRequest.data.message, icon: 'error' })
        }
      } catch (err) {
        Swal.fire({ title: 'Data tidak ditemukan', text: err.message, icon: 'error' })
      }
    },
    initDatatable(data) {
      $('#datatable').DataTable().destroy()
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
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        data: data,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Semua']],
        columns: [
          { data: 'date' },
          { data: 'total_transaction' },
          { data: 'total_revenue',
            render: function (data) {
              return toRupiah(data)
            }
          }
        ],
        order: [[ 0, 'desc' ]]
      })
    }
  },
  mounted: async function () {
    await Promise.all([ this.getSession(), this.initDatatable(this.tableData) ])
  }
})