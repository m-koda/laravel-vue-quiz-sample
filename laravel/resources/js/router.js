import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/page/Home';
import Quiz from './components/page/Quiz';
import Register from './components/page/Register';
import Login from './components/page/Login';
import MyPage from './components/page/MyPage';
import Keyword from './components/page/Keyword';

Vue.use(Router);

const router = new Router({
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
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/keyword',
      name: 'keyword',
      component: Keyword,
    }
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(rec => rec.meta.requiresAuth)) {
    router.app.$http.get("/api/user").then(response => {
      const user = response.data;
      if (user) {
        next();
      } else {
        next({
          path: '/login'
        });
      }
    }).catch(error => {
      if (error.response.status === 401) {
        alert("ログインしてください");
      } else {
        alert("予期しないエラーが発生しました。再度ログインを行ってください");
      }
      next({
        path: '/login'
      });
    });
  } else {
    next();
  }
});

export default router;