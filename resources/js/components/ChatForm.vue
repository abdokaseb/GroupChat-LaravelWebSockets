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
                <button class="btn btn-dark col-12 mt-3" id="btn-chat" @click="sendMessage">
                    Send
                </button>

            </span>
        </div>
            <span class="text-muted" v-if="userTyping">someone is typing...</span>
    </div>
</template>

<script>
    export default {
        props: ['user','room'],
        data() {
            return {
                newMessage: '',
                userTyping: false,
                timer:false
            }
        },
    created() {
         Echo.join('chat')
             .listenForWhisper("typing",typingData =>{
                 if (typingData.room == this.room){
                     this.userTyping = true;
                     if(this.timer){clearTimeout(this.timer)};
                     this.timer = setTimeout(() => {
                         this.userTyping = false;
                     }, 1000);
                 }
             });
    },
        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage,
                    room: this.room
                });
                this.newMessage = ''
            },
            sendTyping(){
               Echo.join('chat').whisper("typing",{
                   room: this.room
               })
            }
          
        }
    }
</script>
