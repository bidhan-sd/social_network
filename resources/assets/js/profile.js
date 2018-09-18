
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    data: {
        msg: 'Click on user from left side:',
        content: '',
        privateMsgs: [],
        singleMsgs: [],
        msgFrom: '',
        conID: '',
        friend_id: '',
        seen: false,
        newMsgFrom: '',
        bUrl: 'http://localhost/bookLara/public/'

    },
    ready: function(){
        this.created();
    },
    created(){
        axios.get(this.bUrl + '/getMessages')
        .then(response => {
            console.log(response.data);
            app.privateMsgs = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    methods:{
        message: function(id){
            axios.get(this.bUrl + '/getMessages/' + id)
                .then(response => {
                console.log(response.data);
                app.singleMsgs = response.data;
                app.conID = response.data[0].conversation_id;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        //Bellow inputHandler function for conversation purpose when press enter
        inputHandler(e){
            if(e.keyCode ===13 && !e.shiftKey){
                e.preventDefault();
                this.sendMsg();
            }
        },
        sendMsg(){
            if(this.msgFrom){
                axios.post(this.bUrl + '/sendMessage', {
                    //conID = database value
                    //this.conID = this class variable
                    conID: this.conID, //First of all this.conID get from message method it will be above.
                    msg: this.msgFrom
                })
                .then(function (response) {
                    console.log(response.data);
                    //if conditation work for instant show message data.
                    if(response.status===200){
                        app.singleMsgs = response.data;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        friendID: function(id){
            app.friend_id = id;
        },
        sendNewMsg(){
            axios.post(this.bUrl + '/sendNewMessage', {
                friend_id: this.friend_id,
                msg: this.newMsgFrom,
            })
            .then(function (response) {
                console.log(response.data); // show if success
                if(response.status===200){
                    window.location.replace(this.bUrl + '/messages');
                    app.msg = 'Your message has been sent successfully';
                }
            })
            .catch(function (error) {
                console.log(error); // run if we have error
            });
        }
    },
});
