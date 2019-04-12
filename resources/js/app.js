
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

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    
    data: {
        messages: [],
        users: [],
    },

    created() {
        this.fetchMessages();

        Echo.join('chat')
            .here(users => {
                this.users = users;
            })
            .joining(user => {
                this.users.push(user);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.id !== user.id);
            })
            .listen('MessageSent', (event) => {
                // to ramy
                if (event.message.roomChannel == roomlayout){
                    this.messages.push({
                        message: event.message.message,
                        user: event.user
                    });

                    this.users.forEach((user, index) => {
                        if (user.id === event.user.id) {
                            this.$set(this.users, index, user);
                        }
                    });
                }
            });
            // .listenForWhisper("typing",response =>{
            //     console.log("aykalam");
            //     console.log(response);
            // });
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                // to ramy
                this.messages = response.data.filter(m => m.roomChannel == roomlayout)
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        }
    }
});
