// Components
import SkeletonComponent from '../components/BaseComponents/SkeletonComponent';
import PostsMainComponent from "../components/PostComponents/MainComponent";
import PostComponent from "../components/PostComponents/PostComponent";

// Auth Layouts
import AuthLayout from "../components/BaseComponents/AuthLayout";
import Register from "../components/AuthComponents/Register";
import Login from "../components/AuthComponents/Login";
import Logout from "../components/AuthComponents/Logout";
import ResetEmail from "../components/AuthComponents/ResetEmail";
import ResetPassword from "../components/AuthComponents/ResetPassword";

// NotFound Component
import NotFound from "../components/ErrorComponents/NotFound";

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
import BaseLayout from "../components/BaseComponents/BaseLayout";

// Middleware
import auth from './middleware/auth';
import guest from './middleware/guest';

// Api View
import ApiDocs from "../components/DocsComponents/ApiDocs";

const routes = [
    { path: '/', component: SkeletonComponent,
        children: [
            { path: '', name: 'main', component: PostsMainComponent },

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
    { path: '/docs', component: ApiDocs },
    { path: '*', name: 'notfound', component: NotFound }
];

export default routes;



