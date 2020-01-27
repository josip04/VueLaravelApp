export const store = {
    state: {
      logiran : false,
      user: '',
      user_id : '',
    },
    login(logiran,user,user_id) {
      this.state.logiran = logiran;
      this.state.user = user;
      this.state.user_id = user_id;
    },

  };