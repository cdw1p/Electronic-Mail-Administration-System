$.fn.dataTable.ext.errMode = 'none'

window.application = new Vue({
  el: '#app',
  data: {
    inputForm: {},
    userSession: ''
  },
  methods: {
    swalShowLoading: function() {
      Swal.fire({ allowEscapeKey: false, allowOutsideClick: false, showConfirmButton: false, onOpen: () => { Swal.showLoading() } })
    },
    getSession() {
      this.userSession = JSON.parse(localStorage.getItem('users'))
    },
    saveSession(data) {
      localStorage.setItem('users', JSON.stringify(data))
    },
    deleteUsers: function (id) {
      Swal.fire({ title: 'Apakah Anda yakin ingin melanjutkan ?', showCancelButton: true, confirmButtonText: 'Lanjutkan', cancelButtonText: 'Batalkan' }).then(async (result) => {
        if (result.isConfirmed) {
          await this.swalShowLoading()
          const makeRequest = await axios.get(`/api/master/deleteUsers/${id}`, { headers: { 'authorization': `Bearer ${this.userSession.access_token}` } })
          if (makeRequest.data.success) {
            Swal.fire({ title: 'Akun berhasil dihapus', icon: 'success', timer: 1500 }).then(() => {
              window.location.reload()
            })
          } else {
            Swal.fire({ title: 'Akun gagal dihapus', text: makeRequest.data.message, icon: 'error' })
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
          url: '/api/master/getDataUsers',
          headers: { 'authorization': `Bearer ${this.userSession.access_token}` },
          dataSrc: 'message',
        },
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Semua']],
        columns: [
          { data: 'fullname' },
          { data: 'email' },
          { data: 'id_account', tableName: 'buttons',
            render: function (data) {
              return `
                <div class="pull-right">
                  <a href="/master/pengguna/ubah-data/${data}" class="btn btn-sm btn-primary btn-circle mr-1" title="Edit Data"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
                  <button onclick="deleteUsers('${data}')" type="button" class="btn btn-sm btn-danger btn-circle" title="Hapus Data"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
                </div>
              `
            }
          }
        ],
        order: [[ 0, 'desc' ]]
      })
    }
  },
  mounted: async function () {
    await this.getSession()
    await this.initDatatable()
  }
})

function deleteUsers(id) {
  window.application.deleteUsers(id)
}