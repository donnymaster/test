/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);

const userChat = new Vue({
    el: '#app',

    data: {
        messages: []
    },

    created() {
        this.fetchMessages();
    },

    methods: {
        fetchMessages() {
            const id_broadcast = document.getElementById("id_broadcast").getAttribute('value');
            axios.get(`/messages/${id_broadcast}`).then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            var messageDisplay = document.querySelector('#scroll-1');
            messageDisplay.scrollTop = messageDisplay.scrollHeight;

            axios.post('/messages', message).then(response => {
              console.log(response.data);
            });
        }
    }
});

const channel = 'chat.' + document.getElementById("id_broadcast").getAttribute('value');


Echo.private(channel)
  .listen('MessageSent', (e) => {
    var id = document.getElementById("user_id").getAttribute('value');
    if(e.message.user_id != id){
        userChat.messages.push({
            message: e.message.message,
            user: e.user
          });
          var messageDisplay = document.querySelector('#scroll-1');
          messageDisplay.scrollTop = messageDisplay.scrollHeight;
    }
});
