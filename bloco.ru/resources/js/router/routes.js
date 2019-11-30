

// Auth Layouts
import AuthLayout from "../components/Layouts/AuthLayout";
import Register from "../components/Auth/Register";
import Login from "../components/Auth/Login";
import Logout from "../components/Auth/Logout";
import ResetEmail from "../components/Auth/ResetEmail";
import ResetPassword from "../components/Auth/ResetPassword";

// NotFound Component
import NotFound from "../components/ErrorPages/NotFound";

// Main Views
import Main from "../components/Views/posts/MainPage";
import Post from "../components/Views/posts/Post";
import CreatePostPage from "../components/Views/posts/CreatePostPage";
import EditPostPage from "../components/Views/posts/EditPostPage";
import IndexUserPage from "../components/Views/users/IndexUserPage";
import User from "../components/Views/users/User";
import UserProfile from '../components/Views/users/profile/UserProfile';
import UserPosts from '../components/Views/users/profile/UserPosts';
import UserComments from '../components/Views/users/profile/UserComments';
import EditUserPage from "../components/Views/users/EditUserPage";

// NavBar Layout
import BaseLayout from "../components/Layouts/BaseLayout";

// Middleware
import auth from './middleware/auth';
import guest from './middleware/guest';

const routes = [
    { path: '/', component: BaseLayout,
        children: [
            { path: '', name: 'main', component: Main },
            { path: 'posts/create', name: 'posts.create', component:  CreatePostPage, meta: { middleware: [ auth ] } },
            { path: 'posts/:id/edit', name: 'posts.edit', component:  EditPostPage, meta: { middleware: [ auth ] } },
            { path: 'posts/:id', name: 'post', component: Post },
            { path: 'users', name: 'users', component: IndexUserPage },
            { path: 'users/:id', name: 'user', component: User,
                children: [
                    { path: '', name: 'user.about', component: UserProfile },
                    { path: 'posts', name: 'user.posts', component: UserPosts },
                    { path: 'comments', name: 'user.comments', component: UserComments }
                ]
            },
            { path: '/users/:id/edit', name: 'users.edit', component: EditUserPage, meta: { middleware: [ auth ] } }
        ]
    },
    { path: '/auth', component: AuthLayout,
        children: [
            { path: 'register', name: 'auth.register', component: Register, meta: { middleware: [ guest ] } },
            { path: 'login', name: 'auth.login', component: Login, meta: { middleware: [ guest ] } },
            { path: 'logout', name: 'auth.logout', component: Logout, meta: { middleware: [ auth ] } },
            { path: 'password/email', name: 'auth.email', component: ResetEmail },
            { path: 'password/reset/:token', component: ResetPassword, props: true },
        ]
    },
    { path: '*', name: 'notfound', component: NotFound }
];

export default routes;


