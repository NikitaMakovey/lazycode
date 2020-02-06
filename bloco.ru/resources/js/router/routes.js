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

// Admin
import AdminComponent from "../components/AdminComponents/MainComponent";
import ItemsComponent from "../components/AdminComponents/ItemsComponent";
import ItemComponent from "../components/AdminComponents/ItemComponent";

// Middleware
import auth from './middleware/auth';
import guest from './middleware/guest';
import admin from './middleware/admin';
import user from './middleware/user';

// Api View
import ApiDocs from "../components/DocsComponents/ApiDocs";

//
import AboutComponent from "../components/UserComponents/ProfileComponents/AboutComponent";
import UserPostComponent from "../components/UserComponents/ProfileComponents/PostComponent"
import UserCommentComponent from "../components/UserComponents/ProfileComponents/CommentComponent"

const routes = [
    { path: '/', component: SkeletonComponent,
        children: [
            { path: '', name: 'main', component: PostsMainComponent },
            { path: 'categories/:slug', name: 'category', component: MainCategoryComponent },
            { path: 'posts/:id', name: 'post', component: PostComponent },
            { path: 'posts/:id/edit', name: 'posts.edit', component:  EditPostComponent, meta: { middleware: [ auth ] } },
            { path: 'post/create', name: 'posts.create', component:  CreatePostComponent, meta: { middleware: [ auth ] } },
            { path: 'users', name: 'users', component: UsersMainComponent },
            { path: 'users/:id/', name: 'user', component: UserComponent,
                children: [
                    { path: 'about', name: 'user.about', component: AboutComponent, meta: { middleware: [ user ] } },
                    { path: 'posts', name: 'user.posts', component: UserPostComponent, meta: { middleware: [ user ] } },
                    { path: 'comments', name: 'user.comments', component: UserCommentComponent, meta: { middleware: [ user ] } },
                ]
            },
            { path: 'user/', name: 'me', component: UserComponent,
                children: [
                    { path: 'about', name: 'me.about', component: AboutComponent, meta: { middleware: [ auth ] } },
                    { path: 'posts', name: 'me.posts', component: UserPostComponent, meta: { middleware: [ auth ] } },
                    { path: 'comments', name: 'me.comments', component: UserCommentComponent, meta: { middleware: [ auth ] } },
                ]
            },
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
    {
        path: '/admin',
        component: AdminComponent,
        meta: { middleware: [ auth, admin ] },
        children: [
            { path: '', name: 'admin', component: ItemsComponent, meta: { middleware: [ auth, admin ] } },
            { path: 'posts/:id', name: 'admin.post', component: ItemComponent, meta: { middleware: [ auth, admin ] } },
        ]
    },
    { path: '*', name: 'notfound', component: NotFound }
];

export default routes;



