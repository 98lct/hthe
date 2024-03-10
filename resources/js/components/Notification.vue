<template>
    <ul>
        <li v-for="notification in notifications"  :class="notification.is_read == 0 ? 'not-read' : ''">
            <a href="#">
                <div class="drop_avatar">
                    <img :src="'/uploads/users/' + notification.user.profile_img" alt="">
                </div>
                <span v-if="notification.type == 0" class="drop_icon bg-gradient-primary">
                    <i class="icon-feather-thumbs-up"></i>
                </span>
                <span v-if="notification.type == 1" class="drop_icon share-bg">
                    <i class="icon-feather-share-2"></i>
                </span>
                <span v-if="notification.type == 2" class="drop_icon comment-bg">
                    <i class="icon-feather-message-circle"></i>
                </span>
                <span v-if="notification.type == 3" class="drop_icon change-profile-bg">
                    <i class="icon-feather-image"></i>
                </span>
                <span v-if="notification.type == 4" class="drop_icon friend-bg">
                    <i class="icon-feather-user-plus"></i>
                </span>
                <span v-if="notification.type == 5" class="drop_icon follow-bg">
                    <i class="icon-feather-bookmark"></i>
                </span>
                <span v-if="notification.type == 6" class="drop_icon newitem-bg">
                    <i class="icon-feather-clipboard"></i>
                </span>
                <span v-if="notification.type == 7" class="drop_icon newitem-bg">
                    <i class="icon-feather-film"></i>
                </span>
                <span v-if="notification.type == 8" class="drop_icon newitem-bg">
                    <i class="icon-feather-image"></i>
                </span>
                <div class="drop_text">
                    <p>
                    <strong>{{ notification.user.full_name ?? notification.user.username}}</strong> {{ renderContentNotification(notification.type, notification.notifiable_type) }}
                    <span class="text-link">{{ notification.title }} </span>
                    </p>
                    <time> {{ moment.unix(notification.created_at).startOf('minute').fromNow()
                    }} </time>
                </div>
            </a>
        </li>
    </ul>
</template>
<script setup>
import moment from 'moment';
</script>
<script>
export default {
    props: ['notifications'],
    data: () => {
        return {

        }
    },
    methods: {
        renderContentNotification(type, object){
            let text
            let model = object.split("\\")[2].toLowerCase()
            switch (type) {
                case '0':
                    text = 'react your ' + model
                    break;
                case '1':
                    text = 'shared your ' + model
                    break;
                case '2' : {
                    if (model == 'comment') {
                        text = 'reply your comment'
                    } else {
                        text = 'commented your ' + model
                    }
                    break;
                }
                case '3':
                    text = 'changed profile'
                    break;
                default:
                    text = 'TEST'
                    break;
            }
            return text;
        }
    }
}
</script>