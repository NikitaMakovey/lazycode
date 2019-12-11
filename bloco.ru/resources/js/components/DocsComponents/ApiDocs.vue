<template>
    <v-simple-table fixed-header height="690px">
        <template v-slot:default>
            <thead>
            <tr>
                <th class="text-left">Метод</th>
                <th class="text-left">URI</th>
                <th class="text-left">Действие</th>
                <th class="text-left">Описание</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in docs" :key="item.id">
                <template v-if="item.method === 'GET'">
                    <td class="getStyle">{{ item.method }}</td>
                    <td class="getStyleInfo">{{ item.uri }}</td>
                    <td class="getStyleInfo">{{ item.action }}</td>
                    <td class="getStyleInfo">{{ item.description }}</td>
                </template>
                <template v-else-if="item.method === 'POST'">
                    <td class="postStyle">{{ item.method }}</td>
                    <td class="postStyleInfo">{{ item.uri }}</td>
                    <td class="postStyleInfo">{{ item.action }}</td>
                    <td class="postStyleInfo">{{ item.description }}</td>
                </template>
                <template v-else-if="item.method === 'PUT|PATCH'">
                    <td class="putStyle">{{ item.method }}</td>
                    <td class="putStyleInfo">{{ item.uri }}</td>
                    <td class="putStyleInfo">{{ item.action }}</td>
                    <td class="putStyleInfo">{{ item.description }}</td>
                </template>
                <template v-else>
                    <td class="deleteStyle">{{ item.method }}</td>
                    <td class="deleteStyleInfo">{{ item.uri }}</td>
                    <td class="deleteStyleInfo">{{ item.action }}</td>
                    <td class="deleteStyleInfo">{{ item.description }}</td>
                </template>
            </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    export default {
        data() {
            return {
                docs: [
                    {
                        id: 1,
                        method: 'GET',
                        uri: 'api/code/users',
                        action: 'UserController@index',
                        description: 'Получаю ответ с данными всех пользователей.'
                    },
                    {
                        id: 2,
                        method: 'GET',
                        uri: 'api/code/users/{user}',
                        action: 'UserController@show',
                        description: 'Получаю ответ с данными конкретного пользователя.'
                    },
                    {
                        id: 3,
                        method: 'GET',
                        uri: 'api/code/users/{user}/posts',
                        action: 'UserController@userPosts',
                        description: 'Получаю ответ с данными всех постов конкретного пользователя.'
                    },
                    {
                        id: 4,
                        method: 'GET',
                        uri: 'api/code/users/{user}/comments',
                        action: 'UserController@userComments',
                        description: 'Получаю ответ с данными всех комментариев конкретного пользователя..'
                    },
                    {
                        id: 5,
                        method: 'PUT|PATCH',
                        uri: 'api/code/users/{user}',
                        action: 'UserController@update',
                        description: 'Посылаю запрос на обновление данных конкретного пользователей.'
                    },
                    {
                        id: 7,
                        method: 'POST',
                        uri: 'api/register',
                        action: 'AuthController@register',
                        description: 'Посылаю запрос на создание нового пользователя.'
                    },
                    {
                        id: 8,
                        method: 'POST',
                        uri: 'api/login',
                        action: 'AuthController@login',
                        description: 'Посылаю запрос на проверку существующего пользователя с таким email и password.'
                    },
                    {
                        id: 9,
                        method: 'POST',
                        uri: 'api/logout',
                        action: 'AuthController@logout',
                        description: 'Посылаю запрос на удаление API-токена пользователя.'
                    },
                    {
                        id: 10,
                        method: 'GET',
                        uri: 'api/code/categories/{category}',
                        action: 'CategoryController@show',
                        description: 'Получаю ответ с данными всех постов конкретной категории.'
                    },
                    {
                        id: 11,
                        method: 'GET',
                        uri: 'api/code/posts',
                        action: 'PostController@index',
                        description: 'Получаю ответ с данными всех постов.'
                    },
                    {
                        id: 12,
                        method: 'POST',
                        uri: 'api/code/posts',
                        action: 'PostController@store',
                        description: 'Посылаю запрос на создание нового поста.'
                    },
                    {
                        id: 13,
                        method: 'GET',
                        uri: 'api/code/posts/{post}',
                        action: 'PostController@show',
                        description: 'Получаю ответ с данными конкретного поста.'
                    },
                    {
                        id: 14,
                        method: 'PUT|PATCH',
                        uri: 'api/code/posts/{post}',
                        action: 'PostController@update',
                        description: 'Посылаю запрос на обновление данных конкретного поста.'
                    },
                    {
                        id: 15,
                        method: 'GET',
                        uri: 'api/code/posts/{post}/comments',
                        action: 'PostController@postComments',
                        description: 'Получаю ответ с данными всех комментариев конкретного поста.'
                    },
                    {
                        id: 16,
                        method: 'DELETE',
                        uri: 'api/code/posts/{post}',
                        action: 'PostController@destroy',
                        description: 'Посылаю запрос на удаление конкретного поста.'
                    },
                    {
                        id: 17,
                        method: 'POST',
                        uri: 'api/code/comments',
                        action: 'CommentController@store',
                        description: 'Посылаю запрос на создание нового комментария.'
                    },
                    {
                        id: 18,
                        method: 'DELETE',
                        uri: 'api/code/comments/{comment}',
                        action: 'CommentController@destroy',
                        description: 'Посылаю запрос на удаление конкретного комемнтария.'
                    },
                    {
                        id: 19,
                        method: 'POST',
                        uri: 'api/code/votes',
                        action: 'VoteController@store',
                        description: 'Посылаю запрос на создание или обновление конкретной оценки.'
                    }
                ]
            }
        }
    }
</script>

<style scoped>
    .getStyle {
        background-color: #55ca89;
        color: #fff3cd;
        font-size: 1rem
    }
    .getStyleInfo {
        background-color: rgba(85,202,137,0.53);
        color: #15252a;
        font-size: 1rem
    }
    .postStyle {
        background-color: #646aca;
        color: #fff3cd;
        font-size: 1rem
    }
    .postStyleInfo {
        background-color: rgba(100,106,202,0.51);
        color: #15252a;
        font-size: 1rem
    }
    .putStyle {
        background-color: #a3a642;
        color: #fff3cd;
        font-size: 1rem
    }
    .putStyleInfo {
        background-color: rgba(163,166,66,0.51);
        color: #15252a;
        font-size: 1rem
    }
    .deleteStyle {
        background-color: #904a51;
        color: #fff3cd;
        font-size: 1rem
    }
    .deleteStyleInfo {
        background-color: rgba(144,74,81,0.5);
        color: #15252a;
        font-size: 1rem
    }
</style>
