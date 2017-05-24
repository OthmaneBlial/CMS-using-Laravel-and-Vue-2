<template>


<div class="comments">
	<h1>Comments</h1>
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
    			comments: {},
                comment: {},
    			flash_message: "",
    			flashMessageIsVisible: false
    		}
    	},

    	methods: {

    		fetchData() {
    		    axios.get('/comments')
    		      .then(response => this.comments = response.data);
    		},

            fadeFlashMesssage() {
                sleep(3000).then(() => {
                  this.flashMessageIsVisible = false;
                  this.flash_message = "";
              });
            },

    		onCommentSubmit() {

    		  axios.post('/comments', {

    		    name: this.name

    		  }).then(response => this.flash_message = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.name = "", this.isActiveClass = "")
                .then(this.fadeFlashMesssage());
    		    
    		},

    		hideFlashMessage() {

    			this.flashMessageIsVisible = false;
    		},

    		editComment(comment) {

    			this.isActiveClassEdit = "is-active";
                this.comment = comment;

    		},

    		onCommentUpdate() {

                this.flashMessageIsVisible = false;

    		  axios.post('/comments/'+ this.comment.id, {

    		    name: this.comment.name

    		  }).then(response => this.flash_message = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.isActiveClassEdit = "")
                .then(this.fadeFlashMesssage());


    		},

    		deleteComment(id) {

    			axios.get('/comments/'+ id)
    			    .then(response => this.flash_message = response.data)
                    .then(response => this.flashMessageIsVisible = true)
                    .then(this.fetchData())
                    .then(this.fadeFlashMesssage());


    		}
    	},

    	mounted() {

    	  this.fetchData();

    	}

    }
</script>
