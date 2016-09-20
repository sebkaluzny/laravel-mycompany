import App from './components/app.vue';
import GoodsReceived from './views/goods-received.vue';
import GoodsReceivedCreate from './views/goods-received/create.vue';
import GoodsReceivedShow from './views/goods-received/show.vue';
import GoodsReceivedEdit from './views/goods-received/edit.vue';

import ElementIndex from './views/element/index.vue';
import ElementShow from './views/element/show.vue';

import ElementTaskMain from './views/element-task/main.vue';
import ElementTaskIndex from './views/element-task/index.vue';
import ElementTaskCreate from './views/element-task/create.vue';
import ElementTaskShow from './views/element-task/show.vue';

// Create a router instance.
// You can pass in additional options here, but let's
// keep it simple for now.
var router = new VueRouter({
    hashbang: true,
    history: false
});

// Define some routes.
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
router.map({
    '/': {
        component: ElementIndex
    },

    '/goods-received': {
        component: GoodsReceived
    },

    '/goods-received/create': {
        component: GoodsReceivedCreate
    },

    '/goods-received/:id' : {
        name: 'goods-received-show',
        component: GoodsReceivedShow,
    },

    '/goods-received/:id/edit' : {
        name: 'goods-received-edit',
        component: GoodsReceivedEdit,
    },


    '/element': {
        component: ElementIndex
    },

    '/element/:id' : {
        name: 'element-show',
        component: ElementShow,
    },


    '/element-task': {
        component: ElementTaskMain,

        subRoutes: {
            '/': {
                component: ElementTaskIndex
            },
            '/create': {
                component: ElementTaskCreate
            },
            '/:id': {
                name: 'element-task-show',
                component: ElementTaskShow,
            }
        }
    }
})


// Now we can start the app!
// The router will create an instance of App and mount to
// the element matching the selector #app.
router.start(App, '#app');