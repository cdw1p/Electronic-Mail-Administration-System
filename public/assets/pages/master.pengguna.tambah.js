$.fn.dataTable.ext.errMode = 'none'

new Vue({
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
    setDefaultForm: function() {
      window.location.href = '/master/pengguna/data'
    },
    postAddNewUsers: async function () {
      Swal.fire({ title: 'Apakah Anda yakin ingin melanjutkan ?', showCancelButton: true, confirmButtonText: 'Lanjutkan', cancelButtonText: 'Batalkan' }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            this.swalShowLoading()
            const makeRequest = await axios.post('/api/master/addNewUsers', this.inputForm, { headers: { 'authorization': `Bearer ${this.userSession.access_token}` } })
            if (makeRequest.data.success) {
              Swal.fire({ title: 'Data berhasil disimpan', icon: 'success', timer: 1500 }).then(() => {
                window.location.reload()
              })
            } else {
              Swal.fire({ title: 'Data gagal disimpan', text: makeRequest.data.message, icon: 'error' })
            }
          } catch (err) {
            Swal.fire({ title: 'Data gagal disimpan', text: err.message, icon: 'error' })
          }
        }
      })
    },
  },
  mounted: async function () {
    await this.getSession()
  }
})