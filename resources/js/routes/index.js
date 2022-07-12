import Homepage from '../pages/Homepage.vue'
import AdvertiseAdd from "../pages/AdvertiseAdd"
import AdvertiseShow from "../pages/AdvertiseShow"
import Error404 from "../pages/errors/Error404"

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Homepage,
        },
        {
            path: '/advertise/add',
            name: 'advertise.add',
            component: AdvertiseAdd,
        },
        {
            path: '/advertise/:id',
            name: 'advertise.show',
            component: AdvertiseShow,
        },

        { path: '*', component: Error404 }
    ]
}
