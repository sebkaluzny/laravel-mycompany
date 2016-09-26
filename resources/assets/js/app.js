
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('app', require('./components/app.vue'));
Vue.component('page-loader', require('./components/PageLoader.vue'));

Vue.component('element-task-menu', require('./views/element-task/_menu.vue'));
Vue.component('element-task-form', require('./views/element-task/_form.vue'));

Vue.component('project-form', require('./components/form/Project.vue'));
Vue.component('project-select-modal', require('./components/modals/SelectProject.vue'));

Vue.component('export-elements-modal', require('./components/modals/ExportElements.vue'));


// const app = new Vue({
//     el: 'body'
// });

require('./router');