<template>
    <div class="input_typing">
        <div class="input-group">
            <input
                    @keydown="sendTyping"
                    id="btn-input"
                    type="text"
                    name="message"
                    class="form-control input-sm"
                    placeholder="Type your message here..."
                    v-model="newMessage"
                    @keyup.enter="sendMessage">

            <span class="input-group-btn">
                <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                    Send
                </button>
            </span>
        </div>
            <span class="text-muted" v-if="userTyping">someone is typing...</span>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                newMessage: '',
                userTyping: false,
                timer:false
            }
        },
    created() {
        Echo.join('chat')
            .listenForWhisper("typing",Typing =>{
                this.userTyping = Typing;
                if(this.timer){clearTimeout(this.timer)};
                this.timer = setTimeout(() => {
                    this.userTyping = false;
                }, 1000);
            });
    },
        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage
                });
                this.newMessage = ''
            },
            sendTyping(){
               Echo.join('chat').whisper("typing",true)
            }
          
        }
    }
</script>