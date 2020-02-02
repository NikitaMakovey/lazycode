// Components
import SkeletonComponent from '../components/BaseComponents/SkeletonComponent';
import PostsMainComponent from "../components/PostComponents/MainComponent";
import MainCategoryComponent from "../components/PostComponents/MainCategoryComponent"
import PostComponent from "../components/PostComponents/PostComponent";
import EditPostComponent from "../components/PostComponents/EditComponent";
import CreatePostComponent from "../components/PostComponents/CreateComponent";
import UsersMainComponent from "../components/UserComponents/MainComponent";
import UserComponent from "../components/UserComponents/UserComponent";
import EditUserComponent from "../components/UserComponents/EditComponent";

// Auth Layouts
import AuthLayout from "../components/BaseComponents/AuthLayout";
import Register from "../components/AuthComponents/Register";
import Login from "../components/AuthComponents/Login";
import ResetEmail from "../components/AuthComponents/ResetEmail";
import ResetPassword from "../components/AuthComponents/ResetPassword";

// NotFound Component
import NotFound from "../components/ErrorComponents/NotFound";

// Middleware
import auth from './middleware/auth';
import guest from './middleware/guest';

// Api View
import ApiDocs from "../components/DocsComponents/ApiDocs";

const routes = [
    { path: '/', component: SkeletonComponent,
        children: [
            { path: '', name: 'main', component: PostsMainComponent },
            { path: 'categories/:slug', name: 'category', component: MainCategoryComponent },
            { path: 'posts/:id', name: 'post', component: PostComponent },
            { path: 'posts/:id/edit', name: 'posts.edit', component:  EditPostComponent, meta: { middleware: [ auth ] } },
            { path: 'post/create', name: 'posts.create', component:  CreatePostComponent, meta: { middleware: [ auth ] } },
            { path: 'users', name: 'users', component: UsersMainComponent },
            { path: 'users/:id', name: 'user', component: UserComponent},
            { path: '/users/:id/edit', name: 'users.edit', component: EditUserComponent, meta: { middleware: [ auth ] } }
        ]
    },
    { path: '/auth', component: AuthLayout,
        children: [
            { path: 'register', name: 'auth.register', component: Register, meta: { middleware: [ guest ] } },
            { path: 'login', name: 'auth.login', component: Login, meta: { middleware: [ guest ] } },
            { path: 'password/email', name: 'auth.email', component: ResetEmail },
            { path: 'password/reset/:token', component: ResetPassword, props: true },
        ]
    },
    { path: '/docs', component: ApiDocs },
    { path: '*', name: 'notfound', component: NotFound }
];

export default routes;



