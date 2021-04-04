window.stored = new Vue({
  el: '#me',
  data: {
    userSession: ''
  },
  methods: {
    getSession() {
      localStorage.getItem('users') ? this.userSession = JSON.parse(localStorage.getItem('users')) : window.location.href = '/auth/login'
    },
    saveSession(data) {
      localStorage.setItem('users', JSON.stringify(data))
    },
    removeSession() {
      localStorage.removeItem('users')
      window.location.href = '/auth/login'
    },
    async updateSession() {
      const makeRequest = await axios.get('/api/users/verifyJWT', { headers: { 'authorization': `Bearer ${this.userSession.access_token}` } })
      if (makeRequest.data.success) {
        await this.saveSession(makeRequest.data.message)
      } else {
        Swal.fire({ title: 'Session expired', icon: 'error', timer: 1500 }).then(async () => {
          await this.removeSession()
        })
      }
    }
  },
  mounted: async function() {
    await this.getSession()
    await this.updateSession()
    this.intervalSession = setInterval(async function() {
      await this.getSession()
      await this.updateSession()
    }.bind(this), 1000 * 30)
  }
})