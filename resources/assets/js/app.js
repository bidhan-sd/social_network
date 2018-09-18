
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
        msg: 'Udpate New Post',
        content: '',
        posts: [],
        likes: [],
        commentData: {},
        commentBoxSeen: false,
        image: '',
        bUrl: 'http://localhost/bookLara/public/',
        updatedContent: '',
        qry: '',
        results: [],
    },
    ready: function(){
        this.created();
    },
    created(){
        //Fetching Post data without any action.
        axios.get(this.bUrl + '/posts')
        .then(response => {
            //console.log(response);
            this.posts = response.data;
            Vue.filter('myOwnTime', function (value) {
                return moment(value).fromNow();
                //return moment(value).startOf().fromNow();
            });
        })
        .catch(function (error) {
            console.log(error);
        });

        //Fetching like data without any action.

        axios.get(this.bUrl + '/likes')
        .then(response => {
            //console.log(response);
            this.likes = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });

    },
    methods:{
        addPost(){
            axios.post(this.bUrl + '/addPost', {
                //content = database jabe.
                //this.content = ai class ar variable
                contents: this.content
            })
            .then( (response) => {
                this.content = "";
                if(response.status===200){
                    app.posts = response.data;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        openModal(id){
            axios.get(this.bUrl + '/posts/' + id)
            .then(response => {
                //console.log(response); // show if success into console.
                this.updatedContent = response.data; // we are putting data into our posts array.
            })
            .catch(function (error) {
                console.log(error); // run if we have error.
            });
        },
        updatePost(id){
            axios.post(this.bUrl + '/updatePost/' + id, {
                updatedContent: this.updatedContent
            })
            .then( (response) => {
                this.content = "";
                if(response.status===200){
                    app.posts = response.data;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        deletePost(id){
            axios.get(this.bUrl + '/deletePost/' + id)
            .then(response => {
                console.log(response); // show if success into console.
                this.posts = response.data; // we are putting data into our posts array.
            })
            .catch(function (error) {
                console.log(error); // run if we have error.
            });
        },
        likePost(id){
            axios.get(this.bUrl + '/likePost/' + id)
            .then(response => {
                //console.log(response); // show if success into console.
                this.posts = response.data; // we are putting data into our posts array.
            })
            .catch(function (error) {
                console.log(error); // run if we have error.
            });
        },
        addComment(post,key){
            axios.post(this.bUrl + '/addComment', {
                //content = database jabe.
                //this.content = ai class ar variable
                comment: this.commentData[key],
                id: post.id,
            })
            .then(function (response) {
                console.log("Save Successfully.");
                if(response.status===200){
                    app.posts = response.data;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        onFileChange(e){
            var files = e.target.files || e.dataTransfer.files;
            this.createImg(files[0]); // Files the image/file value to our function
        },
        createImg(file){
            //we will preview our image before upload
            var image = new Image;
            var reader = new FileReader;
            reader.onload = (e) =>{
                this.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        uploadImg(){
            axios.post(this.bUrl + '/saveImg', {
                image: this.image,
                contents: this.content
            })
            .then( (response) => {
                console.log("Save Successfully");   // Show if success
                this.image = "";
                this.content = "";

                if(response.status===200){
                    app.posts = response.data;
                }

            })
            .catch(function (error) {
                console.log(error);  //Run if we have error
            });
        },
        removeImg(){
            this.image = ""
        },
        autoComplete(){
            this.results = [];
            axios.post(this.bUrl + '/search', {
                qry: this.qry
            })
            .then( (response) => {
                console.log(response);
                app.results = response.data;
            })
        }
    }
});
