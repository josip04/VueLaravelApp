export const store = {
    state: {
      user: '',
      user_id : '',
    },
    login(user,user_id) {
      this.state.user = user;
      this.state.user_id = user_id;
      
    },

  };