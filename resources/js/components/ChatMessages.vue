
<template>
    <div>
        <li class="list-group-item" v-for="(message,index) in messages" :key="index">
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">
                        {{ message.user.name }}
                    </strong>
                </div>
                <p >
                    {{ message.message }}
                </p>
            </div>
        </li>
    </div>
</template>

<script>
    export default {
        props: ['messages'],
            };
</script>
