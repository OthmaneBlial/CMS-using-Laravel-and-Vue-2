<template>
	<!-- TAGS  INDEX -->
	<div class="tags">
	<div v-show="flashMessageIsVisible" class="notification is-success" id="flash_message">
	  <button  v-on:click='hideFlashMessage' class="delete"></button>
	  {{ flash_message }}
	</div>
	<a class="button is-primary"  v-on:click='isActiveClass = "is-active"'>Add a new Tag</a><br>
	    
	    <table class="table" id="tags_index">
	      <thead>
	        <tr>
	          <th>#</th>
	          <th>Name</th>
	          <th>Create at</th>
	          <th>Edit</th>
	          <th>Delete</th>
	        </tr>
	      </thead>
	      <tbody>
	        <tr v-for="tag in tags">
	          <td>{{  tag.id }}</td>
	          <td>{{  tag.name }}</td>
	          <td>{{  tag.created_at }}</td>
	          <td><a v-on:click='editTag(tag)' class="button is-info">Edit</a></td>
	          <td><a v-on:click='deleteTag(tag.id)' class="button is-danger">Delete</a></td>
	        </tr>
	      </tbody>
	    </table>

	    <!-- TAGS CREATE -->
	   	<form method="POST" v-on:submit.prevent="onTagSubmit">
	    <div class="modal" v-bind:class="[isActiveClass]">
	      <div class="modal-background"></div>
	      <div class="modal-card">
	        <header class="modal-card-head">
	          <p class="modal-card-title">Add a new Tag</p>
	          <a class="delete" v-on:click='isActiveClass = ""'></a>
	        </header>
	        <section class="modal-card-body">
	          	<div class="field">
	          	  <label class="label">Name</label>
	          	  <p class="control">
	          	    <input name="name" v-model="name" class="input" type="text" placeholder="Enter Tag">
	          	  </p>
	          	</div>
	        </section>
	        <footer class="modal-card-foot">
	          <button type="submit" class="button is-success">Submit</button>
	          <a class="button" v-on:click='isActiveClass = ""'>Cancel</a>
	        </footer>
	      </div>
	    	</div>
	    </form>

	     <!-- TAGS EDIT -->
	    <form method="POST" v-on:submit.prevent="onTagUpdate">
	     <div class="modal" v-bind:class="[isActiveClassEdit]">
	       <div class="modal-background"></div>
	       <div class="modal-card">
	         <header class="modal-card-head">
	           <p class="modal-card-title">Edit this Tag</p>
	           <a class="delete" v-on:click='isActiveClassEdit = ""'></a>
	         </header>
	         <section class="modal-card-body">
	           	<div class="field">
	           	  <label class="label">Name</label>
	           	  <p class="control">
	           	    <input name="name" v-model="tag.name" class="input" type="text" placeholder="Enter Tag">
	           	  </p>
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
import Vue from 'vue'
import axios from 'axios'

function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}
    export default {
       
    	data() {
    		return {
    			isActiveClass: '',
    			isActiveClassEdit: '',
    			name: "",
    			tags: [{}],
                tag: {},
    			flash_message: "",
    			flashMessageIsVisible: false
    		}
    	},

    	methods: {

    		fetchData() {
    		    axios.get('/tags')
    		      .then(response => this.tags = response.data);
    		},

            fadeFlashMesssage() {
                sleep(3000).then(() => {
                  this.flashMessageIsVisible = false;
                  this.flash_message = "";
              });
            },

    		onTagSubmit() {

    		  axios.post('/tags', {

    		    name: this.name

    		  }).then(response => this.flash_message = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.name = "", this.isActiveClass = "")
                .then(this.fadeFlashMesssage());
    		    
    		},

    		hideFlashMessage() {

    			this.flashMessageIsVisible = false;
    		},

    		editTag(tag) {

    			this.isActiveClassEdit = "is-active";
                this.tag = tag;

    		},

    		onTagUpdate() {


    		  axios.post('/tags/'+ this.tag.id, {

    		    name: this.tag.name

    		  }).then(response => this.flash_message = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.isActiveClassEdit = "")
                .then(this.fadeFlashMesssage());


    		},



    		deleteTag(id) {

    			axios.get('/tags/'+ id)
    			    .then(response => this.flash_message = response.data)
                    .then(response => this.flashMessageIsVisible = true)
                    .then(this.fetchData())
                    .then(this.fadeFlashMesssage());


    		}
    	},

    	mounted() {

    	  //this.fetchData();

    	}

    }
</script>
