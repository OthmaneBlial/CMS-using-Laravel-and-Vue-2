
require('./bootstrap');


Vue.component('tag', require('./components/Tag.vue'));
Vue.component('post', require('./components/Post.vue'));
Vue.component('category', require('./components/Category.vue'));
Vue.component('index', require('./components/Index.vue'));
Vue.component('user', require('./components/User.vue'));

window.Event = new Vue();


const app = new Vue({
    el: '#app',

    data: {

      Visibility: "",

    },

    methods: {

      onIndex() {

        this.Visibility = "index";
        Event.$emit('returnToIndex');

      }

   
    },

    mounted() {
      this.Visibility = "index";
    }
});







/*
new Vue({
    el: '#app',


    data: {

      postsVisibility: false,
      categoriesVisibility: false,
      tagsVisibility: false,
      tags: {},
      name: "",
      tagIdToEdit: 0,
      flash_message: ""

    },

    methods: {

      postsVisibe() {
  
        this.postsVisibility = true;
        this.categoriesVisibility = false;
        this.tagsVisibility = false;

      },

      categoriesVisibe() {
  
        this.categoriesVisibility = true;
        this.postsVisibility = false;
        this.tagsVisibility = false;

      },

      tagsVisibe() {
  
        this.tagsVisibility = true;
        this.postsVisibility = false;
        this.categoriesVisibility = false;

      },

      onPostSubmit() {

        alert('hello');

      },

      onTagSubmit() {

        axios.post('/tags', {

          name: this.name

        })
        .then(response => this.fetchData());

        this.name = "";

      },

      fetchData() {
          axios.get('/tags')
            .then(response => this.tags = response.data);
      },

      deleteTag(id) {

        axios.get('/tags/'+ id)
            .then(response => this.flash_message = response, this.fetchData());

      },

      doubleClick(id) {

        this.tagIdToEdit = id;
        this.hideAfterUpdate = 0;
      },

      onTagUpdate(tag) {

        axios.post('/tags/'+ tag.id, {

          name: tag.name

        })
        .then(response => this.fetchData());

        this.tagIdToEdit = 0;

      }


    },

    mounted() {

      this.fetchData();

    }

});





*/


