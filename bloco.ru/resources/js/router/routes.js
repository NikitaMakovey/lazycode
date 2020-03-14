// Components
import SkeletonComponent from '../components/BaseComponents/SkeletonComponent';
import PostsMainComponent from "../components/PostComponents/MainComponent";
import MainCategoryComponent from "../components/PostComponents/MainCategoryComponent"
import PostComponent from "../components/PostComponents/PostComponent";
import EditPostComponent from "../components/PostComponents/EditComponent";
import DraftPostComponent from "../components/PostComponents/DraftComponent";
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

//
import AboutComponent from "../components/UserComponents/ProfileComponents/AboutComponent";
import UserPostComponent from "../components/UserComponents/ProfileComponents/PostComponent"
import UserCommentComponent from "../components/UserComponents/ProfileComponents/CommentComponent"

//
import MainEditComponent from "../components/UserComponents/EditComponents/MainEditComponent";
import EmailEditComponent from "../components/UserComponents/EditComponents/EmailEditComponent";
import PhotoEditComponent from "../components/UserComponents/EditComponents/PhotoEditComponent";
import AboutEditComponent from "../components/UserComponents/EditComponents/AboutEditComponent";

//
import HomeComponent from "../components/UserComponents/HomeComponent";
import PublishComponent from "../components/UserComponents/HomeComponents/PublishComponent";
import ProcessComponent from "../components/UserComponents/HomeComponents/ProcessComponent";
import RejectComponent from "../components/UserComponents/HomeComponents/RejectComponent";
import DraftComponent from "../components/UserComponents/HomeComponents/DraftComponent";
import ConfirmationComponent from "../components/UserComponents/EditComponents/ConfirmationComponent";
import ConfirmEmailComponent from "../components/UserComponents/ConfirmEmailComponent";
import EditItemsComponent from "../components/AdminComponents/EditItemsComponent";
import EditItemComponent from "../components/AdminComponents/EditItemComponent";
import ComputerGraphicsComponent from "../components/LabComponents/ComputerGraphicsComponent";

const routes = [
    { path: '/', component: SkeletonComponent,
        children: [
            { path: '', name: 'main', component: PostsMainComponent },
            { path: 'categories/:slug', name: 'category', component: MainCategoryComponent },
            { path: 'posts/:id', name: 'post', component: PostComponent },
            { path: 'posts/:id/edit', name: 'post.edit', component:  EditPostComponent, meta: { middleware: [ auth ] } },
            { path: 'posts/:id/draft', name: 'post.draft', component:  DraftPostComponent, meta: { middleware: [ auth ] } },
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
            { path: 'settings/', name: 'me.edit', component: EditUserComponent,
                children: [
                    { path: 'main', name: 'edit.info', component: MainEditComponent, meta: { middleware: [ auth ] } },
                    { path: 'email', name: 'edit.email', component: EmailEditComponent, meta: { middleware: [ auth ] } },
                    { path: 'confirm', name: 'edit.confirm', component: ConfirmationComponent, meta: { middleware: [ auth ] } },
                    { path: 'photo', name: 'edit.photo', component: PhotoEditComponent, meta: { middleware: [ auth ] } },
                    { path: 'about', name: 'edit.about', component: AboutEditComponent, meta: { middleware: [ auth ] } },
                ]
            },
            { path: 'home/', name: 'me.edit', component: HomeComponent,
                children: [
                    { path: 'publish', name: 'home.publish', component: PublishComponent, meta: { middleware: [ auth ] } },
                    { path: 'process', name: 'home.process', component: ProcessComponent, meta: { middleware: [ auth ] } },
                    { path: 'reject', name: 'home.reject', component: RejectComponent, meta: { middleware: [ auth ] } },
                    { path: 'draft', name: 'home.draft', component: DraftComponent, meta: { middleware: [ auth ] } },
                ]
            },
        ]
    },
    { path: '/auth', component: AuthLayout,
        children: [
            { path: 'register', name: 'auth.register', component: Register, meta: { middleware: [ guest ] } },
            { path: 'login', name: 'auth.login', component: Login, meta: { middleware: [ guest ] } },
            { path: 'reset/email', name: 'auth.email', component: ResetEmail },
        ]
    },
    { path: '/reset/:code/p/:token', name: 'reset.password', component: ResetPassword },
    { path: '/confirm/:code', name: 'config.email', component: ConfirmEmailComponent },
    {
        path: '/admin',
        component: AdminComponent,
        meta: { middleware: [ auth, admin ] },
        children: [
            { path: '', name: 'admin', component: ItemsComponent, meta: { middleware: [ auth, admin ] } },
            { path: 'posts/:id', name: 'admin.post', component: ItemComponent, meta: { middleware: [ auth, admin ] } },
            { path: 'edits', name: 'admin.edits', component: EditItemsComponent, meta: { middleware: [ auth, admin ] } },
            { path: 'edits/:id', name: 'admin.edit', component: EditItemComponent, meta: { middleware: [ auth, admin ] } },
        ]
    },
    { path: '/labs/graph', name: 'computer_graphics', component: ComputerGraphicsComponent },
    { path: '*', name: 'notfound', component: NotFound }
];

export default routes;



