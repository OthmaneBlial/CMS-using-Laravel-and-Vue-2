<template>

<div>
<a href="#/posts" class="button is-primary" v-on:click="returnBack" v-show="showingAllPosts == false">Return back</a>

<!-- SHOW ALL POSTS-->

<section class="hero is-white is-bold"  v-for="post in posts" style="margin-bottom: 40px;"  v-show="showingAllPosts == true">
  <div class="hero-body">
    <div class="container">
      <a :href="'#/posts/'+ post.id"><h1 class="title is-center" v-on:click="showPost(post)">
        {{ post.title }}
      </h1></a><br>
      <h2 class="subtitle">
        {{ post.content }} Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore.
      </h2>
    </div>
  </div>
</section>

<!-- SHOW ONE POST-->

<section class="hero is-primary is-bold" style="margin-bottom: 40px;" v-show="showingPost == true">
  <div class="hero-body">
    <div class="container">
      <h1 class="title is-center">
        {{ chosenPost.title }}
      </h1><br>
      <h2 class="subtitle">
        {{ chosenPost.content }} Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore. tempor incididunt ut labore et dolore magna aliqua. 
        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip 
        ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </h2>
    </div>
  </div>
  <article class="media" v-for="comment in chosenPost.comments">
    <figure class="media-left">
      <p class="image is-64x64">
        <img src="http://bulma.io/images/placeholders/128x128.png">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ chosenPost.user.name }}</strong> <small>{{ comment.email }}</small> <small>31m</small>
          <br>
          {{ comment.comment }}
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
        </p>
      </div>
    </div>
    <div class="media-right">
      <button class="button is-danger" v-show="user.id == chosenPost.user_id ">delete</button>
      <button class="button is-info" v-show="user.id == chosenPost.user_id ">edit</button>
    </div>
  </article>
  <br>
  <form method="POST" v-on:submit.prevent="onComment(chosenPost)">
  <article class="media" v-show="userStatus == true">
    <figure class="media-left">
      <p class="image is-64x64">
        <img src="http://bulma.io/images/placeholders/128x128.png">
      </p>
    </figure>
    <div class="media-content">
      <div class="field">
        <p class="control">
          <textarea name="comment" v-model="comment" class="textarea" placeholder="Add a comment..."></textarea>
        </p>
      </div>
      <nav class="level">
        <div class="level-left">
          <div class="level-item">
            <button type="submit" class="button is-success">Submit</button>
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <label class="checkbox">
              <input type="checkbox"> Press enter to submit
            </label>
          </div>
        </div>
      </nav>
    </div>
  </article>
  </form>
</section>

</div>


</template>

<script>
import Vue from 'vue'
import axios from 'axios'



    export default {
       
    	data() {
    		return {

                comment: "",
    			      posts: [{}],
                userStatus: false,
                chosenPost: {},
                showingPost: false,
                showingAllPosts: true,
                user: {}

    		}
    	},

    	methods: {


    		    fetchData() {
    		        axios.get('/posts')
    		          .then(response => this.posts = response.data);
    		    },

            fetchDataChosenPost(id) {
                axios.get('/posts/show/' + id)
                  .then(response => this.chosenPost.comments = response.data);
            },


            isLoggedIn() {
                axios.get('/isloggedin')
                  .then(response => this.userStatus = response.data);
            },

            loggedInUser() {
                axios.get('/user')
                  .then(response => this.user = response.data);
            },


            onComment(post) {

              axios.post('/comments', {

                email: post.user.email,
                user_id: post.user_id,
                post_id: post.id,
                comment: this.comment,


              })/*.then(response => this.fetchData())*/
                .then(response => this.fetchDataChosenPost(post.id))
                .then(response => console.log(response));


                this.comment = "";

                
            },

            showPost(post) {

                this.chosenPost = post;
                this.showingPost = true;
                this.showingAllPosts = false;
                Event.$on('userLoggedIn', () => this.userStatus = true);

            },

            returnBack() {

                this.showingPost = false;
                this.showingAllPosts = true;
            }

    	},

    	mounted() {

    	   //this.fetchData();
          this.isLoggedIn()
          this.loggedInUser();
          Event.$on('postWasCreated', () => this.fetchData());
          Event.$on('postWasDeleted', () => this.fetchData());
          Event.$on('userLoggedOut', () => this.isLoggedIn());
          Event.$on('returnToIndex', () => this.returnBack());


    	}

    }
</script>


<style type="text/css">
    
section {

    padding: 30px;
}

h2 {

    max-width: 700px;
}

</style>
