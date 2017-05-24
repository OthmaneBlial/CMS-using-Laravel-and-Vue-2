<template>
  
  <!-- POSTS  INDEX -->
  <div class="posts">
  <div v-show="flashMessageIsVisible" class="notification is-success" id="flashMessage">
    <button  v-on:click='flashMessageIsVisible = flase' class="delete"></button>
    {{ flashMessage }}
  </div>
  <a class="button is-primary"  v-on:click='isActiveClass = "is-active"'>Add a new Post</a><br>
      <table class="table" id="posts_index">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Create at</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in posts">
            <td>{{  post.id }}</td>
            <td>{{  post.title }}</td>
            <td>{{  post.created_at }}</td>
            <td><a v-on:click='editPost(post)' class="button is-info">Edit</a></td>
            <td><a v-on:click='deletePost(post.id)' class="button is-danger">Delete</a></td>
          </tr>
        </tbody>
      </table>

      <!-- POSTS CREATE -->
      <form method="POST" v-on:submit.prevent="onPostSubmit">
      <div class="modal" v-bind:class="[isActiveClass]">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Add a new Post</p>
            <a class="delete" v-on:click='isActiveClass = ""'></a>
          </header>
          <section class="modal-card-body">
              <div class="field">
                <label class="label">Name</label>
                <p class="control">
                  <input name="title" v-model="data.title" class="input" type="text" placeholder="Enter Title">
                </p>
              </div>
              <div class="field">
                <label class="label">Category</label>
                <p class="control">
                  <span class="select">
                    <select name="category_id" v-model="data.category_id" style="width: 300px;">
                      <option v-bind:value="category.id" v-for='category in categories'>{{ category.name }}</option>
                    </select>
                  </span>
                </p>
              </div>
              <div class="field">
                <label class="label">Tag</label>
                <p class="control">
                    <select name="tags_list[]" v-model="data.tags_list"  multiple="multiple"  style="width: 300px;">
                      <option v-bind:value="tag.id" v-for='tag in tags'>{{ tag.name }}</option>
                    </select>
                </p>
              </div>
              <div class="field">
                  <div class="control">
                      <textarea name="content" v-model="data.content" class="textarea" placeholder="Enter your content"></textarea>
                  </div>
              </div>
          </section>
          <footer class="modal-card-foot">
            <button type="submit" class="button is-success">Submit</button>
            <a class="button" v-on:click='isActiveClass = ""'>Cancel</a>
          </footer>
        </div>
      </div>
      </form>

       <!-- POSTS EDIT -->
       <form method="POST" v-on:submit.prevent="onPostUpdate">
       <div class="modal" v-bind:class="[isActiveClassEdit]">
         <div class="modal-background"></div>
         <div class="modal-card">
           <header class="modal-card-head">
             <p class="modal-card-title">Edit a Post</p>
             <a class="delete" v-on:click='isActiveClassEdit = ""'></a>
           </header>
           <section class="modal-card-body">
               <div class="field">
                 <label class="label">Name</label>
                 <p class="control">
                   <input name="title" v-model="post.title" class="input" type="text" placeholder="Enter Title">
                 </p>
               </div>
               <div class="field">
                 <label class="label">Category</label>
                 <p class="control">
                   <span class="select">
                     <select name="category_id" v-model="post.category_id" style="width: 300px;">
                       <option v-bind:value="category.id" v-for='category in categories'>{{ category.name }}</option>
                     </select>
                   </span>
                 </p>
               </div>
               <div class="field">
                   <div class="control">
                       <textarea name="content" v-model="post.content" class="textarea" placeholder="Enter your content"></textarea>
                   </div>
               </div>
           </section>
           <footer class="modal-card-foot">
             <button type="submit" class="button is-success">Submit</button>
             <a class="button" v-on:click='isActiveClassEdit = ""'>Cancel</a>
           </footer>
         </div>
       </div>
       </form>
  </div>



</template>

<script>

function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}



import Vue from 'vue'
import axios from 'axios'


    export default {
       
        data() {
            return {
                isActiveClass: '',
                isActiveClassEdit: '',
                data: {title: '', category_id: '', content: '', tags_list: []},
                posts: [{}],
                categories: [{}],
                tags: [{}],
                post: {},
                flashMessage: "",
                flashMessageIsVisible: false
            }
        },

        methods: {

            fetchData() {
                axios.get('/posts').then(response => this.posts = response.data);
                axios.get('/categories').then(response => this.categories = response.data);
                axios.get('/tags').then(response => this.tags = response.data);
            },


            fadeFlashMesssage() {
                sleep(3000).then(() => {
                  this.flashMessageIsVisible = false;
                  this.flashMessage = "";
              });
            },

            onPostSubmit() {

              axios.post('/posts', {

                title: this.data.title,
                category_id: this.data.category_id,
                content: this.data.content,
                tags_list: this.data.tags_list

              }).then(response => this.flashMessage = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.name = "", this.isActiveClass = "")
                .then(this.fadeFlashMesssage());

                Event.$emit('postWasCreated');
                
            },

            hideFlashMessage() {

                this.flashMessageIsVisible = false;
            },

            editPost(post) {

                this.isActiveClassEdit = "is-active";
                this.post = post;
                //this.fetchDataPostTags(post.id)
                //console.log(this.post_tags);

            },

            onPostUpdate() {


              axios.post('/posts/'+ this.post.id, {

                title: this.post.title,
                category_id: this.post.category_id,
                content: this.post.content

              }).then(response => this.flashMessage = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.isActiveClassEdit = "")
                .then(this.fadeFlashMesssage());


            },

            deletePost(id) {

                axios.get('/posts/'+ id)
                    .then(response => this.flashMessage = response.data)
                    .then(response => this.flashMessageIsVisible = true)
                    .then(this.fetchData())
                    .then(this.fadeFlashMesssage());


                Event.$emit('postWasDeleted');


            }
        },

        mounted() {

          this.fetchData();

        }

    }
</script>
