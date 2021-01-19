<template>
    <li class="nav-item dropdown" >
        <a class="nav-link" data-toggle="dropdown" @click.prevent="markAsRead">
            <i class="fas fa-bell fa-2x"></i>
            <span class="badge badge-warning navbar-badge" style="font-size: 8px">{{unReadNotifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right" style="margin-top: 9px">
           <!-- <span class="dropdown-item dropdown-header">{{unReadNotifications.length}} Notifications</span>-->
            <a href="#" class="dropdown-item" v-for="(notification,index) in notifications">
                <i class="fas fa-envelope mr-2"></i>{{notification.data}}
                <span class="float-right text-muted text-sm">{{notification.created_at | date}}</span>
            </a>
        </div>
    </li>
</template>

<script>
    export default {
        name: "notifcation-bell",
        data(){
            return{
                notifications:{},
                unReadNotifications:{},

            }
        },
        methods:{
            getNotifications(){
                Vue.axios.get('/notifications').then((data)=>{
                    this.notifications=data.data
                })

            },
            getunReadNotifications(){
                Vue.axios.put('/notifications').then((data)=>{
                    this.unReadNotifications=data.data
                })

            },
            markAsRead(){
                if(this.unReadNotifications.length!==0){
                    Vue.axios.post('notifications').then(()=>{
                        Fire.$emit('loadUnReadNotifications');
                    });
                }
            },

        },
        created() {
            this.getNotifications();
            this.getunReadNotifications();
            Fire.$on('loadUnReadNotifications',()=>{
                this.getunReadNotifications();
            });
        }
    }

</script>

<style scoped>

</style>
