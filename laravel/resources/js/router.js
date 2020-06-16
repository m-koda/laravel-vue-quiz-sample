import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/page/Home';
import Quiz from './components/page/Quiz';
import Register from './components/page/Register';
import Login from './components/page/Login';
import MyPage from './components/page/MyPage';
import Keyword from './components/page/Keyword';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/quiz',
      name: 'quiz',
      component: Quiz,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/mypage',
      name: 'mypage',
      component: MyPage,
    },
    {
      path: '/keyword',
      name: 'keyword',
      component: Keyword,
    }
  ],
});