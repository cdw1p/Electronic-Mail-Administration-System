new Vue({
  el: '#login',
  data: {
    inputForm: {},
    isFormError: '',
    isFormSuccess: ''
  },
  methods: {
    swalShowLoading() {
      Swal.fire({ allowEscapeKey: false, allowOutsideClick: false, showConfirmButton: false, onOpen: () => { Swal.showLoading() } })
    },
    saveSession(data) {
      localStorage.setItem('users', JSON.stringify(data))
    },
    postAuthLogin: async function() {
      try {
        this.swalShowLoading()
        const makeRequest = await axios.post('/api/auth/login', this.inputForm)
        if (makeRequest.data.success) {
          await this.saveSession(makeRequest.data.message)
          Swal.fire({ title: 'Autentikasi berhasil', icon: 'success', timer: 1500 }).then(() => {
            window.location.href = '/dashboard'
          })
        } else {
          Swal.fire({ title: 'Autentikasi gagal', text: makeRequest.data.message, icon: 'error' })
        }
      } catch (err) {
        Swal.fire({ title: 'Autentikasi gagal', text: err.message, icon: 'error' })
      }
    }
  }
})