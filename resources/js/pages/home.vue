<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div id="todo-container" class="p-3">
                    <section id="todo-header" class="mt-3">
                        <h3 class="text-center">TodoList Web App</h3>
                    </section>
                    <section id="todo-errors">
                        <div v-if="createTodoForm.errors.length > 0" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span v-for="(error, index) in createTodoForm.errors" :key="index">{{ error }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div v-if="createTodoForm.isCreated" class="alert alert-success alert-dismissible fade show" role="alert">
                            <span>Todo item created successfully</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                    </section>
                    <section id="add-todo-form" class="my-3">
                        <form>
                            <div class="d-flex justify-content-between align-items-center">
                                <input
                                    v-model="createTodoForm.content"
                                    v-on:keyup.enter="addTodo"
                                    minlength="5" maxlength="50"
                                    placeholder="Enter todo"
                                    type="text" class="form-control mr-3">
                                  
                                <button v-if="createTodoForm.isSubmitting" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>
                                </button>
                                <button v-else @click.prevent="addTodo" class="btn btn-primary">Add</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <input class="form-control mt-2" @keyup="filter" type="text" name="filter" id="filter" placeholder="Search...">
                            </div>
                        </form>
                    </section>
                    <section id="todo-actions"></section>
                    <section id="todo-list">
                        <ul class="list-group" id="todoListContainer">
                            <div v-if="todos.isLoading" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <li
                                v-for="todo in todos.data" :key="todo.uuid"
                                class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="todo-content">{{ todo.content }}</span>
                                    <span class="d-flex justify-content-between align-items-center">
                                        <a class="text-danger" href="#" @click.prevent="destroy(todo)">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </span>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <small class="text-muted">Created</small>
                                    <small class="text-muted">{{ todo.created_at }}</small>
                                </div>
                            </li>
                            <li v-if="!todos.isLoading && todos.data.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No todo items found.
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import $ from 'jquery'
    export default {
        name: 'TodoList',
        data() {
            return {
                todos: {
                    isLoading: false,
                    data: []
                },
                createTodoForm: {
                    isSubmitting: false,
                    isCreated: false,
                    content: undefined,
                    errors: []
                },
                error: undefined
            }
        },
        mounted() {
            this.loadTodos();
        },
        methods: {
            /**
             * Loads todos
             */
            loadTodos() {
                // update loader to loading
                this.todos.isLoading = true;

                axios.get('/api/todos')
                .then((response) => {
                    this.todos.data = response.data;
                })
                .catch((error) => {
                    //TODO: update with your logic on how to handle this error.
                    console.log(error.message);
                    this.error = 'Unable to load todos. View log for more information';
                })
                .finally(() => {
                    // disable loader
                    this.todos.isLoading = false;
                })
            },

            /**
             * Local Search.
             * Uses to filter todo list
             */
            filter() {
              let input = document.getElementById('filter').value.toLowerCase();
              var list = document.getElementsByTagName('li');
              
              for(let i = 1; i < list.length; i++)
              {
                let value = list[i].getElementsByClassName('todo-content')[0].innerText;
                if (value.toLowerCase().indexOf(input) > -1) {
                    list[i].style.display = 'block';
                } else {
                    list[i].style.display = 'none';
                }
              }
            },

            /**
             * Create a TodoItem.
             * Uses payload in the this.createTodoForm param
             */
            addTodo() {
                if(this.createTodoForm.content == undefined) {
                  this.createTodoForm.errors.push('Please add Todo task to continue');
                  return;
                }
                // update loader to loading
                this.createTodoForm.isSubmitting = true;
                // Use can use this as the payload.
                axios.post('/api/todos/store', this.createTodoForm)
                .then((response) => {
                    this.createTodoForm.errors = [];
                    this.createTodoForm.content = undefined;
                    this.createTodoForm.isCreated = true;
                    this.loadTodos();
                })
                .catch((error) => {
                    /**
                     * Check for form validation error. Laravel return http code 422
                     * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                     */
                    if (error.response && error.response.status === 422) {
                        this.createTodoForm.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        //TODO: update with your logic on how to handle this error.
                        console.log(error.message);
                        this.error = 'Unable to add todo. View log for more information';
                    }
                })
                .finally(() => {
                    // disable loader
                    this.createTodoForm.isSubmitting = false;
                })
            },
            /**
             * Deletes a TodoItem
             * @param todoItem
             */
            destroy(todoItem) {
                // Use can use this as the payload.
                axios.delete(`/api/todos/${todoItem.id}`)
                    .then((response) => {
                        this.loadTodos();
                    })
                    .catch((error) => {
                        this.error = 'Unable to delete todo. View log for more information';
                    })
            }
        }
    }
</script>
